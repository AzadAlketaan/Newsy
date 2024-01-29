<?php

namespace App\Traits;

use App\Models\ErrorLogs;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

trait LoginAttemptsThrottle
{
    use ThrottlesLogins, ApiResponse;

    public function username()
    {
        return 'email';
    }

    protected $maxAttempts = 10;

    protected $decayMinutes = 60 * 24 * 3;  // period 72 hours

    protected function sendLockoutResponse(Request $request)
    {
        return $this->errorResponse(Response::HTTP_TOO_MANY_REQUESTS, __("Too many login attempts. Please try again"));
    }

    protected function incrementLoginAttempt(Request $request)
    {
        $this->incrementLoginAttempts($request);
        $this->saveLogAttempt($request);
    }

    protected function saveLogAttempt(Request $request)
    {
        ErrorLogs::addToLog('Too many login attempt', 'Too many login attempts. Please try again',
            ['email' => $request['email'], 'password' => $request['password'], 'ip' => getUserIpAddress(), 'action_date' => Carbon::now()->format('Y-m-d H:i:s'),
                'user_agent' => request()->header('user-agent')]
        );
    }
}
