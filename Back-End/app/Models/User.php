<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username', 'first_name', 'last_name', 'email', 'password', 'user_image', 'is_active', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [ 'password', 'remember_token'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function getFillables()
    {
        return (new User())->fillable;
    }

    public function UserFavorites(): HasMany
    {
        return $this->hasMany(UserFavorite::class);
    }

    public static function getByEmail($email = "")
    {
        return User::where('email', '=', $email)->first();
    }

    public static function checkActiveUserById($user_id)
    {
        $user = User::where('id', '=', $user_id)->first();
        if (!$user) return false;

        return $user->is_active ? true : false;
    }
}
