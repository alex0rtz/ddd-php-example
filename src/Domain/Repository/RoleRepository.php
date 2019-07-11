<?php


namespace Auth\Domain\Repository;


use Auth\Domain\Entity\Role;

interface RoleRepository
{
    public function add(Role $role): void;
    public function get(string $uuid): Role;
    public function remove(string $uuid): void;
}