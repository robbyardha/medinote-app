<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AppointmentController extends Controller
{
    public function getDataAjax()
    {
        $data = Appointment::with(['patient', 'doctor'])
            ->orderByRaw("CASE 
                        WHEN status = 'Waiting' THEN 1
                        WHEN status = 'Called' THEN 2
                        WHEN status = 'Completed' THEN 3
                        WHEN status = 'Cancelled' THEN 4
                        ELSE 5
                     END")
            ->orderBy('queue_number', 'asc')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('patient_name', function ($data) {
                return $data->patient ? $data->patient->name : "No Data";
            })
            ->addColumn('queue_number', function ($data) {
                return $data->queue_number ? $data->queue_number : "No Data";
            })
            ->addColumn('doctor_name', function ($data) {
                return $data->doctor ? $data->doctor->name : "No Data";
            })
            ->addColumn('description', function ($data) {
                return $data->description ? $data->description : "No Data";
            })
            ->addColumn('status', function ($data) {
                if ($data->status == 'Waiting') {
                    return "<h6> <span class='badge color-yellow-500'>Waiting</span></h6>";
                }
                if ($data->status == 'Called') {
                    return "<h6> <span class='badge color-sky-500'>Called</span></h6>";
                }
                if ($data->status == 'Completed') {
                    return "<h6> <span class='badge color-emerald-500'>Completed</span></h6>";
                }
                if ($data->status == 'Cancelled') {
                    return "<h6> <span class='badge color-rose-500'>Cancelled</span></h6>";
                }
            })
            ->addColumn('action', function ($data) {
                return view('appointment.action')->with('data', $data);
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function index()
    {
        $data = [
            'title' => 'Pendaftaran Pasien'
        ];
        return view('appointment.index', $data);
    }


    public function create(Request $request)
    {
        if ($request->isMethod("get")) {

            $data = [
                'title' => 'Buat Pendaftaran Baru',
                'patients' => Patient::getPatient(),
            ];
            return view('appointment.create', $data);
        }

        if ($request->isMethod("post")) {
            $validator = Validator::make($request->all(), [
                'patient_id' => 'required|exists:patients,id',
                'user_id' => 'required|exists:users,id',
                'appointment_time' => 'required|date',
                'description' => 'nullable|string|max:255',
            ], [
                'patient_id.required' => 'Pasien wajib diisi',
                'user_id.required' => 'Dokter wajib diisi',
                'appointment_time.required' => 'Tanggal janji temu wajib diisi',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            try {
                // $queueNumber = 'QN-' . strtoupper(uniqid());
                $queueNumber = generateQueueNumber();
                $appointment = new Appointment();
                $appointment->patient_id = $request->patient_id;
                $appointment->user_id = $request->user_id;
                $appointment->queue_number = $queueNumber;
                $appointment->status = 'Waiting';
                $appointment->appointment_time = $request->appointment_time;
                $appointment->description = $request->description;
                $appointment->created_by = auth()->user()->name;
                $appointment->updated_by = auth()->user()->name;

                $appointment->save();

                return redirect("/exam/registration-examination")
                    ->with('success', 'Pendaftaran pemeriksaan berhasil disimpan.');
            } catch (\Exception $e) {
                return redirect("/exam/registration-examination")
                    ->with('error', 'Terjadi kesalahan saat menyimpan pendaftaran: ' . $e->getMessage())
                    ->withInput();
            }
        }
    }

    public function edit($id)
    {
        $decryptId = Crypt::decrypt($id);
        $dataRow = Appointment::find($decryptId);
        $dataPatient = Patient::getPatient();
        $dataDoctor = User::getUserByRole()->get();
        $data = [
            'title' => 'Edit Pendaftaran Pasien ' . $dataRow->queue_number,
            'appointment' => $dataRow,
            'doctors' => $dataDoctor,
            'patients' => $dataPatient,
        ];
        return view('appointment.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $decryptId = Crypt::decrypt($id);

        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'user_id' => 'required|exists:users,id',
            'appointment_time' => 'required|date',
            'description' => 'required|max:255',
        ], [
            'patient_id.required' => 'Pasien wajib dipilih',
            'user_id.required' => 'Dokter wajib dipilih',
            'appointment_time.required' => 'Tanggal wajib diisi',
            'description.required' => 'Deskripsi wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect("/exam/registration-examination/edit/" . Crypt::encrypt($decryptId))
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $appointment = Appointment::findOrFail($decryptId);

            $appointment->patient_id = $request->patient_id;
            $appointment->user_id = $request->user_id;
            $appointment->appointment_time = $request->appointment_time;
            $appointment->description = $request->description;
            $appointment->updated_by = auth()->user()->name;

            $appointment->save();

            return redirect("/exam/registration-examination")
                ->with('success', 'Data appointment berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect("/exam/registration-examination/edit/" . Crypt::encrypt($decryptId))
                ->with('error', 'Terjadi kesalahan saat memperbarui data appointment: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function delete($id)
    {
        $data = Appointment::find($id);
        if ($data) {
            $data->delete();
            return response()->json(['success' => true, 'message' => 'Data deleted successfully!']);
        } else {
            return response()->json(['success' => false, 'message' => 'Data not found!'], 404);
        }
    }

    public function call($id)
    {
        $data = Appointment::find($id);
        if ($data) {
            $data->status = "Called";
            $data->updated_by = auth()->user()->name;

            $data->save();

            return response()->json(['success' => true, 'message' => 'Data called successfully!']);
        } else {
            return response()->json(['success' => false, 'message' => 'Data not found!'], 404);
        }
    }
}
