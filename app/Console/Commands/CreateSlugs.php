<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Resolution;
use Illuminate\Console\Command;

class CreateSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'archive:create-slugs {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create slugs for categories and resolutions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $model = $this->argument('model');

        if ($model === 'category') {
            $categories = Category::all();

            foreach ($categories as $category) {
                // read slug, so it gets updated
                $slug = $category->slug;
                $this->info("Category $category->name slug: $slug");
            }
        } elseif ($model === 'resolution') {
            $resolutions = Resolution::all();

            foreach ($resolutions as $resolution) {
                // read slug, so it gets updated
                $slug = $resolution->slug;
                $this->info("Resolution $resolution->getResolutionCode() $resolution->title slug: $slug");
            }
        }

        $this->info('Slugs created successfully');
    }
}
