<?php

/**
 * ConnectionFactory.php
 *
 * Author: Michael Leßnau <michael.lessnau@gmail.com>
 * Date:   2022-01-16
 */

declare(strict_types=1);

namespace BusFactor\LaminasDoctrine\Dbal;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\Configuration;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ConnectionFactory implements FactoryInterface
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): Connection
    {
        /** @var array<string, array<string, mixed>> $config */
        $config = $container->get('config');
        $params = $config['doctrine']['dbal']['connection'];

        /** @var Configuration $configuration */
        $configuration = $container->get(Configuration::class);

        return DriverManager::getConnection($params, $configuration);
    }
}
