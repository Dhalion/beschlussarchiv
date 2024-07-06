<?php

namespace Database\Seeders;

use App\Models\Resolution;
use Database\Factories\ResolutionFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResolutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Resolution::factory()->count(30)->create();
    }
}
