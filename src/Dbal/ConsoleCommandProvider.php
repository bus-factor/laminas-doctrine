<?php

/**
 * ConsoleCommandProvider.php
 *
 * Author: Michael Leßnau <michael.lessnau@gmail.com>
 * Date:   2022-01-16
 */

declare(strict_types=1);

namespace BusFactor\LaminasDoctrine\Dbal;

use Doctrine\DBAL\Tools\Console\Command\ReservedWordsCommand;
use Doctrine\DBAL\Tools\Console\Command\RunSqlCommand;
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
            $container->get(ReservedWordsCommand::class),
            $container->get(RunSqlCommand::class),
        ];
    }
}
