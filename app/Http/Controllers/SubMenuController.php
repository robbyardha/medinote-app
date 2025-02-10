<?php

namespace App\Http\Controllers;

use App\Models\SubMenu;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SubMenuController extends Controller
{
    public function getDataAjax()
    {
        $data = SubMenu::getDetailSubMenu(null, 'sub_menus.menu_id', 'ASC');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('menuss_name', function ($data) {
                return $data->menuss_name ? $data->menuss_name : ' No Data';
            })
            ->addColumn('name', function ($data) {
                return $data->name ? $data->name : ' No Data';
            })
            ->addColumn('url', function ($data) {
                return $data->url ? $data->url : ' No Data';
            })
            ->addColumn('action', function ($data) {
                return view('submenu.action')->with('data', $data);
            })
            ->rawColumns(["actions"])
            ->make(true);
        // ->toJson();
    }

    public function index()
    {
        $data = [
            'title' => 'Sub Menu',
            'menus' => Menu::all(),
        ];
        return view('submenu.index', $data);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'menu_id' => 'required|max:100',
            'name' => 'required|unique:sub_menus,name|max:100',
            'url' => 'required|max:100',
            'order' => 'required|max:100',
        ], [
            'menu_id.required' => 'Menu wajib diisi',
            'menu_id.max' => 'Menu maksimal 100 karakter',

            'name.required' => 'Nama wajib diisi',
            'name.unique' => 'Nama sudah terdaftar',
            'name.max' => 'Nama maksimal 100 karakter',

            'url.required' => 'URI Segment wajib diisi',
            'url.max' => 'URI Segment maksimal 100 karakter',

            'order.required' => 'Urutan wajib diisi',
            'order.max' => 'Urutan maksimal 100 karakter',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $dataSave = SubMenu::create([
            'menu_id' => $request->menu_id,
            'name' => $request->name,
            'url' => $request->url,
            'order' => $request->order,
            'is_show' => $request->is_show ? $request->is_show : 0,
        ]);

        return response()->json(['success' => 'Data saved successfully!'], 200);
    }


    public function edit($id)
    {
        $data = SubMenu::findOrFail($id);

        return response()->json([
            'result' => $data,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'menu_id_edit' => 'required|max:100',
            'name_edit' => 'required|unique:sub_menus,name|max:100',
            'url_edit' => 'required|max:100',
            'order_edit' => 'required|max:100',
        ], [
            'menu_id_edit.required' => 'Menu wajib diisi',
            'menu_id_edit.max' => 'Menu maksimal 100 karakter',

            'name+edit.required' => 'Nama wajib diisi',
            'name+edit.unique' => 'Nama sudah terdaftar',
            'name+edit.max' => 'Nama maksimal 100 karakter',

            'url_edit.required' => 'URI Segment wajib diisi',
            'url_edit.max' => 'URI Segment maksimal 100 karakter',

            'order_edit.required' => 'Urutan wajib diisi',
            'order_edit.max' => 'Urutan maksimal 100 karakter',

        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        } else {
            $dataUpdate = SubMenu::findOrFail($id);

            $data = [
                'menu_id' => $request->menu_id_edit,
                'name' => $request->name_edit,
                'url' => $request->url_edit,
                'order' => $request->order_edit,
                'is_show' => $request->is_show_edit ? $request->is_show_edit : 0,
            ];

            $dataUpdate->update($data);

            return response()->json(['success' => 'Data updated successfully!'], 200);
        }
    }

    public function delete($id)
    {
        $data = SubMenu::find($id);
        if ($data) {
            $data->delete();
            return response()->json(['success' => true, 'message' => 'Data deleted successfully!']);
        } else {
            return response()->json(['success' => false, 'message' => 'Data not found!'], 404);
        }
    }
}
