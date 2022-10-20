<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SendgridController;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\NotificationController;

use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use App\Models\UserType;

class LibraryController extends Controller
{
    public function index()
    {
        return response()->json([], 403);
    }
}
