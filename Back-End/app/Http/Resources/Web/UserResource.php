<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class UserResource extends JsonResource
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
            'username' => $this["username"],
            'email' => $this["email"],
            'last_name' => $this["last_name"],
            'user_image' => getUserImg($this["user_image"]),
            'is_active' => $this['is_active'],
            'created_at' => $this['created_at']
        ];
    } 
}
