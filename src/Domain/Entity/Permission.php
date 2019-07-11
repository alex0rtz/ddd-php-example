<?php


namespace Auth\Domain\Entity;


/**
 * Class Permission
 * @package Auth\Domain\ValueObject
 */
class Permission
{
    private $id;
    /**
     * @var bool
     */
    private $create;
    /**
     * @var bool
     */
    private $read;
    /**
     * @var bool
     */
    private $update;
    /**
     * @var bool
     */
    private $delete;

    /**
     * @var Role
     */
    private $role;

    /**
     * Permission constructor.
     * @param string|null $id
     * @param bool $create
     * @param bool $read
     * @param bool $update
     * @param bool $delete
     * @param Role $role
     */
    public function __construct(
        ?string $id = null,

        ?bool $create = false,
        ?bool $read = false,
        ?bool $update = false,
        ?bool $delete = false,

        ?Role $role = null
    )
    {
        $this->id = $id;

        $this->create = $create;
        $this->read = $read;
        $this->update = $update;
        $this->delete = $delete;

        $this->role = $role;
    }
}