<?php

namespace Auth\Tests\Infrastructure\Repository;

use Auth\Domain\Entity\Role;
use Auth\Domain\Repository\RoleRepository;
use Auth\Infrastructure\Repository\MemoryRoleRepository;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class MemoryRoleRepositoryTest extends RoleRepositoryTest
{
    protected function createRepository(): RoleRepository
    {
        return new MemoryRoleRepository();
    }
}