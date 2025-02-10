<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory;
    protected $table = 'transactions';
    protected $guarded = ["id"];
    protected $primaryKey = "id";

    public static function getTransactionDetails($examination_id)
    {
        $transaction = DB::table('transactions as t')
            ->join('examinations as e', 't.examination_id', '=', 'e.id')
            ->join('patients as p', 'e.patient_id', '=', 'p.id')
            ->join('users as u', 'e.user_id', '=', 'u.id')
            ->where('t.examination_id', $examination_id)
            ->select(
                't.id as transaction_id',
                't.examination_id',
                't.total_invoice',
                't.total_pay',
                't.total_change',
                't.payment_date',
                't.payment_by',
                't.created_by as transaction_created_by',
                't.updated_by as transaction_updated_by',
                'e.examination_date',
                'e.height',
                'e.weight',
                'e.systolic',
                'e.diastolic',
                'e.heart_rate',
                'e.respiration_rate',
                'e.body_temperature',
                'e.examination_results',
                'e.file_upload',
                'e.created_by as examination_created_by',
                'e.updated_by as examination_updated_by',
                'p.id as patient_id',
                'p.name as patient_name',
                'p.gender as patient_gender',
                'p.place_of_birth as patient_place_of_birth',
                'p.date_of_birth as patient_date_of_birth',
                'p.address as patient_address',
                'p.number_phone as patient_number_phone',
                'p.email as patient_email',
                'p.blood_type as patient_blood_type',
                'p.work as patient_work',
                'p.marital_status as patient_marital_status',
                'p.registration_date as patient_registration_date',
                'p.status as patient_status',
                'u.id as doctor_id',
                'u.name as doctor_name',
                'u.email as doctor_email'
            )
            ->first();

        return $transaction;
    }
}
