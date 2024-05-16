<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Department_master extends Model
{
    //
    protected $table = 'dept_mst_live';
    protected $fillable = ['DEPT_NO','DEPT_NAME'];
       

    public static function Department_view()
    {
        $dept = DB::table('dept_mst_live')->get();
        return $dept;
    }
}
