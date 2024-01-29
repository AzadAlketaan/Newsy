<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\UserFavorite;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class ArticleRepository
{
    public function getArticlesQuery()
    {
        return Article::query()->orderByDesc('published_at');
    }

    public function getNewsFeedArticlesQuery()
    {
        return Article::query()->where('is_top', 1)->orderByDesc('published_at');
    }

    public function getArticlesBySource($article, int $source_id)
    {
        return $article->where('source_id', $id);
    }

    public function getArticlesBySources($article, Array $source_names)
    {
        return $article->orWhereHas('Source', function ($q) use ($source_names) {
            $q->WhereIn('name', $source_names);
        });
    }

    public function getArticlesByCategory($article, int $category_id)
    {
        return $article->whereHas('Source', function ($q) use ($category_id) {
            $q->where('category_id', $category_id);
        });
    }

    public function getArticlesByCategories($article, Array $category_names)
    {
        return $article->orWhereHas('Source', function ($q) use ($category_names) {
            $q->whereHas('Category', function ($q) use ($category_names) {
                $q->orWhereIn('name', $category_names);
            });
        });
    }

    public function getArticlesByLanguage($article, int $language_id)
    {
        return $article->whereHas('Source', function ($q) use ($language_id) {
            $q->where('language_id', $language_id);
        });
    }

    public function getArticlesByCountry($article, int $country_id)
    {
        return $article->whereHas('Source', function ($q) use ($country_id) {
            $q->where('country_id', $country_id);
        });
    }

    public function getArticlesByAuthor($article, int $author_id)
    {
        return $article->where('author_id', $author_id);
    }

    public function getArticlesByAuthors($article, Array $author_names)
    {
        return $article->orWhereHas('Author', function ($q) use ($author_names) {
            $q->whereIn('name', $author_names);
        });
    }

    public function getArticlesByPublishedDate($article, $fromDate = null, $toDate = null)
    {
        if (isset($fromDate)) $article->where('published_at', '>=', Carbon::parse($fromDate)->format('Y-m-d'));

        if (isset($toDate)) $article->where('published_at', '<=', Carbon::parse($toDate)->format('Y-m-d'));        
        
        return $article;
    }

    public function getArticlesByTitle($article, String $title)
    {
        return $article->where('title', 'LIKE', '%' . $title . '%');
    }

    public function getArticlesByTitleOrDesc($article, String $search)
    {
        return $article->where('title', 'LIKE', '%' . $search . '%')->orwhere('description', 'LIKE', '%' . $search . '%');
    }

    public function getArticlesByUserFavorites($articles)
    {
        $userFavorite = UserFavorite::where('user_id', auth()->guard('api')->user()->id)->first();

        if(isset($userFavorite->categories) && $userFavorite->categories != "[]" && $userFavorite->categories != "null")
            $articles = $this->getArticlesByCategories($articles, json_decode($userFavorite->categories, true));

        if(isset($userFavorite->sources) && $userFavorite->sources != "[]" && $userFavorite->sources != "null")
            $articles = $this->getArticlesBySources($articles, json_decode($userFavorite->sources, true));

        if(isset($userFavorite->authors) && $userFavorite->authors != "[]" && $userFavorite->authors != "null")
            $articles = $this->getArticlesByAuthors($articles, json_decode($userFavorite->authors, true));
        
        return $articles;
    }
}
