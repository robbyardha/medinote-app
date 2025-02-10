<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    /** @use HasFactory<\Database\Factories\PatientFactory> */
    use HasFactory;

    protected $table = "patients";
    protected $guarded = ["id"];
    protected $primaryKey = "id";


    public static function getPatient($orderBy = ['name', 'asc'], $status = 'Active')
    {
        $query = self::where('status', $status);
        $query = $query->orderBy($orderBy[0], $orderBy[1]);
        return $query->get();
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }
}
