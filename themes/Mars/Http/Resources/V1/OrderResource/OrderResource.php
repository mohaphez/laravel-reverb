<?php

declare(strict_types=1);

namespace Themes\Mars\Http\Resources\V1\OrderResource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Base\Http\Resources\API\V1\BaseAPIResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'client_id'  => $this->client_id,
            'total'      => $this->total_price,
            'volume'     => $this->fuel_volume,
            'status'     => $this->status->name,
            'created_at' => $this->created_at,
            'delivery_date' => $this->delivery_date,
        ];
    }
}
