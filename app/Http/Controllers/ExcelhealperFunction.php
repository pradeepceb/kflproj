<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Board;
use App\Workplace;
use App\Department_master;
use App\Designation;
use App\Pay_grade_master;
use App\Bank;
use App\Employee_Master;
use App\emp_official;
use App\Category;
use App\Employee_type;
use App\Nominee;
use App\Dependent;
use App\Qualification;
use App\Experience;
use App\Promotion;
use App\Transfer;
use App\Probation;
use App\Contract;
use App\Antecedent;
use App\Revocation;
use App\Intiation;
use App\Achievement;
use App\Appriciation;
use App\Reward;
use App\Qual_lvl;
use App\Remark;
use Response;
use DB;
use Carbon\Carbon;
use Cache;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Excel;
use PDF;
use App\Exports\EmployeelistCategoryExport; 
class ExcelhealperFunction extends Controller
{

  public function GetType($var)
  {
    if($var==""){
      return "";
    } else{
      $data = DB::table('employee_type')->where('emp_type_code','=',$var)->first();
      return $data->employee_type_name;
    }
  }
  public function GetCategory($var)
  {
    if($var==""){
      return "";
    } else{
      $data = DB::table('category')->where('category_code','=',$var)->first();
      return $data->category_name;
    }
  }
  public function Getdesignation($var)
  {
    if($var==""){
      return "";
    } else{
      $data = DB::table('desg_mst')->where(['desg_code'=>$var])->first();
      return $data->desg_name;
    }
  }
  public function GetDepartment($var)
  {
    if($var==""){
      return "";
    } else{
      $data = DB::table('dept_master')->where(['dept_no'=>$var])->first();
      return $data->dept_name;
    }
  }
  public function GetModifydate($var){
    if($var==""){
      return "";
    } else{
      return date('d/m/Y', strtotime($var));
    }
  }

  public function GetActiveType($var)
  {
    if($var==""){
      return "";
    } else{
      if($var=="I"){
        return "Inactive";
      } else if($var=="A"){
        return "Active";
      } else{
        return "";
      }
    }
  }

  public function GetPaygrade($var)
  {
    if($var==""){
      return "";
    } else{
      if(DB::table('pay_grade_mst')->where(['pay_grade_code'=>$var])->count() > 0){
        $data = DB::table('pay_grade_mst')->where(['pay_grade_code'=>$var])->first();
        return $data->pay_grade_code;
      } else {
        return "";
      }
    }
  }
  
  public function GetContractEnddate($emp_no)
  {
    $check = DB::table('emp_contract_dtl')->where(['emp_no'=>$emp_no])->count();
    if($check > 0){
        $data = DB::table('emp_contract_dtl')->where(['emp_no'=>$emp_no])->orderBy('id','DESC')->first();
        if($data->cont_end_date==""){
          return "";
        } else {
          return date('d/m/Y', strtotime($data->cont_end_date));
        }
    } else {
        return "";
    }
  }

public function GetModifydateDaywise($var)
{
  if($var==""){
    return "";
  } else{
    return date('d-M', strtotime($var));
  }
}

public function GetContractDate($num,$type){
    $check = DB::table('emp_contract_dtl')->where(['emp_no'=>$num])->count();
    if($check > 0){
        $data = DB::table('emp_contract_dtl')->where(['emp_no'=>$num])->get();
        $store = array();
        $i=1;
        if($type=="START"){
          foreach($data as $key => $val){
            if(!$val->cont_start_date==""){
              $store[]=$i." - ".date('d/m/Y', strtotime($val->cont_start_date)).", ";
            } else {
              $store[]=$i." - ";
            }
            $i++;
          }
          $send_store = implode(" ",$store);
        } else {
          foreach($data as $key => $val){
            if(!$val->cont_end_date==""){
              $store[]=$i." - ".date('d/m/Y', strtotime($val->cont_end_date)).", ";
            } else {
              $store[]=$i." - ";
            }
            $i++;
          }
          $send_store = implode(" ",$store);
        }
        return $send_store;
    } else {
        return "";
    }
}

public function GetDepend($num,$type){
  $check = DB::table('emp_dependent_dtl')->where(['emp_no'=>$num])->count();
  if($check > 0){
      $data = DB::table('emp_dependent_dtl')->where(['emp_no'=>$num])->get();
      $store = array();
      $i=1;
      if($type=="NAME"){
        foreach($data as $key => $val){
          if(!$val->depd_name==""){
            $store[]=$i." - ".$val->depd_name.", ";
          } else {
            $store[]=$i." - ";
          }
          $i++;
        }
        $send_store = implode(" ",$store);
      } else {
        foreach($data as $key => $val){
          if(!$val->depd_dob==""){
            $store[]=$i." - ".date('d/m/Y', strtotime($val->depd_dob)).", ";
          } else{
            $store[]=$i." - ";
          }
          $i++;
        }
        $send_store = implode(" ",$store);
      }
      return $send_store;
  } else {
      return "";
  }
}


}