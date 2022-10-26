<?php

namespace App\Models;

use App\Events\NotificationCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class Notification extends Model
{
    use HasFactory;

    // protected $guarded = [];

    // protected $dispatchesEvents = [
    //     'created' => NotificationCreated::class,
    // ];

    public static function getNotificationUserCount($userId)
    {
        return DB::table('notifications')
                ->where('send_to_user_id', $userId)
                ->where('status', 'unread')
                ->count();
    }

    public static function getNotificationUser($userId, $offset, $limit)
    {
        return DB::table('notifications')
                ->where('send_to_user_id', $userId)
                ->orderBy('id', 'DESC')
                ->offset($offset)
                ->limit($limit)
                ->get();
    }
}
