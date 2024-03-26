<?php

declare(strict_types=1);


use Modules\User\Entities\V1\User;

Broadcast::channel('travel-live-location.{tracking_code}', function (User $user, string $trackingCode) {
    $travel = travel()->where('tracking_code', $trackingCode)->first();
    return in_array($user->id, [$travel->passenger_id, $travel->driver_id]);
});

Broadcast::channel('users.{id}', fn ($user, $id) => (int) $user->id === (int) $id);
