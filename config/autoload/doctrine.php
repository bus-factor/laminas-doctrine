<?php

/**
 * doctrine.php
 *
 * Author: Michael Leßnau <michael.lessnau@gmail.com>
 * Date:   2022-01-16
 */

declare(strict_types=1);

return [
    'doctrine' => [
        'dbal' => [
            'connection' => [
                // connection config as per doctrine documentation
            ],
        ],
        'orm' => [
            'entity_paths' => [
                // absolute paths to the directories containing the entity classes
            ],
            'is_dev_mode' => true,
        ],
        'migrations' => [
            // these entries will be suffixed (namespace & path) with the underlying driver's name
            'migrations_base_directories' => [
                // namespace => path
            ],
            // these entries are used as provided
            'migrations_directories' => [
                // namespace => path
            ],
        ],
    ],
];
