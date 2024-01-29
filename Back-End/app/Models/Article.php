<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'source_id', 'url', 'author_id', 'title', 'description',
        'content', 'image', 'published_at', 'is_top', 'created_at', 'updated_at'
    ];

    public static function getFillables()
    {
        return (new Article())->fillable;
    }

    public function Author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
    
    public function Source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }
}
