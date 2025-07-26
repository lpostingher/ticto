<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class TimeEntryTypeEnum extends Enum
{
    const IN = 1;
    const OUT = 2;

    public static function getDescription($value): string
    {
        return match ($value) {
            self::IN => 'Entrada',
            self::OUT => 'Saída'
        };
    }
}
