<?php

namespace App\ImmutableValue;

enum Language: string
{
    case Spanish = 'es';
    case French = 'fr';
    case English = 'en';
    case Indonesian = 'id';
    case Portuguese = 'pt';
    case Russian = 'ru';
    case Thai = 'th';

    public static function fromLanguageId(int $languageId): self
    {
        return match ($languageId) {
            1 => self::Spanish,
            2 => self::French,
            3 => self::Indonesian,
            4 => self::Portuguese,
            5 => self::Russian,
            6 => self::Thai,
            default => self::English,
        };
    }
}
