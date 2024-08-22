<?php

namespace App\Console\Commands;

use App\Models\Applicant;
use App\Models\Category;
use App\Models\Council;
use App\Models\Resolution;
use Illuminate\Console\Command;

class InitSearch extends Command
{
    protected $signature = 'archive:init-search';

    protected $description = 'Initialize the search index for the archive';

    private array $searchableModels = [
        Resolution::class,
        Applicant::class,
        Category::class,
    ];

    public function handle()
    {
        $this->info('Initializing search index...');

        // run php artisan scout:sync-index-settings
        $this->call('scout:sync-index-settings');


        $this->info('Indexing models...');
        foreach ($this->searchableModels as $model) {
            $this->info("Indexing {$model}...");
            // run php artisan scout:import "App\Models\Resolution"
            $this->call('scout:import', ['model' => $model]);
        }

        $this->info('Search index initialized.');
    }
}
