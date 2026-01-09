<?php

namespace App\Enums;

enum TaskStatus: string
{
    case NEW = 'new';
    case IN_PROGRESS = 'in_progress';
    case IN_REVIEW = 'in_review';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match($this) {
            self::NEW => 'Новая',
            self::IN_PROGRESS => 'В работе',
            self::IN_REVIEW => 'На проверке',
            self::COMPLETED => 'Завершена',
            self::CANCELLED => 'Отменена',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
