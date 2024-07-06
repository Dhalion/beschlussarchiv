<?php

namespace Database\Seeders;

use App\Models\Applicant;
use Database\Factories\ApplicantFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Applicant::factory()->count(10)->create();
    }
}
