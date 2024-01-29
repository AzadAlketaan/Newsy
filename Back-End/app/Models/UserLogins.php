<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLogins extends Model
{
    use HasFactory;

    protected $casts = [
        'context' => 'array'
    ];

    protected $fillable = ['user_id', 'action', 'type', 'website', 'context', 'login_at', 'created_at', 'updated_at'];

    public static function getFillables()
    {
        return (new UserLogins())->fillable;
    }

    public static function insertLog($user_id, $action, $type, $website = null, $provider = null)
    {
        $userlogins = new UserLogins();
        $userlogins['user_id'] = $user_id;
        $userlogins['action'] = $action;
        $userlogins['type'] = $type;
        $userlogins['website'] = 'Melenuim';

        if (isset($provider)) {

            $userlogins['context'] = [
                'ip' => request()->ip(),
                'agent' => request()->header('user-agent'),
                'provider' => $provider
            ];
        }
        else
        {
            $userlogins['context'] = [
                'ip' => request()->ip(),
                'agent' => request()->header('user-agent')
            ];
        }

        $userlogins->save();
        
        return $userlogins;
    }
}
