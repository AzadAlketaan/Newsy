<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Web\UserResource;
use App\Http\Resources\Web\CategoryResource;
use App\Http\Resources\Web\SourceResource;
use App\Http\Resources\Web\AuthorResource;
use App\Models\UserFavorite;
use App\Models\Category;
use App\Models\Source;
use App\Models\Author;

class UserFavoriteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this["id"],
            'user' => isset($this["User"]) ? new UserResource($this["User"]) : null,
            'type' => $this["type"],
            'categories' => ($this["categories"] != '[]' && isset($this["categories"])) 
                        ? json_decode($this["categories"], true)
                        : null,
            'sources' => ($this["sources"] != '[]' && isset($this["sources"])) 
                        ? json_decode($this["sources"], true)
                        : null,
            'authors' => ($this["authors"] != '[]' && isset($this["authors"])) 
                        ? json_decode($this["authors"], true)
                        : null
        ];
    }
}