<?php

// Legacy no-captcha (reCAPTCHA v2) config. The React frontend and
// admission/contact API routes use reCAPTCHA v3 via VerifyRecaptchaV3
// and config/services.php (RECAPTCHA_SECRET_KEY). NOCAPTCHA_* env vars
// are not required and can be removed from production .env.

return [
    'secret' => env('NOCAPTCHA_SECRET'),
    'sitekey' => env('NOCAPTCHA_SITEKEY'),
    'options' => [
        'timeout' => 30,
    ],
];