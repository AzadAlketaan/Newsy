<?php

namespace Database\Seeders;

use App\Services\GuardianNews\GuardianNewsAPIService;
use App\Models\Source;
use App\Models\Article;
use App\Models\Category;
use App\Models\Country;
use App\Models\Author;
use App\Models\Language;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SyncGuardianNewsAPI extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**Sync GuardianNews Categories*/
        $this->command->info('Start Syncing GuardianNews Categories.....');
        
        foreach (app(GuardianNewsAPIService::class)->getTags() as $category)
        {
            if(!Category::where('name', $category['webTitle'])->exists()) Category::create(['name' => $category['webTitle'], 'external_id' => $category['id']]);
        }

        $this->command->info('End Syncing GuardianNews Categories.....');

        /**Sync GuardianNews Everything*/
        $this->command->info('Start Syncing GuardianNews Sections.....');

        foreach (app(GuardianNewsAPIService::class)->getSections() as $section)
        { 
            if(!Source::where('external_id', $section['id'])->exists())
            {
                Source::create([
                    'external_id' => $section['id'],
                    'name' => $section['webTitle'],
                    'url' => $section['webUrl']
                ]);
            }

            if(!Author::where('name',  $section['editions'][0]['webTitle'])->exists())
                Author::create(['name' =>  $section['editions'][0]['webTitle']]);            
        }
        
        $this->command->info('End Syncing GuardianNews Sections.....');

        $this->command->info('Start Syncing GuardianNews Everything.....');

        foreach (app(GuardianNewsAPIService::class)->getEverything() as $article)
        {
            if(!Article::where('title', $article['webTitle'])->exists())
            {
                Article::create([
                    'source_id' => Source::where('name', $article['sectionName'])->first()?->id,
                    'title' => $article['webTitle'] ?? null,
                    'url' => $article['webUrl'] ?? null,
                    'published_at' => Carbon::parse($article['webPublicationDate']) ?? null,
                    'is_top' => $article['isHosted'] ? 1 : 0
                ]);
            }
        }
        
        $this->command->info('End Syncing GuardianNews Everything.....');
    }
}