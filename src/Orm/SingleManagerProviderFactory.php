<?php

declare(strict_types=1);

namespace BusFactor\LaminasDoctrine\Orm;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class SingleManagerProviderFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, string $requestedName, array|null $options = null): SingleManagerProvider
    {
        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);

        return new SingleManagerProvider($entityManager);
    }
}
