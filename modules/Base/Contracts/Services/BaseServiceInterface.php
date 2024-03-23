<?php

declare(strict_types=1);

namespace Modules\Base\Contracts\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Base\Entities\V1\BaseModel;

interface BaseServiceInterface
{
    public function index(?array $column = ['*'], ?array $filters = null, ?string $sort = "desc", null|int|string $paginate = null): Collection|LengthAwarePaginator;

    public function find(int $id): ?object;

    public function show(int $id): ?BaseModel;

    public function create(array $data): BaseModel;

    public function edit(int $id): ?BaseModel;

    public function update(int $id, array $data): ?BaseModel;

    public function destroy(int $id): void;

    public function firstOrCreate(array $attributes, array $data): object;

    public function updateOrCreate(array $attributes, array $data): object;

    public function getActiveItems(?array $column = ['*'], ?array $filters = null, ?string $sort = "desc", null|int|string $paginate = null): Collection|LengthAwarePaginator;
}
