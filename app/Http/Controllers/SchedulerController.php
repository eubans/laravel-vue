<?php

namespace App\Http\Controllers;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\NotificationController;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Application;
use App\Models\ApplicationBatchApproval;
use App\Models\ApplicationBatchApprovalChild;
use App\Models\DepedVerifiers;
use App\Models\User;

class SchedulerController extends Controller
{
    public function index()
    {
        return response()->json([], 403);
    }
}
