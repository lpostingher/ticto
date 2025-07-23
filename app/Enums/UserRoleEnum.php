<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserRoleEnum extends Enum
{
    const EMPLOYEE = 'employee';
    const ADMIN = 'admin';
}
