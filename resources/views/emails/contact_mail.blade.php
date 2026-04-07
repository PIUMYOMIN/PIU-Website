<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Contact Form Message</title>
  </head>
  <body style="font-family: Arial, sans-serif; line-height: 1.5; color: #111827;">
    <div style="max-width: 680px; margin: 0 auto; padding: 24px;">
      <h2 style="margin: 0 0 8px;">New contact form message</h2>
      <p style="margin: 0 0 16px; color: #374151;">
        You received a new message from the website contact form.
      </p>

      <div style="border: 1px solid #E5E7EB; border-radius: 12px; padding: 16px; background: #F9FAFB;">
        <p style="margin: 0 0 8px;"><strong>Name:</strong> {{ data_get($data, 'name', '-') }}</p>
        <p style="margin: 0 0 8px;"><strong>Email:</strong> {{ data_get($data, 'email', '-') }}</p>
        <p style="margin: 0 0 8px;"><strong>Phone:</strong> {{ data_get($data, 'phone', '-') }}</p>
        <p style="margin: 0 0 8px;"><strong>Country:</strong> {{ data_get($data, 'country', '-') }}</p>
        <p style="margin: 0;"><strong>Message:</strong><br />{{ data_get($data, 'message', '-') }}</p>
      </div>

      <hr style="margin: 24px 0; border: none; border-top: 1px solid #E5E7EB;" />
      <p style="margin: 0; font-size: 12px; color: #6B7280;">
        This is an automated email.
      </p>
    </div>
  </body>
</html>

