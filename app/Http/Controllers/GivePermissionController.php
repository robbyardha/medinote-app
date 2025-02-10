<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class GivePermissionController extends Controller
{
    public function getDataAjax()
    {
        $data = Role::whereNotIn('name', ['developer', 'superadmin'])->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('name', function ($data) {
                return $data->name ? $data->name : ' No Data';
            })
            ->addColumn('action', function ($data) {
                return view('give-permission.action')->with('data', $data);
            })
            ->rawColumns(["actions"])
            ->make(true);
        // ->toJson();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => 'Role Give Permission'
        ];
        return view('give-permission.index', $data);
    }


    public function edit($id)
    {
        $detail = Role::find($id);

        $role_permissions = DB::table("role_has_permissions")
            ->select("permissions.name")
            ->join("permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_id", $id)->get()->toArray();

        $role_permissions = array_map(function ($row) {
            return $row->name;
        }, $role_permissions);


        $view = view('give-permission.permission_table', compact('role_permissions', 'detail'))->render();

        return response()->json([
            'role_permissions' => $role_permissions,
            'detail' => $detail,
            'view' => $view,
        ]);
    }

    public function update(Request $request)
    {
        $field = [
            "id" => "required",
            "permission_collection" => "required|array",
        ];

        $error_message = [

            "id.required" => ":attribute is required",

            "permission_collection.required" => ":attribute is required",
            "permission_collection.array" => ":attribute is array",
        ];

        $validator = Validator::make($request->all(), $field, $error_message);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        } else {

            $id = $request->input("id");
            $permission_collection = $request->input("permission_collection");

            $permissions = [];

            foreach ($permission_collection as $permission) {
                array_push($permissions, $permission);
            }


            $role = Role::find($id);
            $role->syncPermissions($permissions);

            return response()->json(['success' => 'Data updated successfully!'], 200);
        }
    }
}
