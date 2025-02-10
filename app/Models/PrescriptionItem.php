<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionItem extends Model
{
    /** @use HasFactory<\Database\Factories\PrescriptionItemFactory> */
    use HasFactory;
    protected $table = "prescription_items";
    protected $guarded = ["id"];
    protected $primaryKey = "id";
}
