<?php

namespace App\Http\Controllers;

use App\Models\Examination;
use App\Http\Requests\StoreExaminationRequest;
use App\Http\Requests\UpdateExaminationRequest;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ExaminationController extends Controller
{
    public function getDataAjax()
    {
        $idUser = Auth::user()->id;
        $user = User::find($idUser);

        $dataQuery = Appointment::with(['patient', 'doctor'])
            ->orderByRaw("CASE 
                        WHEN status = 'Waiting' THEN 1
                        WHEN status = 'Called' THEN 2
                        WHEN status = 'Completed' THEN 3
                        WHEN status = 'Cancelled' THEN 4
                        ELSE 5
                     END")
            ->orderBy('queue_number', 'asc');


        if (!$user->hasRole('developer')) {
            $dataQuery->where('user_id', $idUser);
        }
        $dataQuery->where('status', 'Called');
        $data = $dataQuery->get();

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
                $examination = Examination::where('appointment_id', $data->id)->first();

                if ($examination) {
                    return "<h6> <span class='badge color-teal-500'>Sudah Diperiksa</span></h6>";
                } else {
                    return "<h6> <span class='badge color-rose-500'>Belum Diperiksa</span></h6>";
                }
            })
            ->addColumn('action', function ($data) {
                $examination = Examination::where('appointment_id', $data->id)->first();

                return view('examination.action', ['data' => $data, 'examination' => $examination]);
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }


    public function index()
    {

        $data = [
            'title' => 'Pemeriksaan Pasien'
        ];
        return view('examination.index', $data);
    }


    public function select_patient($id)
    {
        $decryptAppointmentId = Crypt::decrypt($id);
        $dataAppointment = Appointment::find($decryptAppointmentId);
        $dataPatient = Patient::find($dataAppointment->patient_id);

        $medicine = null;
        $medicineRequest = getMedicinesData();
        if (isset($medicineRequest['error'])) {
            echo $medicineRequest['error'];
        } else {
            $medicine = $medicineRequest;
        }

        if ($medicine == null) {
            return redirect()->back()
                ->withErrors(['medicine_error' => $medicineRequest['error'] . "Lakukan setting terlebih dahulu pada menu setting"])
                ->withInput();
        }


        $data = [
            'title' => "Pemeriksaan",
            'appointment' => $dataAppointment,
            'patient' => $dataPatient,
            'medicine' => $medicine,
        ];
        return view('examination.edit', $data);
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
                'appointment_id' => 'required|exists:appointments,id',

            ], [
                'patient_id.required' => 'Pasien wajib diisi',
                'user_id.required' => 'Dokter wajib diisi',
                'appointment_id.required' => 'Pendafatan Admin wajib diisi',

            ]);

            if ($validator->fails()) {
                return redirect('/exam/examination')
                    ->withErrors($validator)
                    ->withInput();
            }

            DB::beginTransaction();

            try {

                $directory = 'file_upload_examination';
                if (!Storage::disk('public')->exists($directory)) {
                    Storage::disk('public')->makeDirectory($directory);
                }

                if ($request->hasFile('file_upload')) {
                    $extension = $request->file('file_upload')->getClientOriginalExtension();
                    $fileName = Str::random(40) . '.' . $extension;

                    $path = $request->file('file_upload')->storeAs($directory, $fileName, 'public');
                    $fileNameOnly = basename($path);
                } else {
                    $path = null;
                    $fileNameOnly = null;
                }

                $appointmentData = Appointment::find($request->appointment_id);
                $appointmentData->update([
                    'status' => 'Completed',
                    'updated_by' => auth()->user()->name,
                ]);

                $examination = new Examination();
                $examination->appointment_id = $request->appointment_id;
                $examination->patient_id = $request->patient_id;
                $examination->user_id = $request->user_id;
                $examination->examination_date = $request->examination_date;
                $examination->height = $request->height;
                $examination->weight = $request->weight;
                $examination->systolic = $request->systolic;
                $examination->diastolic = $request->diastolic;
                $examination->heart_rate = $request->heart_rate;
                $examination->respiration_rate = $request->respiration_rate;
                $examination->body_temperature = $request->body_temperature;
                $examination->examination_results = $request->examination_results;
                $examination->file_upload = $fileNameOnly;
                $examination->created_by = auth()->user()->name;
                $examination->updated_by = auth()->user()->name;
                $examination->save();

                $examinationId = $examination->id;

                // Create Prescription
                $prescription = new Prescription();
                $prescription->examination_id = $examinationId;
                $prescription->status = 'process';
                $prescription->save();

                foreach ($request->medicines as $medicineData) {
                    $prescriptionItem = new PrescriptionItem();
                    $prescriptionItem->prescription_id = $prescription->id; //id prescription
                    $prescriptionItem->medicine_id = $medicineData['medicine_id'];
                    $prescriptionItem->unit_price = $medicineData['price'];
                    $prescriptionItem->qty = $medicineData['qty'];
                    $prescriptionItem->dose = $medicineData['dose'];
                    $prescriptionItem->save();
                }

                DB::commit();

                return redirect("/exam/examination")
                    ->with('success', 'Pendaftaran pemeriksaan berhasil disimpan.');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect("/exam/examination/select-patient/" . Crypt::encrypt($request->appointment_id))
                    ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
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

    public function getMedicineDetail($id)
    {
        $response = getMedicineDetail($id);
        if (isset($response['error'])) {
            return response()->json(['error' => $response['error']], 404);
        }

        $validPrice = null;
        $currentDate = Carbon::now()->toDateString();

        foreach ($response['prices'] as $price) {
            $startDate = Carbon::parse($price['start_date']['value'])->toDateString();
            $endDate = Carbon::parse($price['end_date']['value'])->toDateString();

            if ($currentDate >= $startDate && $currentDate <= $endDate) {
                $validPrice = $price['unit_price'];
                break;
            }
        }

        if ($validPrice) {
            return response()->json([
                'unit_price' => $validPrice,
                'message' => 'Harga ditemukan',
            ]);
        } else {
            return response()->json([
                'error' => 'Harga tidak tersedia untuk tanggal ini.',
            ], 404);
        }
    }
}
