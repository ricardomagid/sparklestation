<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Character;
use App\Models\Lightcone; 
use Illuminate\Support\Str;

class RegenerateSlugs extends Command
{
    /**
     * The name and signature of the console command
     *
     * @var string
     */
    protected $signature = 'slugs:regenerate';

    /**
     * The console command description
     *
     * @var string
     */
    protected $description = 'Regenerate slugs for all characters and lightcones';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Regenerate slugs for characters
        $this->info('Regenerating character slugs...');
        $this->regenerateSlugsForModel(Character::class, 'name', 'slug');

        // Regenerate slugs for lightcones
        $this->info('Regenerating lightcone slugs...');
        $this->regenerateSlugsForModel(Lightcone::class, 'name', 'slug');

        $this->info('Slugs regenerated for all characters and lightcones.');
    }

    /**
     * Regenerate slugs for a given model
     *
     * @param  string  $model
     * @param  string  $nameColumn
     * @param  string  $slugColumn
     * @return void
     */
    private function regenerateSlugsForModel(string $model, string $nameColumn, string $slugColumn)
    {
        // Process the model data in chunks
        $model::select('id', $nameColumn, $slugColumn)->chunk(100, function ($items) use ($nameColumn, $slugColumn) {
            foreach ($items as $item) {
                // Skip if slug is already set
                if (!empty($item->{$slugColumn})) {
                    $this->info("Skipping {$item->{$nameColumn}} as it already has a slug: {$item->{$slugColumn}}");
                    continue;
                }
    
                $baseSlug = Str::slug($item->{$nameColumn});
                $slug = $this->generateUniqueSlug($baseSlug, $item->id, $item::class, $slugColumn);
    
                // Update the model's slug
                $item->{$slugColumn} = $slug;
                $item->save();
    
                $this->info("Slug for {$item->{$nameColumn}} regenerated: {$slug}");
            }
        });
    }
    
    /**
     * Generate a unique slug by checking existing records
     *
     * @param  string  $base
     * @param  int  $id
     * @param  string  $modelClass
     * @param  string  $slugColumn
     * @return string
     */
    private function generateUniqueSlug(string $base, int $id, string $modelClass, string $slugColumn): string
    {
        $slug = $base;

        // Check for duplicates and append a number if needed
        while (
            $modelClass::where($slugColumn, $slug)
                ->where('id', '!=', $id)
                ->exists()
        ) {
            $slug = $base . '-' . $id;
        }

        return $slug;
    }
}
