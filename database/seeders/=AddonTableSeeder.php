<?php

namespace Database\Seeders;

use App\Models\Addon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Addon::create(
            [
                'name' => 'sauna',
                'description' => 'Relaxing sauna sessions to help you unwind and detoxify.',
                'price' => 30.00,
            ],
            [
                'name' => 'cardio',
                'description' => 'Invigorating cardio sessions to get your heart pumping and boost your endurance.',
                'price' => 25.00,
            ]
        );
    }
}
