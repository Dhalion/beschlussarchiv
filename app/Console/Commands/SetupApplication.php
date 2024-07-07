<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class SetupApplication extends Command
{
    protected $signature = 'wiki:setup';
    protected $description = 'Führt die notwendigen Schritte zur Einrichtung der Anwendung aus.';

    public function handle()
    {
        $this->createImportDirectory();
        $this->info('Die Anwendung wurde erfolgreich eingerichtet.');
    }

    protected function createImportDirectory()
    {
        $path = storage_path('app/import');

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
            $this->info('Import-Verzeichnis wurde erstellt: ' . $path);
        } else {
            $this->info('Import-Verzeichnis existiert bereits: ' . $path);
        }
    }
}
