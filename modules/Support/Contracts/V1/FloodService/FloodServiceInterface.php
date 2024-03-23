<?php

declare(strict_types=1);

namespace Modules\Support\Contracts\V1\FloodService;

interface FloodServiceInterface
{
    /**
     * Limit Using
     *
     * @param string $uniqueIdentifier
     *
     * @return $this
     */
    public function using(string $uniqueIdentifier): self;

    /**
     * Limit For
     *
     * @param int $ttl
     *
     * @return $this
     */
    public function for(int $ttl): self;

    /**
     * Start Limiting
     *
     * @return self
     */
    public function limitFromNow(): self;

    /**
     * Limit if free
     *
     * @return $this
     */
    public function limitIfFree(): self;

    /**
     * Check is limited or not?
     *
     * @return bool
     */
    public function isLimited(): bool;

    /**
     * Rescue the limited user
     *
     * @return bool
     */
    public function rescue(): bool;

    /**
     * Get the key
     *
     * @return string
     */
    public function key(): string;
}
