<?php

namespace App\Enum;

enum TaskPriority : string
{
    case LOW= 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
    public static function getPriorities(): array
    {
        return [
            self::LOW,
            self::MEDIUM,
            self::HIGH,
        ];
    }
    public function label(): string
    {
        return match ($this) {
            self::LOW => 'low',
            self::MEDIUM => 'medium',
            self::HIGH => 'high',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::LOW => 'bg-white',
            self::MEDIUM => 'bg-yellow-500',
            self::HIGH => 'bg-red-500',
        };
    }
}