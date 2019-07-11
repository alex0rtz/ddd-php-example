<?php

namespace Auth\Tests\Infrastructure\Repository;

use Auth\Domain\Entity\Permission;
use Auth\Domain\Entity\Role;

use Auth\Domain\Repository\RoleRepository;

use Exception;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

abstract class RoleRepositoryTest extends TestCase
{
    private $repository;

    protected function flush() {

    }


    public function testAddAndGetSuccessfully()
    {
        $uuid = '1';

        $role = $this->createRoleWithPermission(['uuid' => $uuid, 'name' => 'A'], ['uuid' => '123']);
        $this->repository->add($role);
        $this->flush();

        $foundRole = $this->repository->get($uuid);
        Assert::assertEquals($foundRole, $role);
    }

    private function createRoleWithPermission($role, $permission): Role
    {
        $role = new Role($role['uuid'], $role['name']);
        $role->addPermission(new Permission($permission['uuid'], false, false, false, false));
        return $role;
    }

    public function testAddAndRemoveSuccessfully()
    {
        $uuid = 1;

        $role = $this->createRoleWithPermission(['uuid' => $uuid, 'name' => 'A'], ['uuid' => '123']);
        $this->repository->add($role);
        $this->flush();

        $this->repository->remove($uuid);
        $this->flush();

        $this->expectException(Exception::class);
        $this->repository->get($uuid);
    }

    public function testGetNotExistingCauseException()
    {
        $uuid = '1';

        $this->expectException(Exception::class);
        $this->repository->get($uuid);
    }

    public function testRemoveNotExistingCauseException()
    {
        $uuid = '1';

        $this->expectException(Exception::class);
        $this->repository->remove($uuid);
    }

    public function testAddTwoAndGetTwoSuccessfully()
    {
        $uuid = '1';
        $emptyUuid = (string)random_int(20, 200);

        $withPermission = $this->createRoleWithPermission(['uuid' => $uuid, 'name' => 'A'], ['uuid' => '123']);
        $this->repository->add($withPermission);
        $empty = $this->createEmptyRole($emptyUuid);
        $this->repository->add($empty);
        $this->flush();

        $foundWith = $this->repository->get($uuid);
        Assert::assertEquals($withPermission, $foundWith);

        $foundEmpty = $this->repository->get($emptyUuid);
        Assert::assertEquals($empty, $foundEmpty);
    }

    private function createEmptyRole(string $uuid): Role
    {
        return new Role($uuid);
    }

    abstract protected function createRepository(): RoleRepository;

    protected function setUp(): void
    {
        $this->repository = $this->createRepository();
    }
}