<?php

/**
 * ConsoleCommandProvider.php
 *
 * Author: Michael Leßnau <michael.lessnau@gmail.com>
 * Date:   2022-01-16
 */

declare(strict_types=1);

namespace BusFactor\LaminasDoctrine;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class ConsoleCommandProvider
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function provideCommands(ContainerInterface $container): array
    {
        return [
            ...\BusFactor\LaminasDoctrine\Dbal\ConsoleCommandProvider::provideCommands($container),
            ...\BusFactor\LaminasDoctrine\Migration\ConsoleCommandProvider::provideCommands($container),
            ...\BusFactor\LaminasDoctrine\Orm\ConsoleCommandProvider::provideCommands($container),
        ];
    }
}
