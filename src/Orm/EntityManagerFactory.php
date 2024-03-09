<?php

/**
 * EntityManagerFactory.php
 *
 * Author: Michael Leßnau <michael.lessnau@gmail.com>
 * Date:   2022-01-16
 */

declare(strict_types=1);

namespace BusFactor\LaminasDoctrine\Orm;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class EntityManagerFactory implements FactoryInterface
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ORMException
     */
    public function __invoke(ContainerInterface $container, string $requestedName, array|null $options = null): EntityManager
    {
        /** @var Configuration $configuration */
        $configuration = $container->get(Configuration::class);
        /** @var Connection $connection */
        $connection = $container->get(Connection::class);

        return EntityManager::create($connection, $configuration);
    }
}
