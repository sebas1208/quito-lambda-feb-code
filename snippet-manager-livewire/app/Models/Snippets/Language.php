<?php

namespace App\Models\Snippets;

enum Language: string
{
    case PHP = 'php';
    case JS = 'js';
    case JAVA = 'java';
    case CSharp = 'c#';
    case Haskell = 'haskell';
}
