<?php

/**
 * ConsoleCommandProvider.php
 *
 * Author: Michael Leßnau <michael.lessnau@gmail.com>
 * Date:   2022-01-16
 */

declare(strict_types=1);

namespace BusFactor\LaminasDoctrine\Orm;

use Doctrine\ORM\Tools\Console\Command\ClearCache\CollectionRegionCommand;
use Doctrine\ORM\Tools\Console\Command\ClearCache\EntityRegionCommand;
use Doctrine\ORM\Tools\Console\Command\ClearCache\MetadataCommand;
use Doctrine\ORM\Tools\Console\Command\ClearCache\QueryCommand;
use Doctrine\ORM\Tools\Console\Command\ClearCache\QueryRegionCommand;
use Doctrine\ORM\Tools\Console\Command\ClearCache\ResultCommand;
use Doctrine\ORM\Tools\Console\Command\GenerateProxiesCommand;
use Doctrine\ORM\Tools\Console\Command\InfoCommand;
use Doctrine\ORM\Tools\Console\Command\MappingDescribeCommand;
use Doctrine\ORM\Tools\Console\Command\RunDqlCommand;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand;
use Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand;
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
            $container->get(GenerateProxiesCommand::class),
            $container->get(InfoCommand::class),
            $container->get(MappingDescribeCommand::class),
            $container->get(RunDqlCommand::class),
            $container->get(ValidateSchemaCommand::class),
            $container->get(CollectionRegionCommand::class),
            $container->get(EntityRegionCommand::class),
            $container->get(MetadataCommand::class),
            $container->get(QueryCommand::class),
            $container->get(QueryRegionCommand::class),
            $container->get(ResultCommand::class),
            $container->get(CreateCommand::class),
            $container->get(DropCommand::class),
            $container->get(UpdateCommand::class),
        ];
    }
}
