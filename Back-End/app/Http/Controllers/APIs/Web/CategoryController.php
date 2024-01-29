<?php

namespace App\Http\Controllers\APIs\Web;

use App\Http\Controllers\APIs\Web\ApiController;
use App\Http\Resources\Web\CategoryResource;
use App\Repositories\CategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends ApiController
{
    public function __construct (
        private readonly CategoryRepository $categoryRepository
    )
    {
    }

    public function index(): JsonResponse
    {
        return $this->successResponse(CategoryResource::collection($this->categoryRepository->getCategories()), __("Fetched successfully"));
    }
}

?>
