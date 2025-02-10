<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::updateOrCreate(['name' => 'developer'], ['name' => 'developer']);
        $role2 = Role::updateOrCreate(['name' => 'dokter'], ['name' => 'dokter']);
        $role3 = Role::updateOrCreate(['name' => 'apoteker'], ['name' => 'apoteker']);
        $role4 = Role::updateOrCreate(['name' => 'admin'], ['name' => 'admin']);

        $user = User::where("id", 1)->first();
        $user->assignRole($role);

        $user = User::where("id", 2)->first();
        $user->assignRole($role2);

        $user = User::where("id", 3)->first();
        $user->assignRole($role3);

        $user = User::where("id", 4)->first();
        $user->assignRole($role4);
    }
}
