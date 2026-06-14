<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>New Course Comment</title>
  </head>
  <body style="font-family: Arial, sans-serif; line-height: 1.5; color: #111827;">
    <div style="max-width: 680px; margin: 0 auto; padding: 24px;">
      <h2 style="margin: 0 0 8px;">New course comment received</h2>
      <p style="margin: 0 0 16px; color: #374151;">
        A visitor left a comment on a course page.
      </p>

      <div style="border: 1px solid #E5E7EB; border-radius: 12px; padding: 16px; background: #F9FAFB;">
        <p style="margin: 0 0 8px;"><strong>Name:</strong> {{ data_get($data, 'name', '-') }}</p>
        <p style="margin: 0 0 8px;"><strong>Email:</strong> {{ data_get($data, 'email', '-') }}</p>
        <p style="margin: 0 0 8px;"><strong>Comment:</strong><br />{{ data_get($data, 'comment', data_get($data, 'message', '-')) }}</p>
        @if (!empty($courseLink))
          <p style="margin: 0;">
            <a href="{{ $courseLink }}">Open course page</a>
          </p>
        @endif
      </div>
    </div>
  </body>
</html>
