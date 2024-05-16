<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Designation extends Model
{
    //
     protected $table = 'desg_mst_live';
    protected $fillable = ['DESG_CODE','DESG_NAME'];
  public static function Designation_Master_view()
    {
        $Designation_view = DB::table('desg_mst_live')->get();
        return $Designation_view;
    }
}
