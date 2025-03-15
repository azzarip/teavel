<?php

namespace Azzarip\Teavel\Notifications;

use Illuminate\Bus\Queueable;
use Azzarip\Teavel\Models\Contact;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected $message, protected ?Contact $contact = null)
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
        return ['telegram'];
    }

    public function toTelegram(object $notifiable)
    {
        return (new TelegramMessage)
            ->to($notifiable->telegram_id)
            ->line($this->message)
            ->lineif( (bool) $this->contact, 'Name: ' . $this->contact?->full_name);
    }
}
