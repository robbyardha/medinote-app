<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Developer',
            'username' => 'developer',
            'email' => 'developer@gmail.com',
            'password' => Hash::make('developer')
        ]);
        User::factory()->create([
            'name' => 'Dokter',
            'username' => 'dokter',
            'email' => 'dokter@gmail.com',
            'password' => Hash::make('dokter')
        ]);
        User::factory()->create([
            'name' => 'Apoteker',
            'username' => 'apoteker',
            'email' => 'apoteker@gmail.com',
            'password' => Hash::make('apoteker')
        ]);
        User::factory()->create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin')
        ]);


        $this->call(MenuSeeder::class);
        $this->call(SubMenuSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(PatientSeeder::class);
    }
}
