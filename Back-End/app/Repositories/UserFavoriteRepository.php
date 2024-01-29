<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\DataTransferObjects\Web\UserFavoriteData;
use App\Models\UserFavorite;
use Carbon\Carbon;

class UserFavoriteRepository
{
    public function getUserFavorites(): Collection
    {
        return UserFavorite::query()->orderByDesc('created_at')->get();
    }

    public function storeUserFavorite(UserFavoriteData $userFavoriteData): UserFavorite
    {
        return UserFavorite::updateOrCreate(
            [
                'user_id' => auth()->guard('api')->user()->id,
            ],
            [
                'categories' => json_encode($userFavoriteData->categoryName),
                'sources' => json_encode($userFavoriteData->sourceName),
                'authors' => json_encode($userFavoriteData->authorName),
            ],
        );
    }
    
}
