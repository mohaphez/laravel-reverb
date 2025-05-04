<?php

declare(strict_types=1);

namespace Modules\User\Listeners\V1;

use Illuminate\Support\Facades\Log;
use Laravel\Reverb\Events\MessageReceived;

class HandleMessage
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(MessageReceived $event): void
    {
        $data = json_decode($event->message, true);


        if ('client-typing' === $data['event'] && str_contains($data['channel'], 'private-document')) {
            $userId = explode('.', $data['channel'])[1];
            $user = user()->where('id', $userId)->first();

            if ($user) {
                $user->description = $data['data']['content'];
                $user->save();

                Log::info('User description updated', [
                    'user_id' => $userId,
                    'content' => $data['data']['content']
                ]);
            }
        }

        // Keep general logging for debugging
        Log::info('Reverb Message Received', [
            'message'    => $event->message,
            'connection' => $event->connection,
            'channel'    => $data['channel'] ?? null,
            'event_type' => $data['event'] ?? null,
            'timestamp'  => now()->toDateTimeString(),
        ]);
    }
}
