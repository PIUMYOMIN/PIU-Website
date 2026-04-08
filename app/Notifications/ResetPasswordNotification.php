<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public function __construct(private string $token)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $frontendUrl = rtrim((string) env('FRONTEND_URL', 'https://www.piueducation.org'), '/');
        $resetUrl = $frontendUrl . '/reset-password?token=' . urlencode($this->token) . '&email=' . urlencode($notifiable->getEmailForPasswordReset());
        $expireMinutes = (int) config('auth.passwords.users.expire', 60);

        return (new MailMessage)
            ->subject('Reset Your PIU Account Password')
            ->greeting('Hello ' . ($notifiable->name ?: 'User') . ',')
            ->line('We received a request to reset your account password.')
            ->action('Reset Password', $resetUrl)
            ->line("This reset link will expire in {$expireMinutes} minutes.")
            ->line('If you did not request a password reset, please ignore this email.');
    }
}

