<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    public static function getAll()
    {
        return UserRole::get();
    }

    public static function getById($id)
    {
        return UserRole::where('id', $id)
            ->first();
    }
    public static function saveUser($fields)
    {
        return UserRole::insertGetId($fields);
    }
}
