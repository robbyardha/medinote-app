<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    public function getDataAjax()
    {
        $data = Permission::orderBy('name', 'asc');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('name', function ($data) {
                return $data->name ? $data->name : ' No Data';
            })
            ->addColumn('guard_name', function ($data) {
                return $data->guard_name ? $data->guard_name : ' No Data';
            })
            ->addColumn('action', function ($data) {
                return view('permission.action')->with('data', $data);
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
            'title' => 'Permission'
        ];
        return view('permission.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100|unique:permissions,name',
        ], [
            'name.required' => 'Nama wajib diisi',
            'name.max' => 'Nama maksimal 100 karakter',
            'name.unique' => 'Nama permission sudah terdaftar',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $dataSave = Permission::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        return response()->json(['success' => 'Data saved successfully!'], 200);
    }

    public function edit($id)
    {
        $data = Permission::findOrFail($id);

        return response()->json([
            'result' => $data,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name_edit' => 'required|max:100|unique:permissions,name, ' . $id . '',
        ], [
            'name_edit.required' => 'Nama wajib diisi',
            'name_edit.max' => 'Nama maksimal 100 karakter',
            'name_edit.unique' => 'Nama permission sudah terdaftar',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        } else {
            $dataUpdate = Permission::findOrFail($id);

            $data = [
                'name' => $request->name_edit,
            ];

            $dataUpdate->update($data);

            return response()->json(['success' => 'Data updated successfully!'], 200);
        }
    }

    public function delete($id)
    {
        $data = Permission::find($id);
        if ($data) {
            $data->delete();
            return response()->json(['success' => true, 'message' => 'Data deleted successfully!']);
        } else {
            return response()->json(['success' => false, 'message' => 'Data not found!'], 404);
        }
    }
}
