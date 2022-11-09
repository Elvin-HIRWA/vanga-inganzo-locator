<?php

namespace App\Services;

use App\Models\Key;
use App\Models\Permission;

class PermissionService
{
    public function CreatePermission(string $name): Permission
    {
        $permission = new Permission();
        $permission->name = $name;
        $permission->save();

        return $permission;
    }

    public function listPermission()
    {
        $permissions = Permission::all(['id', 'name']);
        
        return $permissions;
    }

    public function getPermission(int $id)
    {
        $keys = Permission::find($id);
        
        return $keys;
    }

    public function updatePermission(int $id, string $updatedName)
    {
        Permission::where('id', $id)->update(['name' => $updatedName]);
    }

    public function deletePermission(int $id)
    {
        $permission = Permission::find($id);

        $permission->delete();
    }

    public function keyPermission()
    {
        $keys = Key::getKeyWithTheirPermission();

        return $keys;
    }
}