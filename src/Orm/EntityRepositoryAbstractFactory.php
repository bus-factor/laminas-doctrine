<?php

/**
 * EntityRepositoryAbstractFactory.php
 *
 * Author: Michael Leßnau <michael.lessnau@gmail.com>
 * Date:   2022-01-17
 */

declare(strict_types=1);

namespace BusFactor\LaminasDoctrine\Orm;

use Doctrine\ORM\EntityManager;
use Laminas\ServiceManager\Factory\AbstractFactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class EntityRepositoryAbstractFactory
 *
 * Assumed your project's directory structure matches the below schema, this abstract repository
 * enables easy entity repository injection via laminas' service manager:
 *
 * .../
 *   Entity/
 *     FooEntity.php
 *     ...
 *   EntityRepository/
 *     FooEntityRepository.php
 *     ...
 */
class EntityRepositoryAbstractFactory implements AbstractFactoryInterface
{
    /**
     * @param ContainerInterface $container
     */
    public function canCreate(ContainerInterface $container, string $requestedName): bool
    {
        return preg_match('/EntityRepository$/', $requestedName) === 1;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, string $requestedName, array|null $options = null): mixed
    {
        $entityFqcn = str_replace('EntityRepository', 'Entity', $requestedName);
        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);

        return $entityManager->getRepository($entityFqcn);
    }
}
