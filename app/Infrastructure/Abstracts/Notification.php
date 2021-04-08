<?php

namespace App\Infrastructure\Abstracts;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification as BaseNotification;

/**
 * Class Notification
 *
 * @package App\Infrastructure\Abstracts
 */
abstract class Notification extends BaseNotification implements ShouldQueue
{
    use Queueable;

    /**
     * Tha data object for the notification.
     */
    public array $data;

    /**
     * The title for the notification.
     */
    protected string $title;

    /**
     * The variable for the actual notification message.
     */
    protected string $message;

    /**
     * The url for the notification.
     */
    protected string $url;

    /**
     * The color code for the notification.
     */
    protected string $color;

    /**
     * Create a new notification instance
     *
     * @param  array $data The data object for the notification.
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->onQueue('notifications');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via(): array
    {
        return ['mail', 'broadcast', 'database'];
    }

    /**
     * Get the broadcaster representation of the notification.
     *
     * @param  mixed $notifiable The database record for the notification
     * @return BroadcastMessage
     */
}
