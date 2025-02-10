<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Appointment;
use App\Models\Examination;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
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
        $dataQuery->where('status', 'Completed');
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

                return view('transaction.action', ['data' => $data, 'examination' => $examination]);
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }


    public function index()
    {

        $data = [
            'title' => 'Pembayaran Pasien'
        ];
        return view('transaction.index', $data);
    }

    public function detail($id)
    {
        $decryptExamination = Crypt::decrypt($id);
        $examData = Examination::getPriceDetailExamination($decryptExamination);
        dd($examData);
    }
}
