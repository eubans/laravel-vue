<?php

namespace App\Models;

use DB;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_role_id',
        'user_type_id',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getUserDetails($id)
    {
        return DB::table('users')
            ->select('users.*', 'user_types.code as user_type_code')
            ->leftJoin('user_types', 'user_types.id', '=', 'users.user_type_id')
            ->where('users.id', $id)
            ->first();
    }

    /*return  */

    public static function getAllByUserType($code)
    {
        return DB::table('users')
            ->select('users.*', 'user_types.code as user_type_code')
            ->leftJoin('user_types', 'user_types.id', '=', 'users.user_type_id')
            ->where('user_types.code', $code)
            ->get();
    }

    public static function updateUser($id, $fields)
    {
        $update = array();
        foreach ($fields as $i => $field) {
            $update[$i] = $field;
        }

        return DB::table('users')
            ->where('id', $id)
            ->update($update);
    }

    public static function getUserbyEmail($email)
    {
        return DB::table('users')
            ->where('email', $email)
            ->first();
    }
}
