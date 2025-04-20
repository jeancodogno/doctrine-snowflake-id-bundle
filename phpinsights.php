<?php

declare(strict_types=1);

use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenNormalClasses;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff;
use SlevomatCodingStandard\Sniffs\Functions\UnusedParameterSniff;

return [

    'preset' => 'default',

    'ide' => 'vscode',

    'exclude' => [
    ],

    'add' => [
        // Insights personalizados aqui, se quiser.
    ],

    'remove' => [
        ForbiddenNormalClasses::class,
        UnusedParameterSniff::class,
    ],

    'config' => [
        LineLengthSniff::class => [
            'lineLimit' => 120,
            'absoluteLineLimit' => 120,
            'ignoreComments' => true,
        ],
    ],

    'requirements' => [
        'min-quality' => 90,
        'min-architecture' => 85,
        'min-style' => 96,
    ],

    'threads' => null,

    'timeout' => 60,
];
