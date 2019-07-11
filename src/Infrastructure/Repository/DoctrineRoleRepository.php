<?php


namespace Auth\Infrastructure\Repository;


use Auth\Domain\Entity\Role;
use Auth\Domain\Repository\RoleRepository;
use Doctrine\ORM\EntityManager;
use Exception;

class DoctrineRoleRepository implements RoleRepository
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * DoctrineRoleRepository constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function add(Role $role): void
    {
        $this->entityManager->persist($role);
    }

    public function get(string $uuid): Role
    {
        return $this->getThrowingException($uuid);
    }

    public function remove(string $uuid): void
    {
        $role = $this->getThrowingException($uuid);
        $this->entityManager->remove($role);
    }

    private function getThrowingException(string $uuid): Role
    {
        $role = $this->find($uuid);

        if ($role instanceof Role) {
            return $role;
        }

        throw new Exception('Role not found');
    }
}