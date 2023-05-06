<?php

/**
 * ConsoleCommandProvider.php
 *
 * Author: Michael Leßnau <michael.lessnau@gmail.com>
 * Date:   2022-01-16
 */

declare(strict_types=1);

namespace BusFactor\LaminasDoctrine\Migration;

use Doctrine\Migrations\Tools\Console\Command\CurrentCommand;
use Doctrine\Migrations\Tools\Console\Command\DiffCommand;
use Doctrine\Migrations\Tools\Console\Command\DumpSchemaCommand;
use Doctrine\Migrations\Tools\Console\Command\ExecuteCommand;
use Doctrine\Migrations\Tools\Console\Command\GenerateCommand;
use Doctrine\Migrations\Tools\Console\Command\LatestCommand;
use Doctrine\Migrations\Tools\Console\Command\MigrateCommand;
use Doctrine\Migrations\Tools\Console\Command\RollupCommand;
use Doctrine\Migrations\Tools\Console\Command\StatusCommand;
use Doctrine\Migrations\Tools\Console\Command\SyncMetadataCommand;
use Doctrine\Migrations\Tools\Console\Command\UpToDateCommand;
use Doctrine\Migrations\Tools\Console\Command\VersionCommand;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Console\Command\ListCommand;

class ConsoleCommandProvider
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function provideCommands(ContainerInterface $container): array
    {
        return [
            $container->get(CurrentCommand::class),
            $container->get(DiffCommand::class),
            $container->get(DumpSchemaCommand::class),
            $container->get(ExecuteCommand::class),
            $container->get(GenerateCommand::class),
            $container->get(LatestCommand::class),
            $container->get(ListCommand::class),
            $container->get(MigrateCommand::class),
            $container->get(RollupCommand::class),
            $container->get(StatusCommand::class),
            $container->get(SyncMetadataCommand::class),
            $container->get(UpToDateCommand::class),
            $container->get(VersionCommand::class),
        ];
    }
}
