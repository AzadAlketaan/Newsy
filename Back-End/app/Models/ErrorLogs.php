<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErrorLogs extends Model
{
    use HasFactory;

    protected $table = 'error_logs';
    protected $guarded = [];
    protected $casts = [
        'message' => 'array',
        'context' => 'array',
    ];   

    static function addToLog($subject, $message, $context = [])
    {
        if (auth()->check()) $user = User::where('id', '=', auth()->user()->id)->first();

        $basic_info = [
            'ip' => getUserIpAddress(),
            'agent' => request()->header('user-agent'),
            'user_id' => auth()->check() ? auth()->user()->id : 0,
            'user_email' => $user->email ?? null,
        ];

        foreach ($context as $key => $value)
        {
            $context[$key] = json_encode($value);
        }

        $log['subject'] = ucfirst($subject);
        $log['message'] = $message;
        $log['context'] = array_merge($basic_info, $context);

        $log = static::create($log);

        return $log;
    }
}
