<?php

namespace App\Support;

use Firebase\JWT\JWK;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GoogleIdTokenVerifier
{
    private const JWKS_URL = 'https://www.googleapis.com/oauth2/v3/certs';
    private const VALID_ISSUERS = ['accounts.google.com', 'https://accounts.google.com'];
    private const JWKS_CACHE_KEY = 'google_oauth_jwks';
    private const JWKS_CACHE_SECONDS = 3600;

    /**
     * Verify a Google "Sign in with Google" ID token (a signed JWT
     * obtained client-side via Google's own SDK) and return its decoded
     * claims.
     *
     * Follows Google's documented verification steps exactly:
     * https://developers.google.com/identity/gsi/web/guides/verify-google-id-token
     *   1. Signature is verified against Google's published public keys.
     *   2. exp (expiry) is verified — handled by JWT::decode() itself.
     *   3. iss must be accounts.google.com or https://accounts.google.com.
     *   4. aud must equal our app's configured Google OAuth client ID.
     *
     * Throws \RuntimeException with a safe, generic message on any
     * failure — callers should catch this and return a 401, never the
     * underlying detail, to avoid giving an attacker a verification oracle.
     *
     * @return array{sub:string,email:?string,email_verified:bool,name:?string,picture:?string}
     */
    public static function verify(string $idToken): array
    {
        $clientId = (string) config('services.google.client_id', '');
        if ($clientId === '') {
            throw new \RuntimeException('Google login is not configured.');
        }

        try {
            $keySet = self::fetchKeySet();
            $payload = JWT::decode($idToken, $keySet);
        } catch (\Throwable $e) {
            throw new \RuntimeException('Invalid Google token.', previous: $e);
        }

        $iss = (string) ($payload->iss ?? '');
        if (!in_array($iss, self::VALID_ISSUERS, true)) {
            throw new \RuntimeException('Invalid Google token issuer.');
        }

        $aud = (string) ($payload->aud ?? '');
        if (!hash_equals($clientId, $aud)) {
            throw new \RuntimeException('Invalid Google token audience.');
        }

        $sub = (string) ($payload->sub ?? '');
        if ($sub === '') {
            throw new \RuntimeException('Invalid Google token subject.');
        }

        return [
            'sub' => $sub,
            'email' => isset($payload->email) ? (string) $payload->email : null,
            'email_verified' => (bool) ($payload->email_verified ?? false),
            'name' => isset($payload->name) ? (string) $payload->name : null,
            'picture' => isset($payload->picture) ? (string) $payload->picture : null,
        ];
    }

    /**
     * Fetch (and cache) Google's current JSON Web Key Set used to verify
     * ID token signatures. Cached for an hour — Google rotates these
     * keys infrequently and documents that clients should cache them
     * rather than fetching on every request.
     */
    private static function fetchKeySet(): array
    {
        $jwks = Cache::remember(self::JWKS_CACHE_KEY, self::JWKS_CACHE_SECONDS, function () {
            $response = Http::timeout(5)->get(self::JWKS_URL);

            if (!$response->successful()) {
                throw new \RuntimeException('Could not fetch Google verification keys.');
            }

            return $response->json();
        });

        if (!is_array($jwks) || empty($jwks['keys'])) {
            // Don't let a bad cached response keep failing every login
            // for an hour — clear it so the next attempt retries fresh.
            Cache::forget(self::JWKS_CACHE_KEY);
            throw new \RuntimeException('Could not fetch Google verification keys.');
        }

        return JWK::parseKeySet($jwks);
    }
}
