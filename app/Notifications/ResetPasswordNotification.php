<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public $code;
    public $expiration;
    public $userName;

    /**
     * Create a new notification instance.
     */
    public function __construct($code, $userName, $expiration)
    {
        $this->code = $code;
        $this->expiration = $expiration;
        $this->userName = $userName;
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
        return (new MailMessage)
            ->subject('Password Recovery Code')
            ->markdown('mail.recovery-mail', [
                'recoveryCode' => $this->code,
                "expiration" => $this->expiration,
                "user_name" => $this->userName,
            ]);
    }
}
