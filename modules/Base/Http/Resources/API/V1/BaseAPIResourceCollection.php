<?php

declare(strict_types=1);

namespace Modules\Base\Http\Resources\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseAPIResourceCollection extends ResourceCollection
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
        return [];
    }

    /**
     * Get the extras
     *
     * @return array[]
     */
    protected function extra(): array
    {
        /**
         * @var LengthAwarePaginator $paginator
         */
        $paginator = $this->resource;

        return [
            'links' => [
                'first' => $paginator->url(1),
                'last'  => $paginator->url($paginator->lastPage()),
                'prev'  => $paginator->previousPageUrl(),
                'next'  => $paginator->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'from'         => $paginator->firstItem(),
                'last_page'    => $paginator->lastItem(),
                'links'        => $paginator->linkCollection(),
                'path'         => $paginator->path(),
                'per_page'     => $paginator->perPage(),
                'to'           => $paginator->lastItem(),
                'total'        => $paginator->total()
            ]
        ];
    }
}
