<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Shift extends Model
{
  protected $table = 'tms_shifts';
  protected $fillable=['id','Scode','InTime','outtime','Wrkhrs','HdStart','HdEnd','RstOut','Rstin','Rsthrs']; 
}
