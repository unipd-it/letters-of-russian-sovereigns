<?php

declare(strict_types=1);

/*
 * This file is part of «Letters of Russian sovereigns to the Republic of Venice» database.
 *
 * Copyright (c) Department of Linguistic and Literary Studies of the University of Padova
 *
 * «Letters of Russian sovereigns to the Republic of Venice» database is free software:
 * you can redistribute it and/or modify it under the terms of the
 * GNU General Public License as published by the Free Software Foundation, version 3.
 *
 * «Letters of Russian sovereigns to the Republic of Venice» database is distributed
 * in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even
 * the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code. If you have not received
 * a copy of the GNU General Public License along with
 * «Letters of Russian sovereigns to the Republic of Venice» database,
 * see <http://www.gnu.org/licenses/>.
 */

$header = <<<'HEADER'
This file is part of «Letters of Russian sovereigns to the Republic of Venice» database.

Copyright (c) Department of Linguistic and Literary Studies of the University of Padova

«Letters of Russian sovereigns to the Republic of Venice» database is free software:
you can redistribute it and/or modify it under the terms of the
GNU General Public License as published by the Free Software Foundation, version 3.

«Letters of Russian sovereigns to the Republic of Venice» database is distributed
in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even
the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU General Public License for more details.

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code. If you have not received
a copy of the GNU General Public License along with
«Letters of Russian sovereigns to the Republic of Venice» database,
see <http://www.gnu.org/licenses/>.
HEADER;

return (new PhpCsFixer\Config())
    ->setRules([
        '@PHP56Migration' => true,
        '@PHP56Migration:risky' => true,
        '@PHP70Migration' => true,
        '@PHP70Migration:risky' => true,
        '@PHP71Migration' => true,
        '@PHP71Migration:risky' => true,
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'non_printable_character' => ['use_escape_sequences_in_strings' => true],
        'array_syntax' => ['syntax' => 'short'],
        'header_comment' => [
            'header' => $header,
        ],
        'combine_consecutive_issets' => true,
        'combine_consecutive_unsets' => true,
        'no_php4_constructor' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'ordered_class_elements' => true,
        'ordered_imports' => true,
        'phpdoc_order' => true,
        'single_line_throw' => false,
        'strict_comparison' => true,
        'strict_param' => true,
    ])
    ->setRiskyAllowed(true)
    ->setUsingCache(false)
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(['migrations', 'src', 'tests'])
            ->append(
                [
                    __FILE__,
                    '.phan.dist',
                    'bin/console',
                    'bin/phpunit',
                    'config/bootstrap.php',
                    'config/bundles.php',
                    'config/preload.php',
                    'public/index.php',
                ]
            )
    )
;
