<?php

namespace Tests\Managers;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

trait UserManager
{
    /**
     * Create a new user.
     *
     * @param array<string, mixed> $attributes
     * @return User
     */
    public function createUser(array $attributes = []): User
    {
        return User::factory()
            ->createOne($attributes);
    }

    /**
     * Create a new user.
     *
     * @param mixed $array
     * @param int $count
     * @return Collection<int, User>
     */
    public function createManyUsers(mixed $array = [], int $count = 10): Collection
    {
        $has = fn($index) => is_array($array) && array_is_list($array) && !empty($array)
            ? $array[$index]
            : $array ?? [];

        return Collection::make(array_fill(0, $count, null))
            ->map(fn($value, $index) => $this->createUser($has($index)));
    }
}
