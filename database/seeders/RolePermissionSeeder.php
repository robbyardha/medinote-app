<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::updateOrCreate(['name' => '/dashboard'], ['name' => '/dashboard']);
        Permission::updateOrCreate(['name' => '/setting'], ['name' => '/setting']);

        // Access Role
        Permission::updateOrCreate(['name' => '/access'], ['name' => '/access']);
        Permission::updateOrCreate(['name' => '/access/role'], ['name' => '/access/role']);
        Permission::updateOrCreate(['name' => '/access/role/create'], ['name' => '/access/role/create']);
        Permission::updateOrCreate(['name' => '/access/role/edit'], ['name' => '/access/role/edit']);
        Permission::updateOrCreate(['name' => '/access/role/update'], ['name' => '/access/role/update']);
        Permission::updateOrCreate(['name' => '/access/role/delete'], ['name' => '/access/role/delete']);


        // Access Menu
        Permission::updateOrCreate(['name' => '/access'], ['name' => '/access']);
        Permission::updateOrCreate(['name' => '/access/menu'], ['name' => '/access/menu']);
        Permission::updateOrCreate(['name' => '/access/menu/create'], ['name' => '/access/menu/create']);
        Permission::updateOrCreate(['name' => '/access/menu/edit'], ['name' => '/access/menu/edit']);
        Permission::updateOrCreate(['name' => '/access/menu/update'], ['name' => '/access/menu/update']);
        Permission::updateOrCreate(['name' => '/access/menu/delete'], ['name' => '/access/menu/delete']);

        // Access Sub Menu
        Permission::updateOrCreate(['name' => '/access/submenu'], ['name' => '/access/submenu']);
        Permission::updateOrCreate(['name' => '/access/submenu/create'], ['name' => '/access/submenu/create']);
        Permission::updateOrCreate(['name' => '/access/submenu/edit'], ['name' => '/access/submenu/edit']);
        Permission::updateOrCreate(['name' => '/access/submenu/update'], ['name' => '/access/submenu/update']);
        Permission::updateOrCreate(['name' => '/access/submenu/delete'], ['name' => '/access/submenu/delete']);

        // Access Permission
        Permission::updateOrCreate(['name' => '/access/permission'], ['name' => '/access/permission']);
        Permission::updateOrCreate(['name' => '/access/permission/create'], ['name' => '/access/permission/create']);
        Permission::updateOrCreate(['name' => '/access/permission/edit'], ['name' => '/access/permission/edit']);
        Permission::updateOrCreate(['name' => '/access/permission/update'], ['name' => '/access/permission/update']);
        Permission::updateOrCreate(['name' => '/access/permission/delete'], ['name' => '/access/permission/delete']);

        // Access Give Permission
        Permission::updateOrCreate(['name' => '/access/give-permission'], ['name' => '/access/give-permission']);
        Permission::updateOrCreate(['name' => '/access/give-permission/create'], ['name' => '/access/give-permission/create']);
        Permission::updateOrCreate(['name' => '/access/give-permission/edit'], ['name' => '/access/give-permission/edit']);
        Permission::updateOrCreate(['name' => '/access/give-permission/update'], ['name' => '/access/give-permission/update']);
        Permission::updateOrCreate(['name' => '/access/give-permission/delete'], ['name' => '/access/give-permission/delete']);

        // Master User
        Permission::updateOrCreate(['name' => '/master'], ['name' => '/master']);
        Permission::updateOrCreate(['name' => '/master/user'], ['name' => '/master/user']);
        Permission::updateOrCreate(['name' => '/master/user/create'], ['name' => '/master/user/create']);
        Permission::updateOrCreate(['name' => '/master/user/edit'], ['name' => '/master/user/edit']);
        Permission::updateOrCreate(['name' => '/master/user/update'], ['name' => '/master/user/update']);
        Permission::updateOrCreate(['name' => '/master/user/delete'], ['name' => '/master/user/delete']);

        // Master pasien
        Permission::updateOrCreate(['name' => '/master/patient'], ['name' => '/master/patient']);
        Permission::updateOrCreate(['name' => '/master/patient/create'], ['name' => '/master/patient/create']);
        Permission::updateOrCreate(['name' => '/master/patient/edit'], ['name' => '/master/patient/edit']);
        Permission::updateOrCreate(['name' => '/master/patient/update'], ['name' => '/master/patient/update']);
        Permission::updateOrCreate(['name' => '/master/patient/delete'], ['name' => '/master/patient/delete']);

        // Pendaftaran Pemeriksaan
        Permission::updateOrCreate(['name' => '/exam'], ['name' => '/exam']);
        Permission::updateOrCreate(['name' => '/exam/registration-examination'], ['name' => '/exam/registration-examination']);
        Permission::updateOrCreate(['name' => '/exam/registration-examination/create'], ['name' => '/exam/registration-examination/create']);
        Permission::updateOrCreate(['name' => '/exam/registration-examination/edit'], ['name' => '/exam/registration-examination/edit']);
        Permission::updateOrCreate(['name' => '/exam/registration-examination/update'], ['name' => '/exam/registration-examination/update']);
        Permission::updateOrCreate(['name' => '/exam/registration-examination/delete'], ['name' => '/exam/registration-examination/delete']);
        Permission::updateOrCreate(['name' => '/exam/registration-examination/call'], ['name' => '/exam/registration-examination/call']);

        // Pemeriksaan
        Permission::updateOrCreate(['name' => '/exam'], ['name' => '/exam']);
        Permission::updateOrCreate(['name' => '/exam/examination'], ['name' => '/exam/examination']);
        Permission::updateOrCreate(['name' => '/exam/examination/create'], ['name' => '/exam/examination/create']);
        Permission::updateOrCreate(['name' => '/exam/examination/edit'], ['name' => '/exam/examination/edit']);
        Permission::updateOrCreate(['name' => '/exam/examination/update'], ['name' => '/exam/examination/update']);
        Permission::updateOrCreate(['name' => '/exam/examination/delete'], ['name' => '/exam/examination/delete']);

        // Invoice Payment
        Permission::updateOrCreate(['name' => '/invoice'], ['name' => '/invoice']);
        Permission::updateOrCreate(['name' => '/invoice/payment'], ['name' => '/invoice/payment']);
        Permission::updateOrCreate(['name' => '/invoice/payment/create'], ['name' => '/invoice/payment/create']);
        Permission::updateOrCreate(['name' => '/invoice/payment/edit'], ['name' => '/invoice/payment/edit']);
        Permission::updateOrCreate(['name' => '/invoice/payment/update'], ['name' => '/invoice/payment/update']);
        Permission::updateOrCreate(['name' => '/invoice/payment/delete'], ['name' => '/invoice/payment/delete']);
        Permission::updateOrCreate(['name' => '/invoice/payment/pay'], ['name' => '/invoice/payment/pay']);
    }
}
