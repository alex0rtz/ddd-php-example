<?php


namespace Auth\Domain\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use LogicException;

class Role
{
    private $id;
    private $name;

    /**
     * @var Collection|Permission[]
     */
    private $permissions = [];

    /**
     * Role constructor.
     * @param string|null $uuid
     * @param string $name
     */
    public function __construct(?string $uuid = null, ?string $name = null)
    {
        $this->id = $uuid;
        $this->name = $name;

        $this->permissions = new ArrayCollection();
    }

    public function find()
    {

    }

    public function addPermission(Permission $permission): void
    {
        if (!empty($this->permissions)) {
            foreach ($this->permissions as $curPermission) {
                $curPermissionUuid = $curPermission->getUuid();
                $permissionUuid = $permission->getUuid();

                if ($curPermissionUuid === $permissionUuid) {
                    throw new LogicException('This permission already exists in array');
                }
            }
        }

        $this->permissions[] = (object)$permission;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }
}