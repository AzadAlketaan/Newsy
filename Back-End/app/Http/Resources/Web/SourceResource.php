<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Web\CategoryResource;
use App\Http\Resources\Web\LanguageResource;
use App\Http\Resources\Web\CountryResource;

class SourceResource extends JsonResource
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
            'external_id' => $this["external_id"],
            'name' => $this["name"],
            'description' => $this["description"],
            'url' => $this["url"],
            'category' => isset($this["Category"]) ? new CategoryResource($this["Category"]) : null,
            'language' => isset($this["Language"]) ? new LanguageResource($this["Language"]) : null,
            'country' => isset($this["Country"]) ? new CountryResource($this["Country"]) : null
        ];
    }
}
