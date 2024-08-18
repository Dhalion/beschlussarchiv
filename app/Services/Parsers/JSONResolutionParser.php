<?php

declare(strict_types=1);

namespace App\Services\Parsers;

use App\Contracts\ResolutionImportParserInterface;
use App\DTO\ParsedResolutionCollection;
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

        return new ParsedResolutionCollection();
    }

    public function validateFile($filePath)
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
