<?php

declare(strict_types=1);

namespace Modules\User\Contracts\Services;

use Modules\Base\Contracts\Services\BaseServiceInterface;
use Modules\User\Entities\V1\User;

interface UserServiceInterface extends BaseServiceInterface
{
    /**
     * Get user by mobile.
     */
    public function getByMobile(string|int|null $mobile): ?User;
}
