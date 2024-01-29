<?php

namespace Database\Seeders;

use App\Services\NewsAPI\NewsAPIService;
use App\Models\Source;
use App\Models\Article;
use App\Models\Category;
use App\Models\Country;
use App\Models\Author;
use App\Models\Language;
use App\Models\ErrorLogs;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class SyncNewsAPI extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**Sync NewsAPI Categories*/
        $this->command->info('Start Syncing NewsAPI Categories.....');
        
        foreach (app(NewsAPIService::class)->getCategories() as $category)
        {
            if(!Category::where('name', $category)->exists()) Category::create(['name' => $category]);
        }
        
        $this->command->info('End Syncing NewsAPI Categories.....');

        /**Sync NewsAPI Countries*/
        $this->command->info('Start Syncing NewsAPI Countries.....');
        
        foreach (app(NewsAPIService::class)->getCountries() as $country)
        {
            if(!Country::where('code', $country)->exists()) Country::create(['code' => $country]);
        }
        
        $this->command->info('End Syncing NewsAPI Countries.....');

        /**Sync NewsAPI Languages*/
        $this->command->info('Start Syncing NewsAPI Languages.....');
        
        foreach (app(NewsAPIService::class)->getLanguages() as $language)
        {
            if(!Language::where('code', $language)->exists()) Language::create(['code' => $language]);
        }
        
        $this->command->info('End Syncing NewsAPI Languages.....');

        /**Sync NewsAPI Sources*/
        $this->command->info('Start Syncing NewsAPI Sources.....');
        
        foreach (Category::all() as $category)
        {
            foreach (app(NewsAPIService::class)->getSources($category->name) as $source)
            {
                if (!Source::where('external_id', $source->id)->exists())
                {
                    Source::create([
                        'external_id' => $source->id,
                        'name' => $source->name,
                        'description' => $source->description,
                        'url' => $source->url,
                        'category_id' => Category::where('name', $source->category)->first()?->id,
                        'language_id' => Language::where('code', $source->language)->first()?->id,
                        'country_id' =>  Country::where('code', $source->country)->first()?->id
                    ]);
                }
            }
        }

        $this->command->info('End Syncing NewsAPI Sources.....');

        /**Sync NewsAPI TopHeadlines*/
        $this->command->info('Start Syncing NewsAPI TopHeadlines.....');

        foreach (Source::all() as $source)
        {
            foreach (app(NewsAPIService::class)->getTopHeadlines(null, $source->external_id) as $topArticle)
            {
                $author =  isset($topArticle->author) ? $this->getAuthor($topArticle->author) : null;

                if(!Article::where('title', $topArticle->title)->exists())
                {
                    try
                    {
                        Article::create([
                            'source_id' => $source->id,
                            'author_id' => $author->id ?? null,
                            'title' => $topArticle->title,
                            'description' => $topArticle->description,
                            'url' => $topArticle->url,
                            'image' => $topArticle->urlToImage,
                            'published_at' => Carbon::parse($topArticle->publishedAt),
                            'content' => $topArticle->content,                        
                            'is_top' => 1
                        ]);
                    } catch (Exception $exception) {
                        ErrorLogs::addToLog('Failed Syncing NewsAPI TopHeadlines', $exception->getMessage());
                    }
                }
            }
        }

        $this->command->info('End Syncing NewsAPI TopHeadlines.....');

        /**Sync NewsAPI Everything*/
        $this->command->info('Start Syncing NewsAPI Everything.....');

        foreach (Source::all() as $source)
        {
            foreach (app(NewsAPIService::class)->getEverything(null, $source->external_id) as $article)
            {
                if(!Article::where('title', $article->title)->exists())
                {
                    $author =  isset($article->author) ? $this->getAuthor($article->author) : null;

                    if(!Article::where('title', $topArticle->title)->exists())
                    {
                        try
                        {
                            Article::create([
                                'source_id' => $source->id,
                                'author_id' => $author->id ?? null,
                                'title' => $article->title,
                                'description' => $article->description,
                                'url' => $article->url,
                                'image' => $article->urlToImage,
                                'published_at' => Carbon::parse($article->publishedAt) ?? null,
                                'content' => $article->content
                            ]);
                        } catch (Exception $exception) {
                            ErrorLogs::addToLog('Failed Syncing NewsAPI TopHeadlines', $exception->getMessage());
                        }
                    }
                }
            }
         }
 
         $this->command->info('End Syncing NewsAPI Everything.....');
    }

    public function getAuthor($author): Author
    {
        return Author::where('name', $author)->first() ?? Author::create(['name' => $author]);

        //if (str_contains($author, ','))
        //{
        //    foreach (explode(',', $author) as $articleAuthor)
        //        $author = Author::where('name', $articleAuthor)->first() ?? Author::create(['name' => $articleAuthor]);
        //}
        //else
        //    $author = Author::where('name', $author)->first() ?? Author::create(['name' => $author]);

        //return $author;
    }
}