<?php

namespace App\Http\Controllers\APIs\Web;

use App\Http\Controllers\APIs\Web\ApiController;
use App\Http\Resources\Web\SourceResource;
use App\Repositories\SourceRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SourceController extends ApiController
{
    public function __construct (
        private readonly SourceRepository $sourceRepository
    )
    {
    }

    public function index(): JsonResponse
    {
        return $this->successResponse(SourceResource::collection($this->sourceRepository->getSources()), __("Fetched successfully"));
    }
}

?>
