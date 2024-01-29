<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Category;
use Carbon\Carbon;

class CategoryRepository
{
    public function getCategories(): Collection
    {
        return Category::query()->get();
    }
}
