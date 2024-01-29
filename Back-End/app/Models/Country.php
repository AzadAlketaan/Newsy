<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'code', 'created_at', 'updated_at'
    ];
    
    public static function getFillables()
    {
        return (new Country())->fillable;
    }

    public function Sources(): HasMany
    {
        return $this->hasMany(Source::class);
    }
}
