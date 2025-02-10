<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /** @use HasFactory<\Database\Factories\MenuFactory> */
    use HasFactory;

    protected $table = "menus";
    protected $guarded = ["id"];
    protected $primaryKey = "id";

    public static function get_menu($is_show = false)
    {
        if ($is_show) {
            return self::where("is_show", 1)->orderBy('order', 'asc')->orderBy('name', 'asc')->get();
        } else {
            return self::orderBy('order', 'asc')->orderBy('name', 'asc')->get();
        }
    }
}
