<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

class TimeEntryTypeEnum extends Enum
{
    public const IN = 1;
    public const OUT = 2;

    public static function getDescription($value): string
    {
        return match ($value) {
            self::IN => 'Entrada',
            self::OUT => 'Saída'
        };
    }
}
