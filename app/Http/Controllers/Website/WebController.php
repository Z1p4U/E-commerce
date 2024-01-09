<?php

namespace App\Http\Controllers\Website;

use App\Traits\JsonResponder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class WebController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, JsonResponder;
}
