<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class UserFavorite extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id', 'user_id', 'categories', 'sources', 'authors', 'created_at', 'updated_at'
    ];

    public static function getFillables()
    {
        return (new UserFavorite())->fillable;
    }

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }   

}
