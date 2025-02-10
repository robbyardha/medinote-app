<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class MenuController extends Controller
{
    public function select2(Request $request)
    {
        $search = $request->get('q');
        $page = $request->get('page', 1);
        $query = Menu::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('url', 'like', '%' . $search . '%');
        }
        $perPage = 10;
        $menus = $query->paginate($perPage, ['id', 'name', 'url']);

        $formattedMenus = $menus->getCollection()->map(function ($user) {
            return [
                'id' => $user->id,
                'text' => $user->name,
            ];
        });

        return response()->json([
            'results' => $formattedMenus,
            'pagination' => [
                'more' => $menus->hasMorePages(),
            ],
        ]);
    }


    public function getDataAjax()
    {
        $data = Menu::orderBy('name', 'asc');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('icon', function ($data) {
                return $data->icon ? "<i class='bx $data->icon text-dark'></i>" : ' No Icon';
            })
            ->addColumn('name', function ($data) {
                return $data->name ? $data->name : ' No Data';
            })
            ->addColumn('url', function ($data) {
                return $data->url ? $data->url : ' No Data';
            })
            ->addColumn('action', function ($data) {
                return view('menu.action')->with('data', $data);
            })
            ->rawColumns(["actions", "icon"])
            ->make(true);
        // ->toJson();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => 'Menu'
        ];
        return view('menu.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'icon' => 'required|max:100',
            'name' => 'required|unique:menus,name|max:100',
            'url' => 'required|max:100',
            'order' => 'required|max:100',
        ], [
            'icon.required' => 'Icon wajib diisi',
            'icon.max' => 'Icon maksimal 100 karakter',

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

        $dataSave = Menu::create([
            'icon' => $request->icon,
            'name' => $request->name,
            'url' => $request->url,
            'order' => $request->order,
            'is_single' => $request->is_single ? $request->is_single : 0,
            'is_show' => $request->is_show ? $request->is_show : 0,
        ]);

        return response()->json(['success' => 'Data saved successfully!'], 200);
    }

    public function edit($id)
    {
        $data = Menu::findOrFail($id);

        return response()->json([
            'result' => $data,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'icon_edit' => 'required|max:100',
            'name_edit' => 'required|unique:menus,name,' . $id . '|max:100',
            'url_edit' => 'required|max:100',
            'order_edit' => 'required|max:100',
        ], [
            'icon_edit.required' => 'Icon wajib diisi',
            'icon_edit.max' => 'Icon maksimal 100 karakter',

            'name_edit.required' => 'Nama wajib diisi',
            'name_edit.unique' => 'Nama sudah terdaftar',
            'name_edit.max' => 'Nama maksimal 100 karakter',

            'url_edit.required' => 'URI Segment wajib diisi',
            'url_edit.max' => 'URI Segment maksimal 100 karakter',

            'order_edit.required' => 'Urutan wajib diisi',
            'order_edit.max' => 'Urutan maksimal 100 karakter',

        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        } else {
            $dataUpdate = Menu::findOrFail($id);

            $data = [
                'icon' => $request->icon_edit,
                'name' => $request->name_edit,
                'url' => $request->url_edit,
                'order' => $request->order_edit,
                'is_single' => $request->is_single_edit ? $request->is_single_edit : 0,
                'is_show' => $request->is_show_edit ? $request->is_show_edit : 0,
            ];

            $dataUpdate->update($data);

            return response()->json(['success' => 'Data updated successfully!'], 200);
        }
    }

    public function delete($id)
    {
        $data = Menu::find($id);
        if ($data) {
            $data->delete();
            return response()->json(['success' => true, 'message' => 'Data deleted successfully!']);
        } else {
            return response()->json(['success' => false, 'message' => 'Data not found!'], 404);
        }
    }
}
