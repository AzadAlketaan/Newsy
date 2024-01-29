<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Web\SourceResource;
use App\Http\Resources\Web\AuthorResource;

class ArticleResource extends JsonResource
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
            'source' => isset($this["Source"]) ? new SourceResource($this["Source"]) : null,
            'author' => isset($this["Author"]) ? new AuthorResource($this["Author"]) : null,
            'url' => $this["url"],
            'title' => $this['title'],
            'description' => $this['description'],
            'content' => $this['content'],
            'image' => $this['image'],
            'published_at' => $this['published_at'],
            'is_top' => $this['is_top'],
            'createdAt' => $this['created_at']
        ];
    }
}