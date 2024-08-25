<?php

declare(strict_types=1);

namespace App\Services\Parsers;

use Exception;
use League\Csv\Reader;
use App\DTO\ParsedResolution;
use App\DTO\ParsedResolutionCollection;
use App\Contracts\ResolutionImportParserInterface;

class CSVResolutionParserService implements ResolutionImportParserInterface
{
    const REQUIRED_COLUMNS = [
        "Bezeichner",
        "Antragsteller*in",
        "Titel",
        "Text",
        "Sachgebiet",
        "Status",
    ];

    public function __construct(private $context, private ?string $delimiter = ",") {}

    public function parse(string $file): ParsedResolutionCollection
    {
        $path = storage_path('app/import/' . $file);

        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter($this->delimiter);

        $header = $csv->getHeader();


        $missingColumns = $this->validateHeader($header);
        if (!empty($missingColumns)) {
            $this->context->error('Missing columns in CSV file: ' . implode(', ', $missingColumns));
            return new ParsedResolutionCollection();
        }

        $records = $csv->getRecords();

        $parsedResolutions = new ParsedResolutionCollection();

        foreach ($records as $record) {
            $parsedResolution = $this->parseRowToResolutionDTO($record);
            if ($parsedResolution === null) {
                continue;
            }
            $parsedResolutions->add($parsedResolution);
        }


        return $parsedResolutions;
    }



    private function parseRowToResolutionDTO(array $row): ?ParsedResolution
    {
        if (!$this->validateRow($row)) {
            return null;
        }

        $parsedResolution = new ParsedResolution();

        $parsedResolution->title = $row['Titel'];
        $parsedResolution->tag = $row['Bezeichner'];
        $parsedResolution->applicants = explode(',', $row['Antragsteller*in']);
        $parsedResolution->text = $row['Text'];
        $parsedResolution->category = $this->parseCategory($row['Sachgebiet']);

        return $parsedResolution;
    }

    private function parseCategory(string $category): string
    {
        // the category is in the format "TAG - Category"
        // we only want the category, extract it with regex and trim it
        if (preg_match('/^[A-Za-z]+ - (.+)$/', $category, $matches)) {
            return trim($matches[1]);
        }

        return trim($category);
    }

    private function validateHeader(array $header): array
    {
        // check if all required columns are present in the header array. Return an array of missing columns
        return array_diff(self::REQUIRED_COLUMNS, $header);
    }

    private function validateRow(array $row): bool
    {
        foreach (self::REQUIRED_COLUMNS as $column) {
            if (!array_key_exists($column, $row)) {
                return false;
            }
            if (empty($row[$column])) {
                return false;
            }
        }

        return true;
    }
}
