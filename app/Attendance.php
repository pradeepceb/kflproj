<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table    = 'tms_attendances';
    protected $fillable = ['emp_no','card_no','dept_no','location','punching_date', 'punching_log'];
}
