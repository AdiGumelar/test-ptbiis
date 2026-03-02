<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employees;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [1, 2, 3]; // sesuaikan dengan id posisi kamu

        for ($i = 1; $i <= 10; $i++) {

            Employees::create([
                'employee_code' => 'EMP' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'positions_id' => $positions[array_rand($positions)],
                'name' => fake()->name(),
                'email' => 'pegawai' . $i . '@example.com',
                'phone' => '08' . rand(1000000000, 9999999999),
                'gender' => rand(0,1) ? 'male' : 'female',
                'birth_place' => fake()->city(),
                'birth_date' => fake()->date('Y-m-d', '2005-01-01'),
                'hire_date' => fake()->date('Y-m-d'),
                'salary' => rand(3000000, 10000000),
                'status' => rand(0,1) ? 'active' : 'inactive',
                'photo' => null,
            ]);
        }
    }
}
