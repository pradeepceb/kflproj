<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class LeaveCode extends Model
{
    protected $table = 'leave_codes_tms';
    protected $fillable = ['leave_code','type_of_leave','paid','balanace_maintained','encashment_available','running_working','balance_carry_forward'];
}
