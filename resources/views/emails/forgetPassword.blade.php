<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Password Reset</title>
  </head>
  <body style="font-family: Arial, sans-serif; line-height: 1.5; color: #111827;">
    <div style="max-width: 680px; margin: 0 auto; padding: 24px;">
      <h2 style="margin: 0 0 8px;">Reset your password</h2>
      <p style="margin: 0 0 16px; color: #374151;">
        Hello {{ $user->name ?? 'there' }}, use the link below to reset your PIU account password.
      </p>
      <p style="margin: 0 0 16px;">
        <a href="{{ url('/reset-password?token=' . urlencode($token) . '&email=' . urlencode($user->email)) }}" style="display: inline-block; padding: 10px 14px; background: #1D4ED8; color: #ffffff; text-decoration: none; border-radius: 8px;">
          Reset Password
        </a>
      </p>
      <p style="margin: 0; font-size: 12px; color: #6B7280;">
        If you did not request a password reset, you can ignore this email.
      </p>
    </div>
  </body>
</html>
