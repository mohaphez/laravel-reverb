<?php

declare(strict_types=1);

namespace Modules\Base\Database\Factory\V1;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

abstract class BaseFactory extends Factory
{
    /**
     * Construct the factory
     */
    public function __construct($count = null, Collection $states = null, Collection $has = null, Collection $for = null, Collection $afterMaking = null, Collection $afterCreating = null, $connection = null, Collection $recycle = null)
    {
        parent::__construct($count, $states, $has, $for, $afterMaking, $afterCreating, $connection, $recycle);

        $this->model = $this->model();
    }

    /**
     * Get the target model
     */
    abstract public function model(): string;
}
