<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Application Received</title>
  </head>
  <body style="font-family: Arial, sans-serif; line-height: 1.5; color: #111827;">
    <div style="max-width: 680px; margin: 0 auto; padding: 24px;">
      <h2 style="margin: 0 0 8px;">Your application was received</h2>
      <p style="margin: 0 0 16px; color: #374151;">
        Dear {{ $admission->name }}, thank you for applying to Phaung Daw Oo International University.
      </p>

      <div style="border: 1px solid #E5E7EB; border-radius: 12px; padding: 16px; background: #F9FAFB;">
        <p style="margin: 0 0 8px;"><strong>Applied course:</strong> {{ $courseTitle ?? ('Course #' . ($admission->course_id ?? '-')) }}</p>
        <p style="margin: 0;"><strong>We received your submission on:</strong> {{ optional($admission->created_at)->format('Y-m-d H:i') }}</p>
      </div>

      <p style="margin: 16px 0 0; color: #374151;">
        Our team will review your application and contact you if you are eligible.
      </p>
      <p style="margin: 8px 0 0; color: #374151;">
        If you have questions, please contact us at <strong>+09-793200074</strong>.
      </p>

      <hr style="margin: 24px 0; border: none; border-top: 1px solid #E5E7EB;" />
      <p style="margin: 0; font-size: 12px; color: #6B7280;">
        This is an automated email. Please do not reply.
      </p>
    </div>
  </body>
</html>

