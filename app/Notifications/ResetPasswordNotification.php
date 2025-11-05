<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class ResetPasswordNotification extends ResetPassword
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('SEMS - Password Reset Request')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('You are receiving this email because we received a password reset request for your SEMS account.')
            ->action('Reset Password', $url)
            ->line('This password reset link will expire in ' . config('auth.passwords.users.expire', 60) . ' minutes.')
            ->line('If you did not request a password reset, no further action is required.')
            ->salutation('Best regards, SEMS Team')
            ->line('University of Baguio');
    }

    /**
     * Get the reset password notification mail message for the given URL.
     *
     * @param  string  $url
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject('SEMS - Password Reset Request')
            ->greeting('Hello!')
            ->line('You are receiving this email because we received a password reset request for your SEMS account.')
            ->action('Reset Password', $url)
            ->line('This password reset link will expire in ' . config('auth.passwords.users.expire', 60) . ' minutes.')
            ->line('If you did not request a password reset, no further action is required.')
            ->salutation('Best regards, SEMS Team')
            ->line('University of Baguio');
    }
}
