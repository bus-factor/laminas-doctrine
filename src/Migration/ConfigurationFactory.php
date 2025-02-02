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
use Doctrine\DBAL\Platforms\MariaDB1010Platform;
use Doctrine\DBAL\Platforms\MariaDBPlatform;
use Doctrine\DBAL\Platforms\MySQL80Platform;
use Doctrine\DBAL\Platforms\MySQL84Platform;
use Doctrine\DBAL\Platforms\MySQLPlatform;
use Doctrine\DBAL\Platforms\OraclePlatform;
use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\DBAL\Platforms\SQLitePlatform;
use Doctrine\DBAL\Platforms\SQLServerPlatform;
use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Metadata\Storage\TableMetadataStorageConfiguration;
use Doctrine\ORM\EntityManager;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use RuntimeException;

class ConfigurationFactory implements FactoryInterface
{
    private const DOCTRINE_PLATFORM_FQN_TO_NAME = [
        DB2Platform::class => 'Db2',
        MariaDB1010Platform::class => 'MariaDb',
        MariaDBPlatform::class => 'MariaDb',
        MySQL80Platform::class => 'Mysql',
        MySQL84Platform::class => 'Mysql',
        MySQLPlatform::class => 'Mysql',
        OraclePlatform::class => 'Oracle',
        PostgreSQLPlatform::class => 'PostgreSql',
        SQLitePlatform::class => 'Sqlite',
        SQLServerPlatform::class => 'SqlServer',
    ];

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, string $requestedName, array|null $options = null): Configuration
    {
        /** @var array<string, array<string, mixed>> $config */
        $config = $container->get('config');

        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        $connection = $entityManager->getConnection();
        $platformFqn = get_class($connection->getDriver()->getDatabasePlatform($connection));
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
