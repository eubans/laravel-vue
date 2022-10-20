<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Module extends Model
{
    use HasFactory;

    public static function getUrl($user_type_id)
    {
        return DB::table('modules')
            ->select('modules.url')
            ->where('user_type_id', $user_type_id)
            ->get();
    }
}


