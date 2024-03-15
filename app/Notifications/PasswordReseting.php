<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;

class PasswordReseting extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public User $user)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    { 
        $resetUrl = URL::signedRoute('password.reset', ['email' => $this->user->email,'token' => Password::createToken($this->user)]);
        Log::debug('Sending password reset notification to user: ' . $this->user->email);
        return (new MailMessage)
            ->line('Thank you for registering on our site! Please confirm your e-mail address at the link below!')
            ->subject("From: {env('APP_URL')}")
            ->line("To: {$this->user->name}") 
            ->action('Reset Password by this url: ', $resetUrl)
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
