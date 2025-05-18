<?php

namespace Database\Seeders;

use App\Models\Shift;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShiftTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Shift::firstOrCreate([
            'name' => 'Morning Shift',
            'gender' => 'male',
            'start_time' => '08:00:00',
            'end_time' => '12:00:00',
        ]);
    }
}
