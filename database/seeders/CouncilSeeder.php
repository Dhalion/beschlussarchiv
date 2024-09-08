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
                "shortName" => $this->getShortName($name),
            ]);
        }
    }

    // returns string with capitalized first letters of each word
    private function getShortName(string $name): string
    {
        $shortName = "";
        $words = explode(" ", $name);
        foreach ($words as $word) {
            $shortName .= ucfirst($word[0]);
        }
        return $shortName;
    }
}
