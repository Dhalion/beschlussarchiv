<?php

declare(strict_types=1);

namespace App\Services\Parsers;

use App\Contracts\ResolutionImportParserInterface;
use App\DTO\ParsedResolution;
use App\DTO\ParsedResolutionCollection;
use App\Models\Category;
use App\Models\Council;
use Illuminate\Support\Facades\Log;
use Swaggest\JsonSchema\Schema;

const RES_COLLECTION_SCHEMA_NAME = "resolution-collection.schema.json";

class JSONResolutionParser implements ResolutionImportParserInterface
{

    public function __construct(private $context) {}

    public function parse(string $file): ParsedResolutionCollection
    {
        $filepath = storage_path('app/import/' . $file);
        if ($this->validateFile($filepath)) {
            $this->context->info('File ' . $file . ' validated against schema successfully');
        } else {
            $this->context->error('File ' . $file . ' could not be validated against schema');
            throw new \Exception('File ' . $file . ' could not be validated against schema');
        }

        $data = json_decode(file_get_contents($filepath), true, flags: JSON_UNESCAPED_UNICODE);

        $parsedResolutions = new ParsedResolutionCollection();

        $metaData = $data['meta'] ?? [];
        $resolutions = $data['resolutions'] ?? [];
        $mappedCategories = $this->parseCategories($metaData);


        if (empty($resolutions)) {
            $this->context->error('No resolutions found in file ' . $file);
            throw new \Exception('No resolutions found in file ' . $file);
        }

        foreach ($resolutions as $resolution) {
            $parsedResolution = $this->parseResolution($resolution, $mappedCategories);
            if ($parsedResolution === null) {
                continue;
            }
            $parsedResolutions->add($parsedResolution);
        }

        return $parsedResolutions;
    }

    private function parseResolution(array $resolution, array $mappedCategories): ?ParsedResolution
    {
        $parsedResolution = new ParsedResolution();

        $parsedResolution->title = (string) $resolution['title'];
        $parsedResolution->tag = (string) $resolution['tag'];
        $parsedResolution->year = (string) $resolution['year'];
        $parsedResolution->applicants = (array) $resolution['applicants'];
        $parsedResolution->text = (string) $resolution['text'];
        // Strip numbers from the tag
        $categoryTag = str_replace(range(0, 9), '', $parsedResolution->tag);
        $parsedResolution->category = $mappedCategories[$categoryTag] ?? null;

        if ($parsedResolution->category === null) {
            $this->context->error('No category found for resolution with tag ' . $parsedResolution->tag);
            return null;
        }

        return $parsedResolution;
    }

    private function parseCategories($meta): array
    {
        $categories = $meta['categories'] ?? [];

        if (empty($categories)) {
            $this->context->info('No categories found in meta data. Using default categories.');
            return $this->getDefaultCouncilCategories();
        }
        $categoriesMapping = [];

        $council = $this->context->council ?? Council::where('default', true)->first()->id;

        foreach ($categories as $category) {
            // Stored as 'A:Leitanträge' ...
            [$tag, $name] = explode(':', $category);
            $categoryId = Category::where(
                'council_id',
                $council
            )->where('name', $name)->first()->id ?? null;

            if ($categoryId === null) {
                $categoryId = $this->createCategory($name, $tag);
                $this->context->info('Created category ' . $name . ' with tag ' . $tag . ' and id ' . $categoryId);
            }

            $categoriesMapping[$tag] = $categoryId;
        }

        return $categoriesMapping;
    }

    private function getDefaultCouncilCategories(): array
    {
        return Category::where('council_id', $this->context->council)
            ->pluck('id', 'tag')
            ->toArray();
    }

    private function createCategory(string $name, string $tag): string
    {
        $category = new Category();
        $category->name = $name;
        $category->tag = $tag;
        $category->council_id = $this->context->council;
        $category->save();

        return $category->id;
    }

    private function validateFile($filePath)
    {
        // Pfad zum Hauptschema
        $mainSchemaPath = storage_path('app/schemas/' . RES_COLLECTION_SCHEMA_NAME);

        // Laden und Dekodieren des Hauptschemas
        $mainSchemaContent = file_get_contents($mainSchemaPath);
        $mainSchema = json_decode($mainSchemaContent, true);

        // Ersetzen der relativen Pfade durch absolute Pfade
        $this->resolveRefs($mainSchema, dirname($mainSchemaPath));

        // Importieren des Schemas
        $schema = Schema::import(json_decode(json_encode($mainSchema)));

        // Validieren der Datei gegen das Schema
        $data = json_decode(file_get_contents($filePath));
        return $schema->in($data);
    }

    private function resolveRefs(array &$schema, string $basePath)
    {
        foreach ($schema as $key => &$value) {
            if (is_array($value)) {
                $this->resolveRefs($value, $basePath);
            } elseif ($key === '$ref' && is_string($value)) {
                $value = $basePath . '/' . $value;
            }
        }
    }
}
