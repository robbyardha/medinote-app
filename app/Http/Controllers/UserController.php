<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function select2Doctor(Request $request)
    {
        $search = $request->get('q');
        $page = $request->get('page', 1);

        $query = User::getUserByRole('dokter', $search);

        $perPage = 10;

        $menus = $query->paginate($perPage);

        $formattedMenus = $menus->getCollection()->map(function ($user) {
            return [
                'id' => $user->id,
                'text' => $user->name . " (" . $user->username . ")",
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
        $data = User::get_user();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('name', function ($data) {
                return $data->name ? $data->name : ' No Data';
            })

            ->addColumn('action', function ($data) {
                return view('user.action')->with('data', $data);
            })
            ->rawColumns(["actions"])
            ->make(true);
        // ->toJson();
    }

    public function index()
    {
        $data = [
            'title' => 'User',
            'roles' => Role::whereNotIn('name', ['developer', 'superadmin'])->get(),
        ];
        return view('user.index', $data);
    }

    public function create(Request $request)
    {
        $field = [
            "name" => "required|string|max:150",
            "email" => "required|email|max:150|unique:users,email",
            "username" => "required|max:150|unique:users,username",
            "password" => "required|string|max:100",
            "password_confirmation" => "required|string|max:100|same:password",
            "roles" => "required|array"
        ];

        $error_message = [

            "name.required" => ":attribute is required",
            "name.string" => ":attribute is string",
            "name.max" => ":attribute max :max characters",

            "email.required" => ":attribute is required",
            "email.email" => ":attribute is email valid",
            "email.max" => ":attribute max :max characters",
            "email.unique" => ":attribute has been added",

            "username.required" => ":attribute is required",
            "username.max" => ":attribute max :max characters",
            "username.unique" => ":attribute has been added",

            "password.required" => ":attribute is required",
            "password.string" => ":attribute is string",
            "password.max" => ":attribute max :max characters",

            "password_confirmation.required" => ":attribute is required",
            "password_confirmation.string" => ":attribute is string",
            "password_confirmation.max" => ":attribute max :max characters",
            "password_confirmation.same" => ":attribute must same like :same",

            "roles.required" => ":attribute is required",
            "roles.array" => ":attribute is array"
        ];

        $validator = Validator::make($request->all(), $field, $error_message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $roles = $request->input("roles");
        $dataUser = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
        ];
        $dataSave = User::insert_user($dataUser, $roles);

        return response()->json(['success' => 'Data saved successfully!'], 200);
    }

    public function edit($id)
    {
        $data = User::findOrFail($id);
        $roles = Role::whereNotIn('name', ['developer', 'superadmin'])->get();

        $current_roles = array_map(function ($row) {
            return $row->name;
        }, User::get_user_roles($id));

        $view = view('user.form-edit-user', compact('current_roles', 'roles'))->render();

        return response()->json([
            'result' => $data,
            'view' => $view
        ]);
    }

    public function update(Request $request, $id)
    {
        $field = [
            "name_edit" => "required|string|max:150",
            "email_edit" => "required|email|max:150|unique:users,email,$id",
            "username_edit" => "required|max:150|unique:users,username,$id",
            "password_confirmation" => "same:password",
            "roles" => "required|array"
        ];

        $error_message = [

            "name_edit.required" => ":attribute is required",
            "name_edit.string" => ":attribute is string",
            "name_edit.max" => ":attribute max :max characters",

            "email_edit.required" => ":attribute is required",
            "email_edit.email" => ":attribute is email valid",
            "email_edit.max" => ":attribute max :max characters",
            "email_edit.unique" => ":attribute has been added",

            "username_edit.required" => ":attribute is required",
            "username_edit.max" => ":attribute max :max characters",
            "username_edit.unique" => ":attribute has been added",

            "password_confirmation.same" => ":attribute must same like :same",

            "roles.required" => ":attribute is required",
            "roles.array" => ":attribute is array"
        ];

        $validator = Validator::make($request->all(), $field, $error_message);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        } else {
            $roles = $request->input("roles");

            $dataUpdate = [
                'name' => $request->name_edit,
                'email' => $request->email_edit,
                'username' => $request->username_edit,
            ];

            if ($request->input("password")) {
                $dataUpdate['password'] = Hash::make($request->input("password"));
            }

            $update = User::update_user($id, $dataUpdate, $roles);

            return response()->json(['success' => 'Data updated successfully!'], 200);
        }
    }

    public function delete($id)
    {
        $data = User::find($id);
        if ($data) {
            $result = User::delete_user($id);
            return response()->json(['success' => true, 'message' => 'Data deleted successfully!']);
        } else {
            return response()->json(['success' => false, 'message' => 'Data not found!'], 404);
        }
    }
}
