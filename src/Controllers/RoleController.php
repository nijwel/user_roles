<?php

namespace Nijwel\UserRoles\Controllers;

use Nijwel\UserRoles\Models\Role;
use Nijwel\UserRoles\Models\Permission;
use Nijwel\UserRoles\Models\PermissionRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class RoleController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $role        = Role::create(['name' => $request->name, 'guard_name' => 'auth']);
            $permissions = $request->input('permissions');
            if (!empty($permissions)) {
                foreach ($permissions as $key => $value) {
                    $permission                = new PermissionRole();
                    $permission->role_id       = $role->id;
                    $permission->permission_id = $value;
                    $permission->save();
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Role created successfully');
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json($exception->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
        ]);

        try {

            DB::beginTransaction();

            $role       = Role::find($id);
            $role->name = $request->name;
            $role->save();

            $permissions = $request->input('permissions');
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
            return redirect()->back()->with('success', 'Role update successfully');
        } catch (\Exception $exception) {

            DB::rollBack();
            return response()->json($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Role::find($id)->delete();
        return redirect()->back()->with('success', 'Successfully Delete !');
    }
}
