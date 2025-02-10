<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PatientController extends Controller
{
    public function select2(Request $request)
    {
        $search = $request->get('q');
        $page = $request->get('page', 1);
        $query = Patient::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('number_phone', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        }
        $perPage = 10;
        $menus = $query->paginate($perPage, ['id', 'name', 'number_phone', 'email']);

        $formattedMenus = $menus->getCollection()->map(function ($user) {
            return [
                'id' => $user->id,
                'text' => $user->name . " (" . $user->number_phone . ") ",
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
        $data = Patient::getPatient();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function ($data) {
                if ($data->status == 'Active') {
                    return "<h6> <span class='badge color-emerald-500'>Aktif</span></h6>";
                }
                if ($data->status == 'Disactive') {
                    return "<h6> <span class='badge color-rose-500'>Tidak Aktif</span></h6>";
                }
            })
            ->addColumn('action', function ($data) {
                return view('patient.action')->with('data', $data);
            })
            ->rawColumns(["action", "status"])
            ->make(true);
    }
    public function index()
    {
        $data = [
            'title' => 'Patient'
        ];
        return view('patient.index', $data);
    }


    public function create(Request $request)
    {
        if ($request->isMethod("get")) {
            $data = [
                'title' => 'Add New Patient',
            ];
            return view('patient.create', $data);
        }

        if ($request->isMethod("post")) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'gender' => 'required',
                'place_of_birth' => 'required|max:150',
                'date_of_birth' => 'required|date',
                'address' => 'required',
                'number_phone' => 'required|max:150',
                'status' => 'required',
                'registration_date' => 'required|date',
            ], [
                'name.required' => 'Nama Pasien wajib diisi',
                'gender.required' => 'Jenis Kelamin wajib diisi',
                'place_of_birth.required' => 'Tempat Lahir wajib diisi',
                'date_of_birth.required' => 'Tanggal Lahir wajib diisi',
                'address.required' => 'Alamat wajib diisi',
                'number_phone.required' => 'Nomor Telepon wajib diisi',
                'status.required' => 'Status Pasien wajib diisi',
                'registration_date.required' => 'Tanggal Pendaftaran wajib diisi',
            ]);

            if ($validator->fails()) {
                return redirect("/master/patient/create")
                    ->withErrors($validator)
                    ->withInput();
            }

            try {
                $patient = new Patient();
                $patient->name = $request->name;
                $patient->gender = $request->gender;
                $patient->place_of_birth = $request->place_of_birth;
                $patient->date_of_birth = $request->date_of_birth;
                $patient->address = $request->address;
                $patient->number_phone = $request->number_phone;
                $patient->email = $request->email;
                $patient->blood_type = $request->blood_type;
                $patient->work = $request->work;
                $patient->marital_status = $request->marital_status;
                $patient->status = $request->status;
                $patient->registration_date = $request->registration_date;
                $patient->created_by = auth()->user()->name;
                $patient->updated_by = auth()->user()->name;

                $patient->save();

                return redirect("/master/patient")
                    ->with('success', 'Data pasien berhasil disimpan');
            } catch (\Exception $e) {
                return redirect("/master/patient")
                    ->with('error', 'Terjadi kesalahan saat menyimpan data pasien: ' . $e->getMessage())
                    ->withInput();
            }
        }
    }

    public function edit($id)
    {
        $decryptId = Crypt::decrypt($id);
        $dataRow = Patient::find($decryptId);
        $data = [
            'title' => 'Edit Patient ' . $dataRow->name,
            'patient' => $dataRow,
        ];
        return view('patient.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $decryptId = Crypt::decrypt($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'gender' => 'required',
            'place_of_birth' => 'required|max:150',
            'date_of_birth' => 'required|date',
            'address' => 'required',
            'number_phone' => 'required|max:150',
            'status' => 'required',
            'registration_date' => 'required|date',
        ], [
            'name.required' => 'Nama Pasien wajib diisi',
            'gender.required' => 'Jenis Kelamin wajib diisi',
            'place_of_birth.required' => 'Tempat Lahir wajib diisi',
            'date_of_birth.required' => 'Tanggal Lahir wajib diisi',
            'address.required' => 'Alamat wajib diisi',
            'number_phone.required' => 'Nomor Telepon wajib diisi',
            'status.required' => 'Status Pasien wajib diisi',
            'registration_date.required' => 'Tanggal Pendaftaran wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect("/master/patient/edit/" . Crypt::encrypt($decryptId))
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $patient = Patient::findOrFail($decryptId);

            $patient->name = $request->name;
            $patient->gender = $request->gender;
            $patient->place_of_birth = $request->place_of_birth;
            $patient->date_of_birth = $request->date_of_birth;
            $patient->address = $request->address;
            $patient->number_phone = $request->number_phone;
            $patient->email = $request->email;
            $patient->blood_type = $request->blood_type;
            $patient->work = $request->work;
            $patient->marital_status = $request->marital_status;
            $patient->status = $request->status;
            $patient->registration_date = $request->registration_date;
            $patient->updated_by = auth()->user()->name;

            $patient->save();

            return redirect("/master/patient")
                ->with('success', 'Data pasien berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect("/master/patient/edit/" . Crypt::encrypt($decryptId))
                ->with('error', 'Terjadi kesalahan saat memperbarui data pasien: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function delete($id)
    {
        $data = Patient::find($id);
        if ($data) {
            $data->delete();
            return response()->json(['success' => true, 'message' => 'Data deleted successfully!']);
        } else {
            return response()->json(['success' => false, 'message' => 'Data not found!'], 404);
        }
    }
}
