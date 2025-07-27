<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

class UserRoleEnum extends Enum
{
    public const EMPLOYEE = 'employee';
    public const ADMIN = 'admin';

    public static function getDescription(mixed $value): string
    {
        $values = [
            self::EMPLOYEE => 'Funcionário',
            self::ADMIN => 'Administrador'
        ];

        return $values[$value] ?? $values[self::EMPLOYEE];
    }
}
