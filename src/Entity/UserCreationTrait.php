<?php

namespace weitzman\DrupalTestTraits\Entity;

use Drupal\Tests\user\Traits\UserCreationTrait as CoreUserCreationTrait;
use Drupal\user\Entity\Role;

/**
 * Wraps core user test traits to track entities for deletion.
 */
trait UserCreationTrait
{
    use CoreUserCreationTrait {
        createUser as coreCreateUser;
        createRole as coreCreateRole;
    }

    /**
     * Creates a user and tracks it for automatic cleanup.
     *
     * @param array $permissions
     * @param null  $name
     * @param bool  $admin
     *
     * @return \Drupal\user\Entity\User|false
     */
    protected function createUser(array $permissions = [], $name = null, $admin = false)
    {
        $user = $this->coreCreateUser($permissions, $name, $admin);
        $this->markEntityForCleanup($user);
        return $user;
    }

    /**
     * Creates a role and tracks it for automatic cleanup.
     *
     * @param array $permissions
     * @param null  $rid
     * @param null  $name
     * @param null  $weight
     *
     * @return string
     */
    protected function createRole(array $permissions, $rid = null, $name = null, $weight = null)
    {
        $role_id = $this->coreCreateRole($permissions, $rid, $name, $weight);
        $role = Role::load($role_id);
        $this->markEntityForCleanup($role);
        return $role_id;
    }
}
