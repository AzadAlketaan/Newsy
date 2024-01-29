<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'name', 'created_at', 'updated_at'
    ];
    
    public static function getFillables()
    {
        return (new Author())->fillable;
    }

    public function Articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public static function getAuthors(Array $names): Collection
    {
        return Author::whereIn('name', $names)->get();
    }

}
