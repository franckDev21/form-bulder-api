<?php

namespace App\Models\Enums;

enum FieldEnum: string {
    case TEXTAREA = 'textarea';
    case INPUT = 'input';
    case SELECT = 'select';
    case DATE = 'date';
    case HOURS = 'hours';

    public static function values(): array {
        return array_column(self::cases(), 'value');
    }
}
