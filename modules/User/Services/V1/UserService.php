<?php

declare(strict_types=1);

namespace Modules\User\Services\V1;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Base\Entities\V1\BaseModel;
use Modules\Base\Services\V1\BaseService;
use Modules\User\Contracts\Services\UserServiceInterface;
use Modules\User\Entities\V1\User;

class UserService extends BaseService implements UserServiceInterface
{
    public function model(): Authenticatable|BaseModel
    {
        return user();
    }

    public function getByMobile(string|int|null $mobile): ?User
    {
        return $this->model()->findByField('mobile', $mobile)->first();
    }

    public function updateSessionLocale(string $locale): void
    {
        session()->put('locale', $locale);
        cookie()->queue(cookie()->forever('filament_language_switch_locale', $locale));
        app()->setLocale($locale);
    }
}
