<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\UserFavorite;

class UserFavoriteRequest extends FormRequest
{
    public function __construct()
    {
        parent::__construct();
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'categoryName' => ['nullable', 'array'],
            'sourceName' => ['nullable', 'array'],
            'authorName' => ['nullable', 'array'],
        ];
    }
}
