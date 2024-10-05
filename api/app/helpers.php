<?php

use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Sanctum\Contracts\HasApiTokens;

if (!function_exists('s')) {
    /**
     * @param string $value
     * @return string
     */
    function s(string $value): string
    {
        return Str::of($value)
            ->start('%')
            ->replace(' ', '%')
            ->finish('%');
    }
}
if (!function_exists('access')) {
    /**
     * @param User|HasApiTokens $user
     * @param string $ability
     * @return bool
     */
    function access(User|HasApiTokens $user, string $ability): bool
    {
        return $user->tokenCan($ability) || $user->tokenCan('*');
    }
}