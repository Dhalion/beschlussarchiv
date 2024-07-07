<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\ParsedResolution;
use App\DTO\ParsedResolutionCollection;
use App\Models\Category;
use App\Models\Council;
use App\Models\Resolution;
use Dotenv\Util\Regex;

class ResolutionImportService
{
    private Council $councilScope;

    public function __construct(
        private string $councilId,
        private int $year
    ) {
        $this->councilScope = Council::findOrFail($councilId);
    }

    public function importResolutions(ParsedResolutionCollection $resolutions): void
    {
        foreach ($resolutions as $resolution) {
            $this->importResolution($resolution);
        }
    }

    public function importResolution(ParsedResolution $resolutionDTO): void
    {
        $resolution = new Resolution();
        $resolution->title = $resolutionDTO->title;
        $resolution->tag = $resolutionDTO->tag;
        $resolution->year = $resolutionDTO->year ?? $this->year;
        $resolution->text = $resolutionDTO->text;
        $resolution->category_id = $this->getCategoryId($resolutionDTO->category, $resolutionDTO->tag);
        $resolution->council_id = $this->councilScope->id;

        $resolution->save();
    }

    private function getCategoryId(string $categoryName, string $tag, bool $createIfNotExists = true): string
    {
        // Tag is like A123 or INI1 or similar
        // categoryTag is like "A" or "INI"
        // fetch the letters from the tag until the first number
        $categoryTag = preg_replace('/[^a-zA-Z]/', '', $tag);
        $category = Category::firstOrCreate([
            'name' => $categoryName,
            'tag' => $categoryTag,
            'council_id' => $this->councilScope->id,
        ]);

        return $category->id;
    }
}
