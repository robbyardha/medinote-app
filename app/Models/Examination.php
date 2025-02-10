<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Examination extends Model
{
    /** @use HasFactory<\Database\Factories\ExaminationFactory> */
    use HasFactory;

    protected $table = "examinations";
    protected $guarded = ["id"];
    protected $primaryKey = "id";

    public static function getPriceDetailExamination($examinationId)
    {
        $results = DB::table('prescription_items')
            ->join('prescriptions', 'prescriptions.id', '=', 'prescription_items.prescription_id')
            ->join('examinations', 'examinations.id', '=', 'prescriptions.examination_id')
            ->where('examinations.id', $examinationId)
            ->select(
                'prescriptions.id as prescription_id',
                DB::raw('SUM(prescription_items.unit_price * prescription_items.qty) as total_price')
            )
            ->groupBy('prescriptions.id')
            ->get();
        return $results;
    }
}
