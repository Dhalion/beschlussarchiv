<?php

namespace Database\Seeders;

use App\Models\Council;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouncilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            "Bundesebene",
            // "Rheinland-Pfalz",
            // "Baden-Württemberg",
            // "Hessen",
            // "Bayern",
            // "Nordrhein-Westfalen",
            // "Niedersachsen",
            // "Schleswig-Holstein",
            // "Mecklenburg-Vorpommern",
            // "Brandenburg",
            // "Sachsen",
            // "Sachsen-Anhalt",
            // "Thüringen",
            // "Berlin",
            // "Hamburg",
            // "Bremen",
            // "Saarland",
        ];
        foreach ($names as $name) {
            Council::create([
                "name" => $name,
            ]);
        }
    }
}
