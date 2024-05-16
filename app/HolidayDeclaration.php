<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class HolidayDeclaration extends Model
{
    protected $table    = 'tms_holiday_declarations';
    protected $fillable = ['declared_on','compensatory_on','declared_as'];
}
