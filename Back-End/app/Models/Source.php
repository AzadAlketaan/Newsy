<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'external_id', 'name', 'description', 'url', 'category_id',
        'language_id', 'country_id', 'created_at', 'updated_at'
    ];

    public static function getFillables()
    {
        return (new Source())->fillable;
    }
    
    public function Language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function Country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function Category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    
    public function Articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public static function getSources(Array $names): Collection
    {
        return Source::whereIn('name', $names)->get();
    }

}
