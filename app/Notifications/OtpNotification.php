<?php

namespace App\Notifications;

use App\Facades\Otp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
class OtpNotification extends Notification
{
    use Queueable;
    public $subject;
    public $fromEmail;
    public $mailer;
    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        $this->subject='Welcome to Our Application!';
        $this->fromEmail='test@cognme.com';
        $this->mailer='smtp';
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
        $otpDetails = Otp::generate($notifiable->email, 'numeric',4, 100); 
        return (new MailMessage)
            ->mailer($this->mailer)
            ->from($this->fromEmail, 'Cognme')
            ->subject($this->subject)
            ->greeting('Hello ' . $notifiable->name)
            ->line('Please use the following One-Time Password (OTP) to complete your password recovery:')
            ->line('**OTP: ' . $otpDetails->token . '**') 
            ->line('This password is only valid for the next 10 minutes. For your security, do not share this OTP with anyone.')
            ->salutation('Best Regards, Cognme Team');
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
