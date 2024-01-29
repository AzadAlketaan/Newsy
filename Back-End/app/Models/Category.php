<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'name', 'external_id', 'created_at', 'updated_at'
    ];

    public static function getFillables()
    {
        return (new Category())->fillable;
    }

    public function Sources(): HasMany
    {
        return $this->hasMany(Source::class);
    }

    public function Articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public static function getCategories(Array $names): Collection
    {
        return Category::whereIn('name', $names)->get();
    }
}
