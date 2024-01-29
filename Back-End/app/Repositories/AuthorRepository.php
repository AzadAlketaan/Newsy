<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Author;
use Carbon\Carbon;

class AuthorRepository
{
    public function getAuthors(): Collection
    {
        return Author::query()->get();
    }
}
