<?php

declare(strict_types=1);

namespace Modules\Travel\Http\Controllers\V1\API\Travel;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Modules\Travel\Enums\V1\TravelStatus\TravelStatus;
use Modules\Travel\Notifications\SendNotificationToDriver;
use Modules\Base\Http\Controllers\API\V1\BaseAPIController;
use Notification;

class TravelController extends BaseAPIController
{
    public function store(): JsonResponse
    {
        // Hard code passenger and driver id for test
        $user = auth()->user();
        $driver = user()->whereEmail('driver@example.com')->first();

        $travel = travel()->create([
            'passenger_id'  => $user->id,
            'driver_id'     => $driver->id,
            'tracking_code' => Str::uuid(),
            'status'        => TravelStatus::Pending
        ]);

        Notification::send($driver, new SendNotificationToDriver($travel));

        return $this->respondWithResource(
            resource: new JsonResource($travel),
            message:__('base::http_message.entity.created', ['entity' => 'travel'])
        );
    }
}
