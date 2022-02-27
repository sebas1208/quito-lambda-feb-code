<?php

namespace App\Models\Snippets;

enum Language: string
{
    case PHP = 'PHP';
    case JS = 'JS';
    case JAVA = 'JAVA';
    case CSHARP = 'CSHARP';
    case HASKELL = 'HASKELL';

    public function label(): string
    {
        return match ($this) {
            self::PHP => 'PHP',
            self::JS => 'Javascript',
            self::JAVA => 'Java',
            self::CSHARP => 'C#',
            self::HASKELL => 'Haskell',
        };
    }

    public static function fromLabel(string $label): Language
    {
        return match ($label) {
            'PHP' => self::PHP,
            'Javascript' => self::JS,
            'Java' => self::JAVA,
            'C#' => self::CSHARP,
            'Haskell' => self::HASKELL,
        };
    }
}
