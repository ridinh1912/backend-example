<?php

namespace Tests\Unit;

use App\Models\Permission;
use App\Models\Role;
use Tests\TestCase;


class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_true_is_true()
    {
        $role = Role::create(['name' => 'normal users']);
        $permission = Permission::create(['name' => 'edit articlesss']);
        $role->givePermissionTo($permission);
        $permission->assignRole($role);
        dd($role);
    }
}
