<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>New Admission Application</title>
  </head>
  <body style="font-family: Arial, sans-serif; line-height: 1.5; color: #111827;">
    <div style="max-width: 680px; margin: 0 auto; padding: 24px;">
      <h2 style="margin: 0 0 8px;">New admission application received</h2>
      <p style="margin: 0 0 16px; color: #374151;">
        A new admission application has been submitted. Details are below.
      </p>

      <div style="border: 1px solid #E5E7EB; border-radius: 12px; padding: 16px; background: #F9FAFB;">
        <p style="margin: 0 0 8px;"><strong>Name:</strong> {{ $admission->name }}</p>
        <p style="margin: 0 0 8px;"><strong>Email:</strong> {{ $admission->email }}</p>
        <p style="margin: 0 0 8px;"><strong>Phone:</strong> {{ $admission->phone }}</p>
        <p style="margin: 0 0 8px;"><strong>Course:</strong> {{ $courseTitle ?? ('Course #' . ($admission->course_id ?? '-')) }}</p>
        <p style="margin: 0 0 8px;"><strong>City/Country:</strong> {{ $admission->city }}, {{ $admission->country }}</p>
        <p style="margin: 0;"><strong>Submitted at:</strong> {{ optional($admission->created_at)->format('Y-m-d H:i') }}</p>
      </div>

      <p style="margin: 16px 0 0; color: #374151;">
        You can review this application in the admin dashboard.
      </p>
      <p style="margin: 8px 0 0;">
        <a href="{{ $adminUrl }}" style="display: inline-block; padding: 10px 14px; background: #1D4ED8; color: #ffffff; text-decoration: none; border-radius: 8px;">
          Open Admissions Dashboard
        </a>
      </p>

      <hr style="margin: 24px 0; border: none; border-top: 1px solid #E5E7EB;" />
      <p style="margin: 0; font-size: 12px; color: #6B7280;">
        This is an automated notification from {{ config('app.name') }}.
      </p>
    </div>
  </body>
</html>

