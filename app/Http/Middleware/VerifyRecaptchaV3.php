<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class VerifyRecaptchaV3
{
    public function handle(Request $request, Closure $next): Response
    {
        $method = strtoupper($request->getMethod());
        $shouldVerify = in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE'], true);
        if (!$shouldVerify) {
            return $next($request);
        }

        $secret = (string) config('services.recaptcha.secret', '');
        if ($secret === '') {
            // Allow when not configured (local/dev).
            return $next($request);
        }

        $token = (string) $request->header('X-Recaptcha-Token', '');
        $action = (string) $request->header('X-Recaptcha-Action', '');

        if ($token === '') {
            // In local/dev, allow requests even if the browser can't load/execute reCAPTCHA
            // (e.g. blocked script, offline, adblock). In production we enforce it.
            if (app()->environment('local')) {
                return $next($request);
            }
            return response()->json([
                'success' => false,
                'message' => 'reCAPTCHA token is missing',
                'errors' => [
                    'recaptcha' => ['Security verification failed. Please refresh the page and try again.'],
                ],
            ], 422);
        }

        try {
            $resp = Http::asForm()->timeout(5)->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secret,
                'response' => $token,
                'remoteip' => $request->ip(),
            ]);

            $data = $resp->json() ?: [];
            $success = (bool) ($data['success'] ?? false);
            $score = (float) ($data['score'] ?? 0.0);
            $respAction = (string) ($data['action'] ?? '');

            // Require minimum score; you can tune this later.
            $minScore = (float) config('services.recaptcha.min_score', 0.5);

            if (!$success || $score < $minScore) {
                Log::warning('reCAPTCHA v3 failed', [
                    'success' => $success,
                    'score' => $score,
                    'minScore' => $minScore,
                    'expectedAction' => $action,
                    'action' => $respAction,
                    'errors' => $data['error-codes'] ?? null,
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'reCAPTCHA verification failed',
                    'errors' => [
                        'recaptcha' => ['Security verification failed. Please refresh the page and try again.'],
                    ],
                ], 422);
            }

            // If Google provided an action, ensure it matches what the client claimed.
            if ($respAction !== '' && $action !== '' && $respAction !== $action) {
                Log::warning('reCAPTCHA action mismatch', [
                    'expectedAction' => $action,
                    'action' => $respAction,
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'reCAPTCHA action mismatch',
                    'errors' => [
                        'recaptcha' => ['Security verification failed. Please refresh the page and try again.'],
                    ],
                ], 422);
            }
        } catch (\Throwable $e) {
            Log::warning('reCAPTCHA verification error (continuing in local?)', [
                'message' => $e->getMessage(),
            ]);
            // In local/dev, allow. In production fail closed when secret configured.
            if (app()->environment('local')) {
                return $next($request);
            }
            return response()->json([
                'success' => false,
                'message' => 'reCAPTCHA verification error',
                'errors' => [
                    'recaptcha' => ['Security verification failed. Please refresh the page and try again.'],
                ],
            ], 422);
        }

        return $next($request);
    }
}

