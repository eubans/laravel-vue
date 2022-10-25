<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;

    public static function getAll()
    {
        return UserType::get();
    }

    public static function getById($id)
    {
        return UserType::where('id', $id)
            ->first();
    }
    // Get url
    /* public static function getUrl($url)
    {
        return DB::table('users')
            ->select('users.*', 'user_types.code as user_type_code')
            ->leftJoin('user_types', 'user_types.id', '=', 'users.user_type_id')
            ->where('users.id', $id)
            ->first();

    }


    */

    /* public static function getisAccessible*/


    public static function saveUser($fields)
    {
        return UserType::insertGetId($fields);
    }
}
