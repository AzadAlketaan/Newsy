<?php

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use App\Models\ErrorLogs;
use App\Models\User;
use App\Models\Country;
use Carbon\Carbon;

/**
 * Create slug from string.
 *
 * @param  $title
 * @param  $slug this param used only if we let user enter slug in the form
 * @param  $model_name
 * @param  $object_id this param used in update model
 * @return $slug
 */

function getUserImg($img)
{
    $domain = $_SERVER['HTTP_HOST'];
    if (!empty($img)) return $domain . $img;  // get img by database

    return null;
}

function getUserIpAddress()
{
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"]))
        return $_SERVER['HTTP_CF_CONNECTING_IP'];
    return null;
}
