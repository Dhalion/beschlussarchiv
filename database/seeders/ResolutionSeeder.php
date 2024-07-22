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
            // Ensure we're getting an array of UUID strings
            $randomApplicantUuids = $applicants->random(rand(1, 5))->pluck('id')->all();

            // Debugging: Log the UUIDs to ensure they're what we expect
            Log::debug('Attaching Applicant UUIDs to Resolution:', $randomApplicantUuids);

            // Attach the applicants using their UUIDs
            $resolution->applicants()->attach($randomApplicantUuids);
        });
    }
}
