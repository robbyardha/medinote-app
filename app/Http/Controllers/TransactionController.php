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
use Illuminate\Support\Facades\Validator;
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
                $transactionData = null;
                if ($examination) {
                    $transactionData = Transaction::where('examination_id', $examination->id)->first();
                }

                return view('transaction.action', ['data' => $data, 'examination' => $examination, 'transaction' => $transactionData]);
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
        $examDataPrice = Examination::getPriceDetailExamination($id);
        $examDataItem = Examination::getDetailExaminationItem($id);
        return response()->json([
            'data_price' => $examDataPrice,
            'data_items' => $examDataItem,
        ]);
    }

    public function save_payment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'total_pay' => 'required|numeric|min:0',
            'examination_id' => 'required|exists:examinations,id',
            'payment_date' => 'required',
        ], [
            'payment_date.required' => 'Tanggal pembayaran wajib diisi',
            'total_pay.required' => 'Nominal pembayaran wajib diisi',
            'total_pay.numeric' => 'Nominal pembayaran harus berupa angka',
            'total_pay.min' => 'Nominal pembayaran tidak boleh kurang dari 0',
            'examination_id.required' => 'ID pemeriksaan wajib diisi',
            'examination_id.exists' => 'ID pemeriksaan tidak valid',
        ]);

        if ($request->total_pay < $request->total_invoice) {
            return response()->json(['errors' => ['total_pay' => 'Nominal pembayaran tidak boleh kurang dari total tagihan.']], 422);
        }

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $total_change = 0;
        if ($request->total_pay > $request->total_invoice) {
            $total_change = $request->total_pay - $request->total_invoice;
        }

        $dataSave = Transaction::create([
            'examination_id' => $request->examination_id,
            'total_pay' => $request->total_pay,
            'total_invoice' => $request->total_invoice,
            'total_change' => $total_change,
            'payment_date' => $request->payment_date,
            'payment_by' => auth()->user()->name,
            'created_by' => auth()->user()->name,

        ]);

        return response()->json(['success' => 'Data saved successfully!'], 200);
    }
}
