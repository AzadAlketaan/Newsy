<?php

namespace App\Http\Controllers\APIs\Web;

use Illuminate\Contracts\Auth\Factory as AuthFactory;
use App\Http\Controllers\APIs\Web\ApiController;
use App\Http\Resources\Web\ArticleResource;
use App\Repositories\ArticleRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArticleController extends ApiController
{
    public function __construct (
        private readonly ArticleRepository $articleRepository,
        private readonly AuthFactory          $auth
    )
    {
    }

    public function index(Request $request): JsonResponse
    {
        $articles = $this->articleRepository->getArticlesQuery();

        if(isset($request->source_id)) $articles = $this->articleRepository->getArticlesBySource($articles, $request->source_id);

        if(isset($request->category_id)) $articles = $this->articleRepository->getArticlesByCategory($articles, $request->category_id);

        if(isset($request->language_id)) $articles = $this->articleRepository->getArticlesByLanguage($articles, $request->language_id);
        
        if(isset($request->country_id)) $articles = $this->articleRepository->getArticlesByCountry($articles, $request->country_id);
        
        if(isset($request->author_id)) $articles = $this->articleRepository->getArticlesByAuthor($articles, $request->author_id);

        if(isset($request->fromDate) || isset($request->toDate)) $articles = $this->articleRepository->getArticlesByPublishedDate($articles, $request->fromDate, $request->toDate);

        if(isset($request->title)) $articles = $this->articleRepository->getArticlesByTitle($articles, $request->title);

        if(isset($request->search_text)) $articles = $this->articleRepository->getArticlesByTitleOrDesc($articles, $request->search_text);
        
        $articles = $articles->paginate($request->limit);
        
        return $this->successResponse(['articles' => ArticleResource::collection($articles), 'lastPage' => $articles->lastPage()], __("Fetched successfully"));
    }

    public function newsFeed(Request $request): JsonResponse
    {
        $articles = $this->articleRepository->getNewsFeedArticlesQuery();

        if($this->auth->guard('api')->check())
        {
            $articles->where(function ($q) {
                $q = $this->articleRepository->getArticlesByUserFavorites($q);
           });
        }
        
        $articles = $articles->paginate($request->limit);

        return $this->successResponse(['articles' => ArticleResource::collection($articles), 'lastPage' => $articles->lastPage()], __("Fetched successfully"));
    }
}

?>
