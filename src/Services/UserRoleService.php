<?php

namespace Nijwel\UserRoles\Services;

use Nijwel\UserRoles\Models\Permission;
use Nijwel\UserRoles\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Nijwel\UserRoles\Models\PermissionRole;

class UserRoleService
{
    /**
     *
     * Hare is role service method
     *
     * */

    public static function getAllRole()
    {
        return Role::all();
    }

    public static function getRole($id)
    {
        return Role::find($id);
    }


    public static function createRole($role)
    {
        $role = Role::create($role);
        return $role;
    }

    public static function updateRole($role, $id)
    {
        $role = Role::find($id)->update($role);
        return $role;
    }

    public static function deleteRole($id)
    {
        $role = Role::find($id)->delete();
        return $role;
    }


    /**
     *
     * Hare is permission service method
     *
     * */

    public static function getAllPermission()
    {
        return Permission::all();
    }

    public static function getPermission($id)
    {
        return Permission::find($id);
    }

    public static function createPermission($createPermission)
    {
        $permission = Permission::create($createPermission);
        return $permission;
    }


    public static function updatePermission($updatePermission, $id)
    {
        $permission = Permission::find($id)->update($updatePermission);
        return $permission;
    }



    public static function destroyPermission($id)
    {
        $permission = Permission::find($id)->delete();
        return $permission;
    }



    /**
     *
     * Hare is role with permission service method
     *
     * */

    public static function getAllRoleWithPermission()
    {
        return Role::with('permissions')->get();
    }


    public static function getRoleWithPermission($id)
    {
        return Role::with('permissions')->find($id);
    }


    public static function createRoleWithPermission($role)
    {
        // dd($role);

        try {
            DB::beginTransaction();
            $permissions = $role['permissions'];
            $role        = Role::create(['name' => $role['name']]);

            if (!empty($permissions)) {
                foreach ($permissions as $key => $value) {
                    $permission                = new PermissionRole();
                    $permission->role_id       = $role->id;
                    $permission->permission_id = $value;
                    $permission->save();
                }
            }

            DB::commit();

            return $role;
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json($exception->getMessage());
        }
    }

    public static function updateRoleWithPermission($role, $id)
    {

        try {

            DB::beginTransaction();
            $permissions = $role['permissions'];

            $role       = Role::find($id);
            $role->name = $role['name'];
            $role->save();

            if (!empty($permissions)) {
                PermissionRole::where('role_id', $role->id)->delete();
                foreach ($permissions as $key => $value) {
                    $permission                = new PermissionRole();
                    $permission->role_id       = $role->id;
                    $permission->permission_id = $value;
                    $permission->save();
                }
            }

            DB::commit();
            return $role;;
        } catch (\Exception $exception) {

            DB::rollBack();
            return response()->json($exception->getMessage());
        }
        return $role;
    }


    public static function deleteRoleWithPermission($id)
    {
        $role = Role::find($id)->delete();
        return $role;
    }




    /**
     *
     * Hare is role permission service method
     *
     * */

    public static function assignPermission($role, $permission)
    {
        // Your logic for assigning a permission to a role
        $role->permissions()->attach($permission);
        return "Permission assigned successfully.";
    }


    public static function removePermission($role, $permission)
    {
        // Your logic for removing a permission from a role
        $role->permissions()->detach($permission);
        return "Permission removed successfully.";
    }


    /**
     *
     * Hare is user service method
     *
     * */


    public static function getAllUser()
    {
        return User::all();
    }


    public static function getUser($id)
    {
        return User::find($id);
    }

    public static function createUser($request)
    {
        $user = User::create($request->all());
        return $user;
    }


    public static function updateUser($request, $user)
    {
        $user->update($request->all());
        return $user;
    }


    public static function deleteUser($user)
    {
        $user->delete();
        return "User deleted successfully";
    }


    public static function getAllUserWithRole()
    {
        return User::with('roles')->get();
    }


    public static function getUserWithRole($id)
    {
        return User::with('roles')->find($id);
    }


    public static function createUserWithRole($request)
    {
        $user = User::create($request->all());
        $user->roles()->attach($request->role_id);
        return $user;
    }

    public static function updateUserWithRole($request, $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->role_id);
        return $user;
    }


    public static function deleteUserWithRole($user)
    {
        $user->delete();
        return "User deleted successfully";
    }


    public static function createUserWithRoleAndPermission($request)
    {
        $user = User::create($request->all());
        $user->roles()->attach($request->role_id);
        $user->permissions()->attach($request->permission_id);
        return $user;
    }


    public static function updateUserWithRoleAndPermission($request, $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->role_id);
        $user->permissions()->sync($request->permission_id);
        return $user;
    }


    public static function deleteUserWithRoleAndPermission($user)
    {
        $user->delete();
        return "User deleted successfully";
    }


    public static function assignRole($user, $role)
    {
        // Your logic for assigning a role to a user
        if ($user->hasRole($role)) {
            return "User already has this role.";
        }

        $user->roles()->attach($role);
        return "Role assigned successfully.";
    }

    public static function removeRole($user, $role)
    {
        // Your logic for removing a role from a user
        if (!$user->hasRole($role)) {
            return "User does not have this role.";
        }

        $user->roles()->detach($role);
        return "Role removed successfully.";
    }
}
