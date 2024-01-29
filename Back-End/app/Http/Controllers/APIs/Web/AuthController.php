<?php

namespace App\Http\Controllers\APIs\Web;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Azimo\Apple\Auth\Exception\ValidationFailedException;
use App\Traits\LoginAttemptsThrottle;
use App\Http\Controllers\APIs\Web\ApiController;
use App\Http\Resources\Web\UserResource;
use App\Models\ErrorLogs;
use App\Models\User;
use App\Models\UserLogins;
use Carbon\Carbon;

/**
 * @group User management
 *
 * APIs for managing users
 */
class AuthController extends ApiController
{
    use LoginAttemptsThrottle;

    /**
     * Log In
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request))
        {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        $validator = $this->validateLogin();

        // Validate Request
        if ($validator->fails())
        {
            ErrorLogs::addToLog('user login', $validator->messages()->first(), ['email' => $request['email']]);
            return $this->errorResponse(Response::HTTP_CONFLICT, $validator->messages()->first());
        }

        // Validate Email With Specific Conditions
        if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL))
        {
            ErrorLogs::addToLog('user login', __('The email field is only can email or phone numbe'), ['email' => $request['email']]);
            return $this->errorResponse(Response::HTTP_CONFLICT, __('The email field is only can email'));
        }

        $user = User::getByEmail($request['email']);

        // Check If User Exist
        if (!isset($user))
        {
            ErrorLogs::addToLog('user login', __("Account is not exist"), ['email' => $request['email']]);
            return $this->errorResponse(Response::HTTP_CONFLICT, __("Account is not exist"));
        }

        // Check Account Of User If Active Or Not
        if (!$user->is_active)
        {
            ErrorLogs::addToLog('user login', __('Account not active'), ['email' => $request['email']]);
            return $this->errorResponse(Response::HTTP_CONFLICT, __('Account not active'));
        }

        if (!Auth::attempt(['email' => $request['email'], 'password' => $request->password]))
        {
            ErrorLogs::addToLog('user login', __("Password is invalid"), ['email' => $request['email']]);
            return $this->errorResponse(Response::HTTP_CONFLICT, __("Password is invalid"));
        }
        
        $accessToken = $user->createToken('authToken')->accessToken;

        UserLogins::insertLog($user->id, 'Login', 'Website', null, null);

        return $this->respondWithToken($accessToken, new UserResource($user) , null);
    }

    public function validateLogin()
    {
        return Validator::make(request()->all(), [
            'email' => 'required|max:255',
            'password' => 'required|min:8'
        ]);
    }

    public function signup(Request $request)
    {
        $validator = $this->validateSignup();

        if ($validator->fails())
        {
            ErrorLogs::addToLog('user signup', $validator->messages()->first(), $request->except(['password']));
            return $this->errorResponse(Response::HTTP_CONFLICT, $validator->messages()->first());
        }

        $userEmail = User::where('email', '=', $request['email'])->first();
        
        if ($userEmail)
        {
            if (isset($userEmail->id) && !User::checkActiveUserById($userEmail->id)){
                return $this->errorResponse(Response::HTTP_CONFLICT, 'Account not active');
            }
            return $this->errorResponse(Response::HTTP_CONFLICT,  __('Email is exists'));
        }

        DB::beginTransaction();
        $attr = $request->only(User::getFillables());
        $attr['password'] = bcrypt($request['password']);
        $user = new User($attr);
        // set user active
        $user["is_active"] = 1;
        $user->save();

        $user = User::getByEmail($request['email']);

        UserLogins::insertLog($user->id, 'Signup', 'Website', $request->headers->get('purchase-key'));

        DB::commit();

        $accessToken = $user->createToken('authToken')->accessToken;

        return $this->respondSingupWithToken($accessToken, $user);   
    }

    public function validateSignup()
    {
        return Validator::make(request()->all(), [
            'username' => 'required|string',
            'email' => 'required|string|regex:/(.+)@(.+)\.(.+)/i',
            'password' => 'required|min:8',
        ]);
    }

    protected function respondWithToken($token, $data = null, $is_signup = null, $message = null)
    {
        return $this->successResponse([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'data' => $data,
            'is_signup' => $is_signup
        ], $message ?? __("Login Successfully"));
    }

    protected function respondSingupWithToken($token, $user = null)
    {
        return $this->successResponse([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], __("Signup Successfully"));
    }    

    /**
     * Log Out
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        $user = auth()->guard('api')->user();

        if (!isset($user)) return $this->errorResponse(Response::HTTP_CONFLICT, __("No user logged in"));

        auth()->guard('api')->user()->tokens->each(function ($token, $key) {$token->delete();});
        
        $latestUserLogin = UserLogins::where("user_id", $user->id)->where("action", "Login")->orwhere("action", "Signup")->orderByDesc('created_at')->first();

        UserLogins::insertLog(auth()->guard('api')->user()->id, 'Logout', $latestUserLogin->type, null, $request->headers->get('purchase-key'));

        return $this->successResponse([], __("Successfully logged out"));
    }

}