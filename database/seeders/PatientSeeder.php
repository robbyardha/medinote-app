<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Patient::create([
            'name' => 'John Doe',
            'gender' => 'Laki-laki',
            'place_of_birth' => 'Jakarta',
            'date_of_birth' => '1990-05-10',
            'address' => 'Jl. Kebon Jeruk No. 12, Jakarta',
            'number_phone' => '081234567890',
            'email' => 'johndoe@example.com',
            'blood_type' => 'O',
            'work' => 'Software Engineer',
            'marital_status' => 'Menikah',
            'registration_date' => Carbon::now(),
            'status' => 'Active',
            'created_by' => 'admin',
            'updated_by' => 'admin',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        Patient::create(
            [
                'name' => 'Jane Smith',
                'gender' => 'Perempuan',
                'place_of_birth' => 'Bandung',
                'date_of_birth' => '1985-08-22',
                'address' => 'Jl. Merdeka No. 50, Bandung',
                'number_phone' => '082345678901',
                'email' => 'janesmith@example.com',
                'blood_type' => 'A',
                'work' => 'Dokter',
                'marital_status' => 'Menikah',
                'registration_date' => Carbon::now(),
                'status' => 'Active',
                'created_by' => 'admin',
                'updated_by' => 'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Patient::create(
            [
                'name' => 'Michael Johnson',
                'gender' => 'Laki-laki',
                'place_of_birth' => 'Surabaya',
                'date_of_birth' => '1992-11-15',
                'address' => 'Jl. Raya No. 99, Surabaya',
                'number_phone' => '083456789012',
                'email' => 'michaelj@example.com',
                'blood_type' => 'B',
                'work' => 'Pengusaha',
                'marital_status' => 'Belum Menikah',
                'registration_date' => Carbon::now(),
                'status' => 'Active',
                'created_by' => 'admin',
                'updated_by' => 'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Patient::create(
            [
                'name' => 'Lina Puspita',
                'gender' => 'Perempuan',
                'place_of_birth' => 'Yogyakarta',
                'date_of_birth' => '1988-06-30',
                'address' => 'Jl. Sisingamangaraja No. 34, Yogyakarta',
                'number_phone' => '081654321098',
                'email' => 'linapuspita@example.com',
                'blood_type' => 'AB',
                'work' => 'Guru',
                'marital_status' => 'Menikah',
                'registration_date' => Carbon::now(),
                'status' => 'Active',
                'created_by' => 'admin',
                'updated_by' => 'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Patient::create(
            [
                'name' => 'Rudi Santoso',
                'gender' => 'Laki-laki',
                'place_of_birth' => 'Medan',
                'date_of_birth' => '1980-01-01',
                'address' => 'Jl. Pahlawan No. 123, Medan',
                'number_phone' => '082134567890',
                'email' => 'rudi.santoso@example.com',
                'blood_type' => 'O',
                'work' => 'Tukang Bangunan',
                'marital_status' => 'Duda',
                'registration_date' => Carbon::now(),
                'status' => 'Active',
                'created_by' => 'admin',
                'updated_by' => 'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Patient::create(
            [
                'name' => 'Ahmad Fadhil',
                'gender' => 'Laki-laki',
                'place_of_birth' => 'Medan',
                'date_of_birth' => '1995-02-10',
                'address' => 'Jl. Kenanga No. 8, Medan',
                'number_phone' => '085678901234',
                'email' => 'ahmadfadhil@example.com',
                'blood_type' => 'A',
                'work' => 'Petani',
                'marital_status' => 'Belum Menikah',
                'registration_date' => Carbon::now(),
                'status' => 'Active',
                'created_by' => 'admin',
                'updated_by' => 'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Patient::create(
            [
                'name' => 'Siti Rahmawati',
                'gender' => 'Perempuan',
                'place_of_birth' => 'Palembang',
                'date_of_birth' => '1993-04-20',
                'address' => 'Jl. Merpati No. 55, Palembang',
                'number_phone' => '087654321987',
                'email' => 'sitirahmawati@example.com',
                'blood_type' => 'B',
                'work' => 'Pekerja Sosial',
                'marital_status' => 'Menikah',
                'registration_date' => Carbon::now(),
                'status' => 'Active',
                'created_by' => 'admin',
                'updated_by' => 'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        Patient::create(
            [
                'name' => 'Budi Santosa',
                'gender' => 'Laki-laki',
                'place_of_birth' => 'Medan',
                'date_of_birth' => '1988-07-15',
                'address' => 'Jl. Sudirman No. 17, Medan',
                'number_phone' => '081223344556',
                'email' => 'budi.santosa@example.com',
                'blood_type' => 'AB',
                'work' => 'Karyawan Swasta',
                'marital_status' => 'Menikah',
                'registration_date' => Carbon::now(),
                'status' => 'Disactive',
                'created_by' => 'admin',
                'updated_by' => 'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
    }
}
