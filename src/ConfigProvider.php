<?php

/**
 * ConfigProvider.php
 *
 * Author: Michael Leßnau <michael.lessnau@gmail.com>
 * Date:   2022-01-16
 */

declare(strict_types=1);

namespace BusFactor\LaminasDoctrine;

use BusFactor\LaminasDoctrine\Orm\SingleManagerProviderFactory;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Tools\Console\ConnectionProvider;
use Doctrine\DBAL\Tools\Console\ConnectionProvider\SingleConnectionProvider;
use Doctrine\Migrations\Configuration\Configuration as MigrationsConfiguration;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\ORM\Configuration as OrmConfiguration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use BusFactor\LaminasDoctrine\Dbal\ConnectionFactory;
use BusFactor\LaminasDoctrine\Dbal\SingleConnectionProviderFactory;
use BusFactor\LaminasDoctrine\Migration\ConfigurationFactory as MigrationsConfigurationFactory;
use BusFactor\LaminasDoctrine\Migration\DependencyFactoryFactory;
use BusFactor\LaminasDoctrine\Orm\ConfigurationFactory as OrmConfigurationFactory;
use BusFactor\LaminasDoctrine\Orm\EntityManagerFactory;
use Doctrine\ORM\Tools\Console\EntityManagerProvider;

class ConfigProvider
{
    /**
     * @return array<string, mixed>
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    /**
     * @return array<string, array<string, string>>
     */
    private function getDependencies(): array
    {
        return [
            'aliases' => [
                EntityManagerInterface::class => EntityManager::class,
                ConnectionProvider::class => SingleConnectionProvider::class,
            ],
            'factories' => [
                // dbal
                Connection::class => ConnectionFactory::class,
                SingleConnectionProvider::class => SingleConnectionProviderFactory::class,
                // orm
                EntityManager::class => EntityManagerFactory::class,
                EntityManagerProvider::class => SingleManagerProviderFactory::class,
                OrmConfiguration::class => OrmConfigurationFactory::class,
                // migrations
                MigrationsConfiguration::class => MigrationsConfigurationFactory::class,
                DependencyFactory::class => DependencyFactoryFactory::class,
            ],
        ];
    }
}
