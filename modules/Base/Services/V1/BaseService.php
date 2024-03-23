<?php

declare(strict_types=1);

namespace Modules\Base\Services\V1;

use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;
use Modules\Base\Contracts\Services\BaseServiceInterface;
use Modules\Base\Entities\V1\BaseModel;
use Modules\Support\Enums\V1\Status\Status;
use Throwable;

abstract class BaseService implements BaseServiceInterface
{
    protected Carbon $expire;
    protected Authenticatable|BaseModel $model;

    public function __construct()
    {
        $this->makeModel();
        $this->expire = Carbon::now()->addMinutes(config('cache.default_expire', 10));
    }

    abstract public function model(): Authenticatable|BaseModel;

    public function makeModel(): Authenticatable|BaseModel
    {
        $model = $this->model();

        return $this->model = $model;
    }


    public function index(?array $column = ['*'], ?array $filters = null, ?string $sort = "desc", null|int|string $paginate = null): Collection|LengthAwarePaginator
    {
        $query = $this->model
            ->query()
            ->select($column)
            ->when($filters, function ($q) use ($filters): void {
                $q->filter($filters);
            })
            ->orderBy('id', $sort);

        return (int)$paginate > 0 ? $query->paginate($paginate) : $query->get();
    }

    public function getActiveItems(?array $column = ['*'], ?array $filters = null, ?string $sort = "desc", null|int|string $paginate = null): Collection|LengthAwarePaginator
    {
        $query = $this->model
            ->select($column)
            ->when($filters, function ($q) use ($filters): void {
                $q->filter($filters);
            })
            ->where('status', Status::Active->value)
            ->orderBy('id', $sort);

        return (int)$paginate > 0 ? $query->paginate($paginate) : $query->get();
    }

    public function find(int $id): ?object
    {
        return $this->model
            ->query()
            ->where('id', $id)
            ->first();
    }

    public function show(int $id): BaseModel
    {
        return $this->find($id);
    }

    public function create(array $data): BaseModel
    {
        return $this->model->query()->create($data);
    }

    public function edit(int $id): ?BaseModel
    {
        return $this->find($id);
    }

    public function update(int $id, array $data): ?BaseModel
    {
        $success = $this->model->query()->where('id', $id)->update($data);

        if ($success) {
            return $this->find($id);
        }

        return null;
    }

    /**
     * @throws Throwable
     */
    public function destroy(int $id): void
    {
        $this->model->deleteOrFail($id);
    }

    public function firstOrCreate(array $attributes, array $data): object
    {
        return $this->model
            ->query()
            ->firstOrCreate($attributes, $data);
    }

    public function updateOrCreate(array $attributes, array $data): object
    {
        return $this->model
            ->query()
            ->updateOrCreate($attributes, $data);
    }
}
