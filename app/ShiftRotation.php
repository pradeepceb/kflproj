<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class ShiftRotation extends Model
{
  protected $table = 'tms_shift_rotation';
  protected $fillable=['id','code','shift_pattern','monthly','skip_pattern']; 
}
