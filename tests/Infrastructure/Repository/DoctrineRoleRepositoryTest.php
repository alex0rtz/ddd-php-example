<?php

namespace Auth\Tests\Infrastructure\Repository;

use Auth\Domain\Entity\Permission;
use Auth\Domain\Entity\Role;

use Auth\Domain\Repository\RoleRepository;
use Auth\Infrastructure\Repository\DoctrineRoleRepository;

use Auth\Utils\ConnectionManager;
use Auth\Utils\EntityManagerFactory;
use PHPUnit\Framework\Assert;

class DoctrineRoleRepositoryTest extends RoleRepositoryTest
{
    private $entityManager;

    protected function createRepository(): RoleRepository
    {
        return new DoctrineRoleRepository($this->entityManager);
    }

    protected function flush()
    {
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    protected function setUp(): void
    {
        // Doctrine Connection
        // ConnectionManager::dropAndCreateDatabase();
        // $connection = ConnectionManager::createConnection();

        $connection = ConnectionManager::createSqliteMemoryConnection();
        $this->entityManager = EntityManagerFactory::createEntityManager($connection, [Role::class, Permission::class]);
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->getConnection()->close();
    }

    public function testPermissionAreRemovedWithRole()
    {
        $uuid = '1';

        $role = new Role($uuid, 'test');
        $role->addPermission(new Permission('987'));
        $repository = $this->createRepository();
        $repository->add($role);
        $this->flush();

        $repository->remove($uuid);
        $this->flush();

        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->from(Permission::class, 'i')->select('i');
        $query = $queryBuilder->getQuery();
        $result = $query->getResult();

        Assert::assertCount(0, $result);
    }
}