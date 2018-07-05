<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $token;
    public function __construct($token) {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject('雜學校｜會員密碼重設連結ZA SHARE｜Reset Password')
            ->line('因收到您對於雜學校會員密碼重設的請求，請點擊以下按鈕，重新設定您的登入密碼。')
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('重設密碼 / Reset Password', 'https://zashare.org?reset_token='.$this->token)
            ->line('如您沒有要求重設密碼，則無需採取進一步的操作。')
            ->line('If you did not request a password reset, no further action is required.')
           ;

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
