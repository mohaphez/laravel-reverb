<?php

declare(strict_types=1);

namespace Modules\Travel\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class SendNotificationToDriver extends Notification
{
    use Queueable;


    public function __construct(protected object $travel)
    {

    }

    public function via()
    {
        return ['broadcast'];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'user'          => fake()->name,
            'tracking_code' => fake()->bothify('?????-#####'),
            'date'          => now()->format('Y-m-d H:i:s'),
            'amount'        => random_int(140000, 5900000),
            'id'            => $this->travel->id
        ]);
    }

    public function broadcastType(): string
    {
        return 'broadcast.travel';
    }
}
