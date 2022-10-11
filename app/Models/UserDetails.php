<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class UserDetails extends Model
{
    use HasFactory;

    //Users Table Query
    public static function saveUser($fields)
    {
        return DB::table('users')
            ->insertGetId($fields);
    }

    //User Details Table Query
    public static function saveUserDetails($fields)
    {
        return DB::table('user_details')
            ->insertGetId($fields);
    }

    public static function getAll()
    {
        return DB::table('users AS a')
        ->leftjoin('user_details AS b', 'b.user_id', '=', 'a.id')
        ->leftjoin('user_types AS c', 'a.user_type_id', '=', 'c.id')
        ->select('a.id',
            'c.name AS user_type',
            'a.user_role_id',
            'a.email AS username',
            'a.name AS fullname',
            'b.firstname',
            'b.middlename',
            'b.lastname',
            'b.email',
            'b.mobile',
            'b.avatar_path',
            'a.status')
        ->orderBy('id', 'desc')
        ->get();
    }

    public static function getById($id)
    {
        return DB::table('users AS a')
        ->leftjoin('user_details AS b', 'b.user_id', '=', 'a.id')
        ->leftjoin('user_types AS c', 'a.user_type_id', '=', 'c.id')
        ->select('a.id',
            'b.id AS user_detail_id',
            'c.id AS user_type_id',
            'a.user_role_id',
            'c.name AS user_type',
            'a.email AS username',
            'a.name AS fullname',
            'b.firstname',
            'b.middlename',
            'b.lastname',
            'b.email',
            'b.mobile',
            'b.avatar_path',
            'a.status')
        ->where('a.id', $id)
        ->first();
    }

    public static function isEmailExisted($email)
    {
        return UserDetails::where('email', $email)
            ->first();
    }

    public static function isUsernameExisted($username)
    {
        return DB::table('users')->where('email', $username)
            ->first();
    }
}
