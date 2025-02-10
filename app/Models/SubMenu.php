<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SubMenu extends Model
{
    /** @use HasFactory<\Database\Factories\SubMenuFactory> */
    use HasFactory;

    protected $table = "sub_menus";
    protected $guarded = ["id"];
    protected $primaryKey = "id";


    public static function get_submenu_by_menu(int $menu_id, $is_show = "")
    {
        if ($is_show) {
            $query = self::where("is_show", 1)->where("menu_id", $menu_id)->get();
        } else {
            $query = self::where("menu_id", $menu_id)->get();
        }
        return $query;
    }

    public static function getDetailSubMenu($idSubmenu = null, $nameOrder = 'sub_menus.order', $orderType = 'ASC', $limit = null)
    {
        $query = DB::table('sub_menus')
            ->select('sub_menus.id', 'sub_menus.menu_id', 'sub_menus.name', 'sub_menus.url', 'sub_menus.order', 'sub_menus.is_show', 'menus.id AS menuss_id', 'menus.name AS menuss_name')
            ->leftJoin('menus', 'sub_menus.menu_id', '=', 'menus.id');

        if ($idSubmenu != null) {
            $query->where('sub_menus.id', $idSubmenu);
        }

        $query->orderBy($nameOrder, $orderType);

        if ($limit != null) {
            $query->limit($limit);
        }

        return $query->get();
    }
}
