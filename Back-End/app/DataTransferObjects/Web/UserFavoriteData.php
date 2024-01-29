<?php

namespace App\DataTransferObjects\Web;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

final class UserFavoriteData
{
    public function __construct(
        public readonly ?array  $categoryName,
        public readonly ?array  $sourceName,
        public readonly ?array  $authorName
    )
    {
    }

    public static function from($data): self
    {
        return new self(
            Arr::get($data, 'categoryName'),
            Arr::get($data, 'sourceName'),
            Arr::get($data, 'authorName')
        );
    }
}
