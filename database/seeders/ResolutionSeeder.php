<?php

namespace Database\Seeders;

use App\Models\Applicant;
use App\Models\Resolution;
use Database\Factories\ResolutionFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ResolutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resolutions = Resolution::factory()->count(30)->create();

        $applicants = Applicant::all();

        $resolutions->each(function (Resolution $resolution) use ($applicants) {
            $randomApplicantUuids = $applicants->random(rand(1, 5))->pluck('id')->all();

            $resolution->applicants()->attach($randomApplicantUuids);
        });
    }
}
