<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Notification;
use App\Events\NotificationCreated;

class NotificationController extends Controller
{
    public function index()
    {
        return response()->json([], 403);
    }
    
    public function getNotificationsByUser(Request $request)
    {
        $offset = $request->offset;
        $limit = $request->limit;

        $count = Notification::getNotificationUserCount(auth()->id());
        $result = Notification::getNotificationUser(auth()->id(), $offset, $limit);

        return response()->json(array(
            'result' => $result,
            'count' => $count,
        ));
    }
    
    public function setNotificationAsRead(Request $request)
    {
        $id = $request->id;
        $result = "failed";
        
        $notification = Notification::find($id);

        if($notification){
            $notification->status       = 'read';
            $notification->updated_by   = auth()->id();
            $notification->updated_at   = Carbon::now()->toDateTimeString();

            DB::transaction(function () use ($notification, &$result) { // Automatically rollback transaction if there's a fault
                if($notification->save()){
                    $result = "success";
                }
            }); // End transaction
        }

        return $result;
    }

    public static function createNotification($title, $message, $link, $variant, $user_id)
    {
        $result = "failed";

        $notification = new Notification;
        $notification->title            = $title;
        $notification->message          = $message;
        $notification->link             = $link;
        $notification->text_color       = $variant;
        $notification->send_to_user_id  = $user_id;
        $notification->created_by       = auth()->id();
        $notification->created_at       = Carbon::now()->toDateTimeString();

        DB::transaction(function () use ($notification, &$result) { // Automatically rollback transaction if there's a fault
            if($notification->save()){
                $result = "success";
            }
        }); // End transaction

        return $result;
    }
}
