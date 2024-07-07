<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ResolutionImportService;
use App\Contracts\ResolutionImportParserInterface;
use App\Models\Council;
use App\Services\Parsers\CSVResolutionParserService;

class ImportResolutionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wiki:import {file} {--council=default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports resolutions from a file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $file = $this->argument('file');
        $council = $this->option('council');

        if (!$this->fileExists($file)) {
            $this->error('The file does not exist: ' . $file);
            return;
        }

        if ($council === 'default') {
            $council = $this->getDefaultCouncilId();
        }

        $this->info('Importing resolutions from file: ' . $file);
        $this->info('Council: ' . $council);

        $parser = $this->getImportParser($file);
        $parsedResolutions = $parser->parse($file);

        $this->info('Parsed ' . $parsedResolutions->count() . ' resolutions');

        $importer = new ResolutionImportService($council, date('Y'));
        $importer->importResolutions($parsedResolutions);
    }

    private function fileExists(string $file): bool
    {
        $path = storage_path('app/import/' . $file);
        return file_exists($path);
    }

    private function getImportParser(string $file): ResolutionImportParserInterface
    {
        $extension = pathinfo($file, PATHINFO_EXTENSION);

        if ($extension === 'csv') {
            return new CSVResolutionParserService();
        }

        throw new \Exception('Unsupported file format: ' . $extension);
    }

    private function getDefaultCouncilId(): string
    {
        return Council::where('name', 'Bundesebene')->firstOrFail()->id;
    }
}
