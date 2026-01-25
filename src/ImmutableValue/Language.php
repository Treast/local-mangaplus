<?php

namespace App\ImmutableValue;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum Language: string implements TranslatableInterface
{
    case Spanish = 'es';
    case French = 'fr';
    case English = 'en';
    case Deutsch = 'de';
    case Indonesian = 'id';
    case Portuguese = 'pt';
    case Russian = 'ru';
    case Thai = 'th';
    case Vietnamese = 'vt';

    public static function fromLanguageId(int $languageId): self
    {
        return match ($languageId) {
            1 => self::Spanish,
            2 => self::French,
            3 => self::Indonesian,
            4 => self::Portuguese,
            5 => self::Russian,
            6 => self::Thai,
            7 => self::Deutsch,
            9 => self::Vietnamese,
            default => self::English,
        };
    }

    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        return $translator->trans($this->value, [], 'languages', $locale);
    }
}
