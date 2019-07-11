<?php

namespace Auth\Tests\Domain\Entity;

use Auth\Domain\Entity\Role;

use Auth\Tests\Data\Assets;
use Auth\Tests\Data\Permission as DataPermission;
use Auth\Tests\Data\Role as DataRole;

use Error;
use InvalidArgumentException;
use LogicException;

use PHPUnit\Framework\TestCase;

/**
 * Class RoleTest
 * @package Auth\Tests\Domain\Entity
 * @tes
 */
class RoleTest extends TestCase
{
    private const CLASS_NAME = 'Auth\Domain\Entity\Role';

    private $repository;
    private $permission;

    protected function setUp(): void
    {
        $this->repository = $this->getMockBuilder('Auth\Domain\Repository\RoleRepository')->getMock();
    }

    public function addDataProvider()
    {
        return DataRole::getData(true);
    }

    /**
     * @dataProvider addDataProvider
     * @param $role
     */
    public function testConstructor($role)
    {
        $item = $this->getMockBuilder(self::CLASS_NAME)
            ->setConstructorArgs((array)$role)
            ->getMock();

        $this->assertInstanceOf(self::CLASS_NAME, $item);

        $item = $this->getMockBuilder(self::CLASS_NAME)
            ->setConstructorArgs([$role->uuid, null])
            ->getMock();

        $this->assertInstanceOf(self::CLASS_NAME, $item);

        $item = $this->getMockBuilder(self::CLASS_NAME)
            ->setConstructorArgs([null, $role->name])
            ->getMock();

        $this->assertInstanceOf(self::CLASS_NAME, $item);
    }
}
