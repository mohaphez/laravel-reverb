<?php

declare(strict_types=1);

namespace Modules\Travel\Entities\V1;

use Illuminate\Database\Eloquent\Model;
use Modules\Travel\Enums\V1\TravelStatus\TravelStatus;

class Travel extends Model
{
    protected $table = 'travels';

    protected $fillable = [
        'passenger_id',
        'driver_id',
        'status',
        'tracking_code'
    ];

    protected $casts = [
        'status' => TravelStatus::class,
    ];
}
