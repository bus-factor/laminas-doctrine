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
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\AbstractFactoryInterface;
use Psr\Container\ContainerExceptionInterface;
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
     * @param mixed $requestedName
     * @return bool
     */
    public function canCreate(ContainerInterface $container, $requestedName): bool
    {
        return preg_match('/EntityRepository$/', $requestedName) === 1;
    }

    /**
     * @param ContainerInterface $container
     * @param mixed $requestedName
     * @param array|null $options
     * @return object
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityFqcn = str_replace('EntityRepository', 'Entity', $requestedName);
        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);

        return $entityManager->getRepository($entityFqcn);
    }
}
