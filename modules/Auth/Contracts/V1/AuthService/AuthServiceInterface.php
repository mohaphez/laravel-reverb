<?php

declare(strict_types=1);

namespace Modules\Auth\Contracts\V1\AuthService;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Modules\Auth\DTOs\V1\RegisterDTO;

interface AuthServiceInterface
{
    /**
     * Creates a token for the given user.
     *
     * @param Model $user The user model to create the token for.
     * @param array $abilities
     * @param DateTimeInterface|null $expiresAt
     * @return string The plain text token created for the user.
     */
    public function createToken(Model $user, array $abilities = ['*'], DateTimeInterface $expiresAt = null): string;

    /**
     * Authenticate the user by the given user id.
     *
     * @param int $userId The user id to authenticate.
     * @return void
     */
    public function authUserById(int $userId): void;

    /**
     *
     * Check if the user credentials are valid.
     * @param array $credentials The user credentials to check.
     * @return bool True if the user credentials are valid, false otherwise.
     */
    public function isUserCredentialsValid(array $credentials): bool;

    /**
     * Registers a user.
     *
     * @param RegisterDTO $data The data for the registration.
     * @param bool $isSocialRegistration Indicates if it is a social registration.
     * @return Model The registered user model.
     */
    public function register(RegisterDTO $data, bool $isSocialRegistration = false): Model;
}
