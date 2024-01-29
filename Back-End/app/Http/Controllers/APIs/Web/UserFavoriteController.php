<?php

namespace App\Http\Controllers\APIs\Web;

use App\Http\Controllers\APIs\Web\ApiController;
use App\DataTransferObjects\Web\UserFavoriteData;
use App\Http\Resources\Web\UserFavoriteResource;
use App\Repositories\UserFavoriteRepository;
use App\Http\Requests\Web\UserFavoriteRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Factory;

class UserFavoriteController extends ApiController
{
    public function __construct (
        private readonly UserFavoriteRepository $userFavoriteRepository,
        private readonly Factory            $validator,
    )
    {
    }

    public function index(): JsonResponse
    {
        return $this->successResponse(UserFavoriteResource::collection($this->userFavoriteRepository->getUserFavorites()), __("Fetched successfully"));
    }

    public function store(UserFavoriteRequest $request): JsonResponse
    {
        $data = $request->validated();
        
        $userFavoriteData = UserFavoriteData::from($data);
        $userFavorites = $this->userFavoriteRepository->storeUserFavorite($userFavoriteData);

        return $this->successResponse(new UserFavoriteResource($userFavorites), __("Fetched successfully"));
    }
}

?>
