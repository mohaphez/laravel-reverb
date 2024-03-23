<?php

declare(strict_types=1);

namespace Modules\User\Entities\V1;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\User\Database\Factories\V1\UserFactory;
use Modules\User\Enums\V1\AccountStatus\AccountStatus;
use Modules\User\Enums\V1\AccountType\AccountType;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasName, MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use Notifiable;
    use SoftDeletes;

    protected static function newFactory()
    {
        return UserFactory::new();
    }

    protected $fillable = [
        'email',
        'password',
        'name',
        'account_type',
        'account_status',
        'limitation_end_date',
        'last_login_date',
        'email_verified_at'
    ];

    protected $casts = [
        'account_status'      => AccountStatus::class,
        'account_type'        => AccountType::class,
        'limitation_end_date' => 'datetime',
        'last_login_date'     => 'datetime',
        'email_verified_at'   => 'datetime',
        'created_at'          => 'datetime',
    ];

    /**
     * Determines whether the user can access the panel.
     *
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return AccountStatus::Free === optional(auth()->user())->account_status &&
            in_array(
                optional(auth()->user())->account_type->value,
                [
                    AccountType::Manager->value,
                    AccountType::Sudo->value
                ]
            );
    }

    /**
     * Retrieves the filament name.
     *
     */
    public function getFilamentName(): string
    {
        return $this->name;
    }
}
