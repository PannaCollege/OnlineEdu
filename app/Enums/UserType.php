<?php

namespace App\Enums;

enum UserType: string
{
    case ADMIN = 'admin';
    case INSTRUCTOR = 'instructor';
    case USER = 'user';

    public static function __callStatic($name, $arguments)
    {
        return constant("self::{$name}")->value;
    }

    public static function get(): array
    {
        $userType = array_column(self::cases(), 'value');

        return collect($userType)
            ->map(function ($type) {
                return [
                    $type => ucwords($type)
                ];
            })
            ->collapse()
            ->toArray();
    }
}
