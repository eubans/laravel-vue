<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class module_accesses extends Model
{
    use HasFactory;

    public static function getAll()
    {
        return DB::table('module_accesses AS a')
        ->leftjoin('sub_modules AS b', 'b.id', '=', 'a.sub_module_id')
        ->select('a.id',
            'a.sub_module_id', 'a.usertype_id','b.url', 'b.sub_module_name')
        ->get();
    }

    public static function getURL($usertype_id)
    {
        return DB::table('module_accesses AS a')
        ->join('sub_modules AS b', 'b.id', '=', 'a.sub_module_id')
        ->join('modules AS c', 'c.id', '=', 'b.modules_id')
        ->select('a.id','a.sub_module_id', 'a.usertype_id','b.url', 'b.sub_module_name', 'c.name')
        ->where('a.usertype_id', $usertype_id)
        ->get();
    }

}
// , 'c.id','=' ,'b.modules_id'
