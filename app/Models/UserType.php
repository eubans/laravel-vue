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

    public static function saveUser($fields)
    {
        return UserType::insertGetId($fields);
    }
}
