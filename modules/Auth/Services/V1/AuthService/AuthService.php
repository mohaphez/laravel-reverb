<?php

declare(strict_types=1);

namespace Modules\Auth\Services\V1\AuthService;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\Auth\Contracts\V1\AuthService\AuthServiceInterface;
use Modules\Auth\DTOs\V1\RegisterDTO;
use Modules\User\Enums\V1\AccountStatus\AccountStatus;
use Modules\User\Enums\V1\AccountType\AccountType;

use function bcrypt;

class AuthService implements AuthServiceInterface
{
    public function createToken(Model $user, array $abilities = ['*'], DateTimeInterface $expiresAt = null): string
    {
        return $user->createToken('auth_app_token', $abilities, $expiresAt)->plainTextToken;
    }

    public function authUserById(int $userId): void
    {
        Auth::loginUsingId($userId);
    }

    public function isUserCredentialsValid(array $credentials): bool
    {
        return Auth::attempt($credentials);
    }

    public function register(RegisterDTO $data, bool $isSocialRegistration = false): Model
    {
        $data->password = $this->getEncryptPassword($data->password ?? null);

        $additionalData = [
            'account_type'   => AccountType::Client,
            'account_status' => AccountStatus::Free,
        ];

        if ($isSocialRegistration) {
            $additionalData['email_verified_at'] = now();
        }

        $user = userService()
            ->firstOrCreate(
                attributes: ['email' => $data->email],
                data: array_merge($data->toArray(), $additionalData)
            );

        if ( ! $isSocialRegistration) {
            $user->sendEmailVerificationNotification();
        }

        return $user;
    }

    private function getEncryptPassword(?string $password): string
    {
        $password = $password ?? Str::password(8, true, true, false, false);

        return bcrypt($password);
    }
}
