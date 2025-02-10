<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    public function getDataAjax()
    {
        $data = Role::orderBy('name', 'asc');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return view('role.action')->with('data', $data);
            })
            ->make(true);
    }
    public function index()
    {
        $data = [
            'title' => 'Role'
        ];
        return view('role.index', $data);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name|max:100',
        ], [
            'name.required' => 'Nama wajib diisi',
            'name.unique' => 'Nama sudah terdaftar',
            'name.max' => 'Nama maksimal 100 karakter',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $dataSave = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        return response()->json(['success' => 'Data saved successfully!'], 200);
    }

    public function edit($id)
    {
        $data = Role::findOrFail($id);

        return response()->json([
            'result' => $data,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name_edit' => 'required|unique:roles,name,' . $id . '|max:100',
        ], [
            'name_edit.required' => 'Nama Wajib diisi',
            'name_edit.unique' => 'Nama sudah terdaftar',
            'name_edit.max' => 'Nama maksimal 100 karakter',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        } else {
            $client = Role::findOrFail($id);

            $data = [
                'name' => $request->name_edit,
            ];

            $client->update($data);

            return response()->json(['success' => 'Data updated successfully!'], 200);
        }
    }

    public function delete($id)
    {
        $data = Role::find($id);
        if ($data) {
            $data->delete();
            return response()->json(['success' => true, 'message' => 'Data deleted successfully!']);
        } else {
            return response()->json(['success' => false, 'message' => 'Data not found!'], 404);
        }
    }
}
