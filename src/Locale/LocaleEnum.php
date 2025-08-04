<?php

namespace Azzarip\Teavel\Locale;

use Filament\Support\Contracts\HasLabel;

enum LocaleEnum: int implements HasLabel
{
    case English = 1;
    case Deutsch = 2;
    case Francais = 3;
    case Italiano = 4;

    public function getLabel(): string
    {
        return match ($this) {
            self::English => 'English',
            self::Deutsch => 'Deutsch',
            self::Francais => 'Français',
            self::Italiano => 'Italiano',
        };
    }

    public function code(): string
    {
        return match ($this) {
            self::English => 'en',
            self::Deutsch => 'de',
            self::Francais => 'fr',
            self::Italiano => 'it',
        };
    }

    public static function fromCode(string $code): ?self
    {
        return match ($code) {
            'en' => self::English,
            'de' => self::Deutsch,
            'fr' => self::Francais,
            'it' => self::Italiano,
            default => null,
        };
    }
}
