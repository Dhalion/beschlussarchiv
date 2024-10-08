<?php

namespace App\Console\Commands;

use App\Models\Council;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class SetupApplication extends Command
{
    protected $signature = 'archive:setup';
    protected $description = 'Führt die notwendigen Schritte zur Einrichtung der Anwendung aus.';

    public function handle()
    {
        $this->createImportDirectory();
        $this->createDefaultCouncil();
        $this->createAdminUser();
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

    protected function createDefaultCouncil(): void
    {
        if (Council::where('default', true)->exists()) {
            $this->info('Default Council existiert bereits.');
            return;
        }
        $council = new Council();
        $council->name = 'Bundesebene';
        $council->shortName = 'Bund';
        $council->default = true;
        $council->save();
    }

    protected function createAdminUser(): void
    {
        if (User::where('name', 'admin')->exists()) {
            $this->info('Admin-Benutzer existiert bereits.');
            return;
        }
        $user = new User();
        $user->name = 'admin';
        $user->email = 'admin@example.com';
        $user->password = "password";
        $user->admin = true;
        $user->save();
        $user->councils()->attach(Council::where('default', true)->first());
        $this->info('Admin-Benutzer wurde erstellt.');
    }
}
