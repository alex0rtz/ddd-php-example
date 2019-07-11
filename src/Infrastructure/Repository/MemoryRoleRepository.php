<?php


namespace Auth\Infrastructure\Repository;


use Auth\Domain\Entity\Role;
use Auth\Domain\Repository\RoleRepository;
use Exception;

/**
 * Class MemoryRoleRepository
 * @package Auth\Infrastructure\Repository
 */
class MemoryRoleRepository implements RoleRepository
{

    /**
     * @var Role[]
     */
    private $roles = [];

    /**
     * @param Role $role
     */
    public function add(Role $role): void
    {
        $this->roles[$role->getId()] = $role;
    }

    /**
     * @param string $uuid
     * @return Role
     * @throws Exception
     */
    public function get(string $uuid): Role
    {
        $this->checkExistence($uuid);
        return $this->roles[$uuid];
    }

    /**
     * @param string $uuid
     * @throws Exception
     */
    private function checkExistence(string $uuid): void
    {
        if (!isset($this->roles[$uuid])) {
            throw new Exception('Role not found');
        }
    }

    /**
     * @param string $uuid
     * @throws Exception
     */
    public function remove(string $uuid): void
    {
        $this->checkExistence($uuid);
        unset($this->roles[$uuid]);
    }
}