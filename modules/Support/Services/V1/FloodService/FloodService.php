<?php

declare(strict_types=1);

namespace Modules\Support\Services\V1\FloodService;

use Throwable;
use Illuminate\Support\Facades\Cache;
use Modules\Support\Contracts\V1\FloodService\FloodServiceInterface;

class FloodService implements FloodServiceInterface
{
    protected string $identifier;
    protected int    $ttl = 120;
    protected const SUFFIX = '-fsx';
    protected const PREFIX = 'flood-';

    /**
     * Limit Using
     *
     * @param string $uniqueIdentifier
     *
     * @return $this
     */
    public function using(string $uniqueIdentifier): self
    {
        $this->identifier = $uniqueIdentifier;
        return $this;
    }

    /**
     * Limit For
     *
     * @param int $ttl
     *
     * @return $this
     */
    public function for(int $ttl): self
    {
        $this->ttl = $ttl;
        return $this;
    }

    /**
     * Start Limiting
     *
     * @return self
     */
    public function limitFromNow(): self
    {
        try {
            $this->rescue();
            Cache::set($this->key(), true, $this->ttl);
        } catch (Throwable $exception) {
            report($exception);
        }

        return $this;
    }

    /**
     * Limit if free
     *
     * @return $this
     */
    public function limitIfFree(): self
    {
        try {
            $this->isLimited() ?: $this->limitFromNow();
        } catch (Throwable $exception) {
            report($exception);
        }
        return $this;
    }

    /**
     * Check is limited or not?
     *
     * @return bool
     */
    public function isLimited(): bool
    {
        try {
            return Cache::has($this->key());
        } catch (Throwable $exception) {
            report($exception);

            return false;
        }
    }

    /**
     * Rescue the limited user
     *
     * @return bool
     */
    public function rescue(): bool
    {
        try {
            Cache::forget($this->key());

            return true;
        } catch (Throwable $exception) {
            report($exception);

            return false;
        }
    }

    /**
     * Get the key
     *
     * @return string
     */
    public function key(): string
    {
        return self::PREFIX.$this->identifier.self::SUFFIX;
    }
}
