<?php

/**
 * ConfigurationFactory.php
 *
 * Author: Michael Leßnau <michael.lessnau@gmail.com>
 * Date:   2022-01-16
 */

declare(strict_types=1);

namespace BusFactor\LaminasDoctrine\Orm;

use Doctrine\ORM\Configuration;
use Doctrine\ORM\Tools\Setup;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class ConfigurationFactory implements FactoryInterface
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, string $requestedName, array|null $options = null): Configuration
    {
        /** @var array<string, array<string, mixed>> $config */
        $config = $container->get('config');
        $paths = $config['doctrine']['orm']['entity_paths'];
        $isDevMode = $config['doctrine']['orm']['is_dev_mode'];

        return Setup::createAttributeMetadataConfiguration($paths, $isDevMode);
    }
}
