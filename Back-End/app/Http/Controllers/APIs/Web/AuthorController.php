<?php

namespace App\Http\Controllers\APIs\Web;

use App\Http\Controllers\APIs\Web\ApiController;
use App\Http\Resources\Web\AuthorResource;
use App\Repositories\AuthorRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorController extends ApiController
{
    public function __construct (
        private readonly AuthorRepository $authorRepository
    )
    {
    }

    public function index(): JsonResponse
    {
        return $this->successResponse(AuthorResource::collection($this->authorRepository->getAuthors()), __("Fetched successfully"));
    }
}

?>
