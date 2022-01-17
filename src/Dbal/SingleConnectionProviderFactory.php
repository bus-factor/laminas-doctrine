<?php

/**
 * SingleConnectionProviderFactory.php
 *
 * Author: Michael Leßnau <michael.lessnau@gmail.com>
 * Date:   2022-01-16
 */

declare(strict_types=1);

namespace BusFactor\LaminasDoctrine\Dbal;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Tools\Console\ConnectionProvider\SingleConnectionProvider;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class SingleConnectionProviderFactory implements FactoryInterface
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): SingleConnectionProvider
    {
        /** @var Connection $connection */
        $connection = $container->get(Connection::class);

        return new SingleConnectionProvider($connection);
    }
}
