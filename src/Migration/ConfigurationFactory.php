<?php

/**
 * ConfigurationFactory.php
 *
 * Author: Michael Leßnau <michael.lessnau@gmail.com>
 * Date:   2022-01-16
 */

declare(strict_types=1);

namespace BusFactor\LaminasDoctrine\Migration;

use Doctrine\DBAL\Platforms\DB2Platform;
use Doctrine\DBAL\Platforms\MariaDb1027Platform;
use Doctrine\DBAL\Platforms\MySQL57Platform;
use Doctrine\DBAL\Platforms\MySQL80Platform;
use Doctrine\DBAL\Platforms\MySQLPlatform;
use Doctrine\DBAL\Platforms\OraclePlatform;
use Doctrine\DBAL\Platforms\PostgreSQL100Platform;
use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\DBAL\Platforms\SqlitePlatform;
use Doctrine\DBAL\Platforms\SQLServerPlatform;
use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Metadata\Storage\TableMetadataStorageConfiguration;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use RuntimeException;

class ConfigurationFactory implements FactoryInterface
{
    private const DOCTRINE_PLATFORM_FQN_TO_NAME = [
        DB2Platform::class => 'Db2',
        MariaDb1027Platform::class => 'MariaDb',
        MySQL57Platform::class => 'Mysql',
        MySQL80Platform::class => 'Mysql',
        MySQLPlatform::class => 'Mysql',
        OraclePlatform::class => 'Oracle',
        PostgreSQL100Platform::class => 'PostgreSql',
        PostgreSQLPlatform::class => 'PostgreSql',
        SqlitePlatform::class => 'Sqlite',
        SQLServerPlatform::class => 'SqlServer',
    ];

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): Configuration
    {
        /** @var array<string, array<string, mixed>> $config */
        $config = $container->get('config');

        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        $platformFqn = get_class($entityManager->getConnection()->getDriver()->getDatabasePlatform());
        $platformName = self::DOCTRINE_PLATFORM_FQN_TO_NAME[$platformFqn] ?? null;

        if (empty($platformName)) {
            throw new RuntimeException('Unknown doctrine platform class: ' . $platformFqn);
        }

        $configuration = new Configuration();

        $configuration->setAllOrNothing(true);
        $configuration->setCheckDatabasePlatform(true);
        $configuration->setMetadataStorageConfiguration(new TableMetadataStorageConfiguration());

        foreach ($config['doctrine']['migrations']['migrations_base_directories'] ?? [] as $baseNamespace => $basePath) {
            $configuration->addMigrationsDirectory(
                $baseNamespace . '\\' . $platformName,
                $basePath . '/' . $platformName
            );
        }

        foreach ($config['doctrine']['migrations']['migrations_directories'] ?? [] as $namespace => $path) {
            $configuration->addMigrationsDirectory($namespace, $path);
        }

        return $configuration;
    }
}
