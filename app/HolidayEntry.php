<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class HolidayEntry extends Model
{
    protected $table    = 'holiday_entry_tms';
    protected $fillable = ['date','category','type','description'];
}
