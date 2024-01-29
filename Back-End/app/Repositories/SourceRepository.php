<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Source;
use Carbon\Carbon;

class SourceRepository
{
    public function getSources(): Collection
    {
        return Source::query()->get();
    }
}
