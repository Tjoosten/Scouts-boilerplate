<?php

namespace App\Services;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class RoleService
 *
 * @package App\Services
 */
class RoleService extends BaseService
{
    /**
     * RoleService constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->eloquentModel = new Role();
    }

    /**
     * Method for getting all the permission role out of the storage.
     *
     * @param  array|string[] $columns The columns u want to use in your view.
     * @return Collection
     */
    public function getRoles(array $columns = ['*']): Collection
    {
       return $this->get($columns);
    }
}
