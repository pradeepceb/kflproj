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
use App\Attendance;
use App\Emp_mst_live;
use App\MonthlyShiftGenerate;
use App\Shift;
use Response;
use DB;
use Carbon\Carbon;
use Cache;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use DateTime;


class ReportsController extends Controller
{
  public function pager($items, $perPage = null, $page = null, $options = [])
  {
      $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
      $items = $items instanceof Collection ? $items : Collection::make($items);
      return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
  }
 
    public function index(Request $request)
    {
      $all_categories_data = DB::table('emp_mst')
      ->leftJoin('category','emp_mst.catg','=','category.category_code')
      ->select('emp_mst.catg')
      ->where('emp_mst.catg','!=',NULL)
      ->groupBy('emp_mst.catg')
      ->get();
      $employee_type = DB::table('emp_mst')
      ->select('emp_mst.emp_type')
      ->where('emp_mst.emp_type','!=',NULL)
      ->groupBy('emp_mst.emp_type')
      ->orderBy('emp_mst.type_store_by', 'ASC')
      ->get();
      $get_categories = array();
      foreach($all_categories_data as $key => $val){
        $get_categories[] = DB::table('category')->where('category_code','=',$val->catg)->first();
      } 
     
      if(count($_GET)==0){
        $category = NULL;
        $type = NULL;
      } else {
        if(isset($_GET['category'])){
          $category = $request->category ;
        } else {
          $category = "";
        }
        if(isset($_GET['type'])){
          $type = $request->type;
        } else {
          $type ="";
        }
      }
    if(isset($_GET['active_type'])){
        $active_type= $_GET['active_type'];
    } else {
        $active_type= "all";
    }
    if(isset($_GET['page'])){
      $page=$request->page;
    } else {
      $page= 1;
    } 
    $i = 0;

if($category=="" && $type=="" && $active_type=="all"){
  foreach ($get_categories as $val) {
    foreach($employee_type as $ty){
      $query = DB::table('emp_mst')
      ->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ')
      ->where('catg', "=", $val->category_code)
      ->where('emp_type', "=", $ty->emp_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
  }
  $data = $setquery->get();
} else if($category=="all_cat" && $type=="all_type" && $active_type=="all"){
  foreach ($get_categories as $val) {
    foreach($employee_type as $ty){
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ')->where('catg', "=", $val->category_code)->where('emp_type', "=", $ty->emp_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
  }
  $data = $setquery->get();
} else if($category!=="all_cat" && $type=="all_type" && $active_type=="all"){


    foreach($employee_type as $ty){
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ')->where('catg', "=", $category)->where('emp_type', "=", $ty->emp_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }

  $data = $setquery->get();
  

} else if($category=="all_cat" && $type!=="all_type" && $active_type=="all"){

  foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ')->where('catg', "=", $val->category_code)->where('emp_type', "=", $type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
  }
  $data = $setquery->get();
  
} else if($category=="all_cat" && $type=="all_type" && $active_type!=="all"){
  
  foreach ($get_categories as $val) {
    foreach($employee_type as $ty){
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ')->where('catg', "=", $val->category_code)->where('emp_type', "=", $ty->emp_type)->where('active_type','=',$active_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
  }
  $data = $setquery->get();
  
} else if($category=="all_cat" && $type!=="all_type" && $active_type!=="all"){

  foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ')->where('catg', "=", $val->category_code)->where('emp_type', "=", $type)->where('active_type','=',$active_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
  }
  $data = $setquery->get();
  
} else if($category!=="all_cat" && $type!=="all_type" && $active_type!=="all"){
  $list = DB::table('emp_mst')
  ->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ')
  ->where('emp_mst.emp_type','=',$type)
  ->where('emp_mst.catg','=',$category)
  ->where('emp_mst.active_type','=',$active_type)
  ->get();
  $data =  $list;
}else if($category!=="all_cat" && $type!=="all_type" && $active_type=="all"){
  $list = DB::table('emp_mst')
  ->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ')
  ->where('emp_mst.emp_type','=',$type)
  ->where('emp_mst.catg','=',$category)
  ->get(); 
  $data =  $list;
} else if($category!=="all_cat" && $type=="all_type" && $active_type!=="all"){

    foreach($employee_type as $ty){
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ')->where('catg', "=", $category)->where('emp_type', "=", $ty->emp_type)->where('active_type','=',$active_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }

  $data = $setquery->get();

} else { 
  foreach ($get_categories as $val) {
    foreach($employee_type as $ty){
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ')->where('catg', "=", $val->category_code)->where('emp_type', "=", $ty->emp_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
  }
  $data = $setquery->get();
} 
$employee_list=ReportsController::pager($data,30,$page); 
      $send = [
        'categories'=>$get_categories,
        'employee_type'=>$employee_type,
        'employee_list'=>$employee_list
      ];
    
      return view('Frontend.employee-list-category-wise',$send);
    } 
    
    











public function emp_department_report(Request $request)
{ 
  $all_categories_data = DB::table('emp_mst')
      ->leftJoin('category','emp_mst.catg','=','category.category_code')
      ->select('emp_mst.catg')
      ->where('emp_mst.catg','!=',NULL)
      ->groupBy('emp_mst.catg')
      ->get();
      $employee_type = DB::table('emp_mst')
      ->select('emp_mst.emp_type')
      ->where('emp_mst.emp_type','!=',NULL)
      ->groupBy('emp_mst.emp_type')
      ->orderBy('emp_mst.type_store_by', 'ASC')
      ->get();
      $get_categories = array();
      foreach($all_categories_data as $key => $val){
        $get_categories[] = DB::table('category')->where('category_code','=',$val->catg)->first();
      }
      $departmment = DB::table('emp_mst')->select('emp_mst.dept_no')
      ->where('emp_mst.dept_no','!=',NULL)
      ->groupBy('emp_mst.dept_no')
      ->get();
      $get_departmment = array();
      foreach($departmment as $key1 => $val1){
        $get_departmment[] = DB::table('dept_master')->where('dept_no','=',$val1->dept_no)->first();
      }
      
    if(count($_GET)==0){
        $category= "";
        $type= "";
        $department= "";
    } else {
        if(isset($_GET['department'])){
            $department= $request->department;
        } else {
            $department= "";
        }
        if(isset($_GET['category'])){
          $category= $request->category;
        } else {
            $category= "";
        }
        if(isset($_GET['type'])){
            $type= $request->type;
        } else {
            $type= "";
        }
    }

  if(isset($_GET['active_type'])){
      $active_type= $_GET['active_type'];
  } else {
      $active_type= "all";
  }
  if(isset($_GET['page'])){
    $page=$request->page;
  } else {
    $page= 1;
  } 
  $i = 0;
if($department=="" && $category=="" && $type=="" && $active_type=="all"){
  foreach ($get_departmment as $val) {
    foreach($employee_type as $ty){
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ','dept_no')->where('dept_no', "=", $val->dept_no)->where('emp_type', "=", $ty->emp_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
  }
  $data = $setquery->get();
}else if($department=="All" && $category=="All" && $type=="All" && $active_type=="all"){
  foreach ($get_departmment as $val) {
    foreach($employee_type as $ty){
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ','dept_no')->where('dept_no', "=", $val->dept_no)->where('emp_type', "=", $ty->emp_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
  }
  $data = $setquery->get();
} else if($department!=="All" && $category=="All" && $type=="All" && $active_type=="all"){

    foreach($employee_type as $ty){
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ','dept_no')->where('dept_no', "=", $department)->where('emp_type', "=", $ty->emp_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
 
  $data = $setquery->get();
} else if($department=="All" && $category!=="All" && $type=="All" && $active_type=="all"){
  foreach ($get_departmment as $val) {
    foreach($employee_type as $ty){
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ','dept_no')->where('dept_no', "=", $val->dept_no)->where('emp_type', "=", $ty->emp_type)->where('catg', "=", $category);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
  }
  $data = $setquery->get();
} else if($department=="All" && $category=="All" && $type!=="All" && $active_type=="all"){
  foreach ($get_departmment as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ','dept_no')->where('dept_no', "=", $val->dept_no)->where('emp_type', "=", $type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
  }
  $data = $setquery->get();
} else if($department=="All" && $category=="All" && $type=="All" && $active_type!=="all"){
  foreach ($get_departmment as $val) {
    foreach($employee_type as $ty){
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ','dept_no')->where('dept_no', "=", $val->dept_no)->where('emp_type', "=", $ty->emp_type)->where('active_type','=',$active_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
  }
  $data = $setquery->get();
} else if($department=="All" && $category=="All" && $type!=="All" && $active_type!=="all"){
  foreach ($get_departmment as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ','dept_no')->where('dept_no', "=", $val->dept_no)->where('emp_type', "=", $type)->where('active_type','=',$active_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
  }
  $data = $setquery->get();
}else if($department=="All" && $category!=="All" && $type!=="All" && $active_type!=="all"){
  foreach ($get_departmment as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ','dept_no')->where('dept_no', "=", $val->dept_no)->where('emp_type', "=", $type)->where('catg','=',$category)->where('active_type','=',$active_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
  }
  $data = $setquery->get();
}else if($department!=="All" && $category!=="All" && $type!=="All" && $active_type!=="all"){
  $employee_list = DB::table('emp_mst')
  ->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ','dept_no')
  ->where('emp_mst.dept_no','=',$department)
  ->where('emp_mst.emp_type','=',$type)
  ->where('emp_mst.catg','=',$category)
  ->where('emp_mst.active_type','=',$active_type)
  ->get(); 
  $data = $employee_list;
}else if($department!=="All" && $category!=="All" && $type=="All" && $active_type=="all"){
    foreach($employee_type as $ty){
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ','dept_no')->where('dept_no', "=", $department)->where('emp_type', "=", $ty->emp_type)->where('catg','=',$category);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
  $data = $setquery->get();
}else if($department!=="All" && $category!=="All" && $type!=="All" && $active_type=="all"){
  $employee_list = DB::table('emp_mst')
  ->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ','dept_no')
  ->where('emp_mst.dept_no','=',$department)
  ->where('emp_mst.emp_type','=',$type)
  ->where('emp_mst.catg','=',$category)
  ->get(); 
  $data = $employee_list;
}else if($department!=="All" && $category=="All" && $type!=="All" && $active_type=="all"){

  $data = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ','dept_no')->where('dept_no', "=", $department)->where('emp_type', "=", $type)->get();

}else if($department=="All" && $category!=="All" && $type=="All" && $active_type!=="all"){
  foreach ($get_departmment as $val) {
    foreach($employee_type as $ty){
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ','dept_no')->where('dept_no', "=", $val->dept_no)->where('emp_type', "=", $ty->emp_type)->where('catg','=',$category)->where('active_type','=',$active_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
  }
  $data = $setquery->get();
}else if($department!=="All" && $category=="All" && $type!=="All" && $active_type!=="all"){
  $employee_list = DB::table('emp_mst')
  ->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ','dept_no')
  ->where('emp_mst.dept_no','=',$department)
  ->where('emp_mst.emp_type','=',$type)
  ->where('emp_mst.active_type','=',$active_type)
  ->get(); 
  $data = $employee_list;
}else if($department!=="All" && $category!=="All" && $type=="All" && $active_type!=="all"){
    foreach($employee_type as $ty){
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ','dept_no')->where('dept_no', "=", $department)->where('emp_type', "=", $ty->emp_type)->where('catg','=',$category)->where('emp_mst.active_type','=',$active_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
  $data = $setquery->get();
}else if($department=="All" && $category!=="All" && $type!=="All" && $active_type=="all"){
  foreach ($get_departmment as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ','dept_no')->where('dept_no', "=", $val->dept_no)->where('emp_type', "=", $type)->where('catg','=',$category);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
  }
  $data = $setquery->get();
}else if($department!=="All" && $category=="All" && $type=="All" && $active_type!=="all"){
    foreach($employee_type as $ty){
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ','dept_no')->where('dept_no', "=", $department)->where('emp_type', "=", $ty->emp_type)->where('emp_mst.active_type','=',$active_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
  $data = $setquery->get();
} else {
  foreach ($get_departmment as $val) {
    foreach($employee_type as $ty){
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ','dept_no')->where('dept_no', "=", $val->dept_no)->where('emp_type', "=", $ty->emp_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
  }
  $data = $setquery->get();
}
$employee_list=ReportsController::pager($data,30,$page); 
  $send = [
    'categories'=>$get_categories,
    'employee_type'=>$employee_type,
    'departmment'=>$get_departmment,
    'employee_list'=>$employee_list,
  ];
  return view('Frontend.employee-list-department-wise',$send);
}






    public function emp_pay_report(Request $request){
      $all_pay_grade = DB::table('emp_mst')
      ->select('emp_mst.PAY_GRADE_CODE')
      ->where('emp_mst.PAY_GRADE_CODE','!=',NULL)
      ->groupBy('emp_mst.PAY_GRADE_CODE')
      ->get();
      $paygrade = DB::table('emp_mst')->select('emp_mst.PAY_GRADE_CODE')->groupBy('emp_mst.PAY_GRADE_CODE')->orderBy('PAY_GRADE_CODE','ASC')->get();
      //->orderByRaw('CONVERT(PAY_GRADE_CODE, INT) ASC')
      $employee_type = DB::table('emp_mst')
      ->select('emp_mst.emp_type')
      ->where('emp_mst.emp_type','!=',NULL)
      ->groupBy('emp_mst.emp_type')
      ->orderBy('emp_mst.type_store_by', 'ASC')
      ->get();
      $get_pay_grade = array();
      foreach($all_pay_grade as $key => $vals){
        $check_pay_grade = DB::table('pay_grade_mst')->where('pay_grade_code','=',$vals->PAY_GRADE_CODE)->count();
        if($check_pay_grade!==0){
          $get_pay_grade[] = DB::table('pay_grade_mst')->where('pay_grade_code','=',$vals->PAY_GRADE_CODE)->first();
        }
      }
      $all_categories_data = DB::table('emp_mst')->select('emp_mst.catg')->where('emp_mst.catg','!=',NULL)->groupBy('emp_mst.catg')->get();
      $get_categories = array();
      foreach($all_categories_data as $key => $val){
        $get_categories[] = DB::table('category')->where('category_code','=',$val->catg)->first();
      }
//       echo "<pre>";
// print_r($employee_type); exit;


      if(count($_GET)==0){
        $grade = NULL;
        $type = NULL;
      } else {
        if(isset($_GET['grade'])){
          $grade = $request->grade ;
        } else {
          $grade = "";
        }
        if(isset($_GET['type'])){
          $type = $request->type;
        } else {
          $type = "";
        }
      }
    if(isset($_GET['active_type'])){
        $active_type= $request->active_type;
    } else {
        $active_type= "all";
    }
    if(isset($_GET['page'])){
      $page=$request->page;
    } else {
      $page= 1;
    } 
    $i = 0;
   
if($grade=="" && $type=="" && $active_type=="all"){
  foreach ($get_categories as $val) {
    foreach($employee_type as $type){
      foreach($paygrade as $pay){
          $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ','dept_no','PAY_GRADE_CODE')->where('catg', "=", $val->category_code)->where('emp_type', "=", $type->emp_type)->where('PAY_GRADE_CODE', "=", $pay->PAY_GRADE_CODE);
          if($i < 1){
              $setquery = $query;
          }else{
              $setquery->union($query);
          }
          $i++;
      }
    }
  }
  $data = $setquery->get();
} else if($grade=="all_grade" && $type=="all_type" && $active_type=="all"){
  foreach ($get_categories as $val) {
    foreach($employee_type as $type){
      foreach($paygrade as $pay){
        $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ','dept_no','PAY_GRADE_CODE')->where('catg', "=", $val->category_code)->where('emp_type', "=", $type->emp_type)->where('PAY_GRADE_CODE', "=", $pay->PAY_GRADE_CODE);
        if($i < 1){
            $setquery = $query;
        }else{
            $setquery->union($query);
        }
        $i++;
      }
    }
  }
  $data = $setquery->get();
} else if($grade!=="all_grade" && $type=="all_type" && $active_type=="all"){
  foreach ($get_categories as $val) {
    foreach($employee_type as $type){
      foreach($paygrade as $pay){
        $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ','dept_no','PAY_GRADE_CODE')->where('catg', "=", $val->category_code)->where('emp_type', "=", $type->emp_type)->where('PAY_GRADE_CODE', "=", $grade);
        if($i < 1){
            $setquery = $query;
        }else{
            $setquery->union($query);
        }
        $i++;
      }
    }
  }
  $data = $setquery->get();
} else if($grade=="all_grade" && $type!=="all_type" && $active_type=="all"){
  foreach ($get_categories as $val) {
    foreach($paygrade as $pay){
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ','dept_no','PAY_GRADE_CODE')->where('catg', "=", $val->category_code)->where('PAY_GRADE_CODE', "=", $pay->PAY_GRADE_CODE)->where('emp_type','=',$type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
  }
  $data = $setquery->get();
} else if($grade=="all_grade" && $type=="all_type" && $active_type!=="all"){
  foreach ($get_categories as $val) {
    foreach($employee_type as $type){
      foreach($paygrade as $pay){
        $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ','dept_no','PAY_GRADE_CODE')->where('catg', "=", $val->category_code)->where('emp_type', "=", $type->emp_type)->where('PAY_GRADE_CODE', "=", $pay->PAY_GRADE_CODE)->where('active_type','=',$active_type);
        if($i < 1){
            $setquery = $query;
        }else{
            $setquery->union($query);
        }
        $i++;
      }
    }
  }
  $data = $setquery->get();
} else if($grade=="all_grade" && $type!=="all_type" && $active_type!=="all"){
  foreach ($get_categories as $val) {
    foreach($paygrade as $pay){
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ','dept_no','PAY_GRADE_CODE')->where('catg', "=", $val->category_code)->where('PAY_GRADE_CODE', "=", $pay->PAY_GRADE_CODE)->where('emp_type', "=", $type)->where('active_type','=',$active_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
  }
  $data = $setquery->get();
} else if($grade!=="all_grade" && $type!=="all_type" && $active_type!=="all"){
  foreach ($get_categories as $val) {
    foreach($paygrade as $pay){
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ','dept_no','PAY_GRADE_CODE')->where('catg', "=", $val->category_code)->where('PAY_GRADE_CODE', "=", $grade)->where('emp_type', "=", $type)->where('active_type','=',$active_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
  }
  $data = $setquery->get();
} else if($grade!=="all_grade" && $type!=="all_type" && $active_type=="all"){
  foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ','dept_no','PAY_GRADE_CODE')->where('catg', "=", $val->category_code)->where('PAY_GRADE_CODE', "=", $grade)->where('emp_type', "=", $type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
  }
  $data = $setquery->get();
} else if($grade=="all_grade" && $type!=="all_type" && $active_type!=="all"){
  foreach ($get_categories as $val) {
    foreach($paygrade as $pay){
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ','dept_no','PAY_GRADE_CODE')->where('catg', "=", $val->category_code)->where('PAY_GRADE_CODE', "=", $pay->PAY_GRADE_CODE)->where('emp_type', "=", $type)->where('active_type', "=", $active_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
  }
  $data = $setquery->get();
} else if($grade!=="all_grade" && $type=="all_type" && $active_type!=="all"){
  foreach ($get_categories as $val) {
    foreach($employee_type as $type){
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ','dept_no','PAY_GRADE_CODE')->where('catg', "=", $val->category_code)->where('emp_type', "=", $type->emp_type)->where('PAY_GRADE_CODE', "=", $grade)->where('active_type', "=", $active_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
  }
  $data = $setquery->get();
} else {
  foreach ($get_categories as $val) {
    foreach($employee_type as $type){
      foreach($paygrade as $pay){
        $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','basic_pay','pp1','pp2','emp_no','active_type','DOJ','dept_no','PAY_GRADE_CODE')->where('catg', "=", $val->category_code)->where('emp_type', "=", $type->emp_type)->where('PAY_GRADE_CODE', "=", $pay->PAY_GRADE_CODE);
        if($i < 1){
            $setquery = $query;
        }else{
            $setquery->union($query);
        }
        $i++;
      }
    }
  }
  $data = $setquery->get();
}
$employee_list=ReportsController::pager($data,30,$page); 
      $send = [
        'categories'=>$get_categories,
        'pay_grade'=>$get_pay_grade,
        'employee_type'=>$employee_type,
        'employee_list'=>$employee_list
      ];
      return view('Frontend.employee-list-pay-grade-wise',$send);
    }


  
  
  public function emp_email_report(Request $request){ 
      $employee_type = DB::table('emp_mst')
      ->select('emp_mst.emp_type')
      ->where('emp_mst.emp_type','!=',NULL)
      ->groupBy('emp_mst.emp_type')
      ->get();
      $all_categories_data = DB::table('emp_mst')->select('emp_mst.catg')->where('emp_mst.catg','!=',NULL)->groupBy('emp_mst.catg')->get();
      $get_categories = array();
      foreach($all_categories_data as $key => $val){
        $get_categories[] = DB::table('category')->where('category_code','=',$val->catg)->first();
      }
      if(count($_GET)==0){
        $type= "all";
        $email= "all";
        $code= "all";
    } else {
      if(isset($_GET['type'])){
        $type= $request->type;
      } else {
        $type= "all";
      }
      if(isset($_GET['email'])){
        $email = $request->email;
      } else {
        $email = "all";
      }
      if(isset($_GET['code'])){
        $code =$request->code;
      } else {
        $code ="all";
      }
    }
    if(isset($_GET['active_type'])){
      $active_type =$request->active_type;
    } else {
      $active_type ="all";
    }
    if($email=="y"){
      $cemail = "!=";
    } else if($email=="n"){
      $cemail = "=";
    }
    if($code=="y"){
      $ccode = "!=";
    } else if($code=="n"){
      $ccode = "=";
    }
    if(isset($_GET['page'])){
      $page=$request->page;
    } else {
      $page= 1;
    } 
    $i = 0;
if($type=="" && $code=="" && $email=="" && $active_type==""){
    foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','email','dept_no','ph_no')->where('catg', "=", $val->category_code);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
  }
  $data = $setquery->get();
} else if($type=="all" && $code=="all" && $email=="all" && $active_type=="all"){
    foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','email','dept_no','ph_no')->where('catg', "=", $val->category_code);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
  }
  $data = $setquery->get();
} else if($type!=="all" && $code=="all" && $email=="all" && $active_type=="all"){
    foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','email','dept_no','ph_no')->where('catg', "=", $val->category_code)->where('emp_type','=',$type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
  }
  $data = $setquery->get();
} else if($type=="all" && $code!=="all" && $email=="all" && $active_type=="all"){
    foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','email','dept_no','ph_no')->where('catg', "=", $val->category_code)->where('employee_code',$ccode,null);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
  }
  $data = $setquery->get();
  } else if($type=="all" && $code=="all" && $email!=="all" && $active_type=="all"){
    foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','email','dept_no','ph_no')->where('catg', "=", $val->category_code)->where('email',$cemail,null);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
  }
  $data = $setquery->get();
  } else if($type=="all" && $code=="all" && $email=="all" && $active_type!=="all"){
    foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','email','dept_no','ph_no')->where('catg', "=", $val->category_code)->where('active_type','=',$active_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
  }
  $data = $setquery->get();
  } else if($type=="all" && $code=="all" && $email!=="all" && $active_type!=="all"){
    foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','email','dept_no','ph_no')->where('catg', "=", $val->category_code)->where('email',$cemail,null)->where('active_type','=',$active_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
  }
  $data = $setquery->get();
  } else if($type=="all" && $code!=="all" && $email!=="all" && $active_type!=="all"){
    foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','email','dept_no','ph_no')->where('catg', "=", $val->category_code)->where('employee_code',$ccode,null)->where('email',$cemail,null)->where('active_type','=',$active_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
  }
  $data = $setquery->get();
  } else if($type!=="all" && $code!=="all" && $email!=="all" && $active_type!=="all"){
    foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','email','dept_no','ph_no')->where('catg', "=", $val->category_code)->where('emp_type','=',$type)->where('email',$cemail,null)->where('employee_code',$ccode,null)->where('active_type','=',$active_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
  }
  $data = $setquery->get();
  } else if($type!=="all" && $code!=="all" && $email!=="all" && $active_type=="all"){
    foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','email','dept_no','ph_no')->where('catg', "=", $val->category_code)->where('email',$cemail,null)->where('employee_code',$ccode,null)->where('emp_type','=',$type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
  }
  $data = $setquery->get();
  } else if($type=="all" && $code=="all" && $email!=="all" && $active_type!=="all"){
    foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','email','dept_no','ph_no')->where('catg', "=", $val->category_code)->where('email',$cemail,null)->where('active_type','=',$active_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
  }
  $data = $setquery->get();
  } else if($type!=="all" && $code!=="all" && $email=="all" && $active_type=="all"){
    foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','email','dept_no','ph_no')->where('catg', "=", $val->category_code)->where('emp_type','=',$type)->where('employee_code',$ccode,null);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
  }
  $data = $setquery->get();
  } else if($type!=="all" && $code!=="all" && $email=="all" && $active_type!=="all"){
    foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','email','dept_no','ph_no')->where('catg', "=", $val->category_code)->where('emp_type','=',$type)->where('employee_code',$ccode,null)->where('active_type','=',$active_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
  }
  $data = $setquery->get();
  } else if($type!=="all" && $code=="all" && $email!=="all" && $active_type!=="all"){
    foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','email','dept_no','ph_no')->where('catg', "=", $val->category_code)->where('emp_type','=',$type)->where('email',$cemail,null)->where('active_type','=',$active_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
  }
  $data = $setquery->get();
  } else if($type=="all" && $code!=="all" && $email=="all" && $active_type!=="all"){
    foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','email','dept_no','ph_no')->where('catg', "=", $val->category_code)->where('employee_code',$ccode,null)->where('active_type','=',$active_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
  }
  $data = $setquery->get();
  } else if($type!=="all" && $code=="all" && $email=="all" && $active_type!=="all"){
    foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','email','dept_no','ph_no')->where('catg', "=", $val->category_code)->where('emp_type','=',$type)->where('active_type','=',$active_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
  }
  $data = $setquery->get();
  }else if($type=="all" && $code!=="all" && $email!=="all" && $active_type=="all"){
    foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','email','dept_no','ph_no')->where('catg', "=", $val->category_code)->where('employee_code',$ccode,null)->where('email',$cemail,null);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
  }
  $data = $setquery->get();
  } else if($type!=="all" && $code=="all" && $email!=="all" && $active_type=="all"){
    foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','email','dept_no','ph_no')->where('catg', "=", $val->category_code)->where('emp_type','=',$type)->where('email',$cemail,null);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
  }
  $data = $setquery->get();
  } else {
    foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','email','dept_no','ph_no')->where('catg', "=", $val->category_code);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
  }
  $data = $setquery->get();
}


    $employee_list=ReportsController::pager($data,30,$page); 
      $send = [
        'categories' => $get_categories,
        'employee_type'=>$employee_type,
        'employee_list'=>$employee_list
      ]; 
    return view('Frontend.employee-list-email-category-code-wise', $send);
  }
    
  public function emp_pan_report(Request $request){
    $employee_type = DB::table('emp_mst')
    ->select('emp_mst.emp_type')
    ->where('emp_mst.emp_type','!=',NULL)
    ->groupBy('emp_mst.emp_type')
    ->get();
    $all_categories_data = DB::table('emp_mst')->select('emp_mst.catg')->where('emp_mst.catg','!=',NULL)->groupBy('emp_mst.catg')->get();
      $get_categories = array();
      foreach($all_categories_data as $key => $val){
        $get_categories[] = DB::table('category')->where('category_code','=',$val->catg)->first();
      }
    if(count($_GET)==0){
      $type= "all";
      $pan= "all";
  } else {
    if(isset($_GET['pan'])){
      $pan = $request->pan;
    } else {
      $pan = "all";
    }
    if(isset($_GET['type'])){
      $type = $request->type;
    } else {
      $type ="all";
    }
  }
     
  if($pan=="y"){
    $cpan = "!=";
  } else if($pan=="n"){
    $cpan = "=";
  }
  if(isset($_GET['active_type'])){
    $active_type= $_GET['active_type'];
} else {
    $active_type= "all";
}
if(isset($_GET['page'])){
  $page=$request->page;
} else {
  $page= 1;
} 
$i = 0;
  if($type=="" && $pan=="" && $active_type==""){
    foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','email','dept_no','ph_no','DOJ','DOB','pan_no','desg_code')->where('catg', "=", $val->category_code);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
    $data = $setquery->get();
  } else if($type=="all" && $pan=="all" && $active_type=="all"){
    foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','email','dept_no','ph_no','DOJ','DOB','pan_no','desg_code')->where('catg', "=", $val->category_code);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
    $data = $setquery->get();
  } else if($type!=="all" && $pan=="all" && $active_type=="all"){
  foreach ($get_categories as $val) {
    $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','email','dept_no','ph_no','DOJ','DOB','pan_no','desg_code')->where('catg', "=", $val->category_code)->where('emp_type','=',$type);
    if($i < 1){
        $setquery = $query;
    }else{
        $setquery->union($query);
    }
    $i++;
  }
  $data = $setquery->get();
  } else if($type=="all" && $pan!=="all" && $active_type=="all"){
  foreach ($get_categories as $val) {
    $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','email','dept_no','ph_no','DOJ','DOB','pan_no','desg_code')->where('catg', "=", $val->category_code)->where('pan_no',$cpan,NULL);
    if($i < 1){
        $setquery = $query;
    }else{
        $setquery->union($query);
    }
    $i++;
  }
  $data = $setquery->get();
  } else if($type=="all" && $pan=="all" && $active_type!=="all"){
    foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','email','dept_no','ph_no','DOJ','DOB','pan_no','desg_code')->where('catg', "=", $val->category_code)->where('active_type','=',$active_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
    $data = $setquery->get();
  }else if($type=="all" && $pan!=="all" && $active_type!=="all"){
    foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','email','dept_no','ph_no','DOJ','DOB','pan_no','desg_code')->where('catg', "=", $val->category_code)->where('pan_no',$cpan,NULL)->where('active_type','=',$active_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
    $data = $setquery->get();
  } else if($type!=="all" && $pan!=="all" && $active_type!=="all"){
    foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','email','dept_no','ph_no','DOJ','DOB','pan_no','desg_code')->where('catg', "=", $val->category_code)->where('emp_type','=',$type) ->where('pan_no',$cpan,NULL)->where('active_type','=',$active_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
    $data = $setquery->get();
  } else if($type!=="all" && $pan=="all" && $active_type!=="all"){
    foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','email','dept_no','ph_no','DOJ','DOB','pan_no','desg_code')->where('catg', "=", $val->category_code)->where('emp_type','=',$type)->where('active_type','=',$active_type);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
    $data = $setquery->get();
  } else if($type!=="all" && $pan!=="all" && $active_type=="all"){
    foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','email','dept_no','ph_no','DOJ','DOB','pan_no','desg_code')->where('catg', "=", $val->category_code)->where('emp_type','=',$type)->where('pan_no',$cpan,NULL);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
    $data = $setquery->get();
  } else {
    foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','email','dept_no','ph_no','DOJ','DOB','pan_no','desg_code')->where('catg', "=", $val->category_code);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
    $data = $setquery->get();
  }
  $employee_list=ReportsController::pager($data,30,$page); 
  $send = [
      'categories' => $get_categories,
      'employee_type'=>$employee_type,
      'employee_list'=>$employee_list
    ];
    return view('Frontend.employee-list-pan-category-wise', $send );
  }
 





  public function emp_master_list(Request $request)
  {
    $all_categories_data = DB::table('emp_mst')
    ->leftJoin('category','emp_mst.catg','=','category.category_code')
    ->select('emp_mst.catg')
    ->where('emp_mst.catg','!=',NULL)
    ->groupBy('emp_mst.catg')
    ->get();
    $employee_type = DB::table('emp_mst')
    ->select('emp_mst.emp_type')
    ->where('emp_mst.emp_type','!=',NULL)
    ->groupBy('emp_mst.emp_type')
    ->orderBy('emp_mst.type_store_by', 'ASC')
    ->get();
    $get_categories = array();
    foreach($all_categories_data as $key => $val){
      $get_categories[] = DB::table('category')->where('category_code','=',$val->catg)->first();
    } 
   
    if(count($_GET)==0){
      $category = NULL;
      $type = NULL;
    } else {
      if(isset($_GET['category'])){
        $category = $request->category ;
      } else {
        $category = "";
      }
      if(isset($_GET['type'])){
        $type = $request->type;
      } else {
        $type ="";
      }
    }
  if(isset($_GET['active_type'])){
      $active_type= $_GET['active_type'];
  } else {
      $active_type= "all";
  }
  if(isset($_GET['page'])){
    $page=$request->page;
  } else {
    $page= 1;
  } 
  $i = 0;
  
if($category=="" && $type=="" && $active_type=="all"){
foreach ($get_categories as $val) {
  foreach($employee_type as $ty){
    $query = DB::table('emp_mst')
    ->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')
    ->where('emp_type', "=", $ty->emp_type)
    ->where('catg', "=", $val->category_code);
    if($i < 1){
        $setquery = $query;
    }else{
        $setquery->union($query);
    }
    $i++;
  }
}
$data = $setquery->get();
} else if($category=="all_cat" && $type=="all_type" && $active_type=="all"){
foreach ($get_categories as $val) {
  foreach($employee_type as $ty){
    $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', "=", $ty->emp_type)->where('catg', "=", $val->category_code);
    if($i < 1){
        $setquery = $query;
    }else{
        $setquery->union($query);
    }
    $i++;
  }
}
$data = $setquery->get();
} else if($category!=="all_cat" && $type=="all_type" && $active_type=="all"){
  foreach($employee_type as $ty){
    $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', "=", $ty->emp_type)->where('catg', "=", $category);
    if($i < 1){
        $setquery = $query;
    }else{
        $setquery->union($query);
    }
    $i++;
  }
$data = $setquery->get();

} else if($category=="all_cat" && $type!=="all_type" && $active_type=="all"){

foreach ($get_categories as $val) {
    $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('catg', "=", $val->category_code)->where('emp_type', "=", $type);
    if($i < 1){
        $setquery = $query;
    }else{
        $setquery->union($query);
    }
    $i++;
}
$data = $setquery->get();

} else if($category=="all_cat" && $type=="all_type" && $active_type!=="all"){

foreach ($get_categories as $val) {
  foreach($employee_type as $ty){
    $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', "=", $ty->emp_type)->where('catg', "=", $val->category_code)->where('active_type','=',$active_type);
    if($i < 1){
        $setquery = $query;
    }else{
        $setquery->union($query);
    }
    $i++;
  }
}
$data = $setquery->get();

} else if($category=="all_cat" && $type!=="all_type" && $active_type!=="all"){

foreach ($get_categories as $val) {
    $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', "=", $type)->where('catg', "=", $val->category_code)->where('active_type','=',$active_type);
    if($i < 1){
        $setquery = $query;
    }else{
        $setquery->union($query);
    }
    $i++;
}
$data = $setquery->get();

} else if($category!=="all_cat" && $type!=="all_type" && $active_type!=="all"){
$list = DB::table('emp_mst')
->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')
->where('emp_mst.emp_type','=',$type)
->where('emp_mst.catg','=',$category)
->where('emp_mst.active_type','=',$active_type)
->get();
$data =  $list;
}else if($category!=="all_cat" && $type!=="all_type" && $active_type=="all"){
$list = DB::table('emp_mst')
->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')
->where('emp_mst.emp_type','=',$type)
->where('emp_mst.catg','=',$category)
->get(); 
$data =  $list;
} else if($category!=="all_cat" && $type=="all_type" && $active_type!=="all"){
  foreach($employee_type as $ty){
    $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', "=", $ty->emp_type)->where('catg', "=", $category)->where('active_type','=',$active_type);
    if($i < 1){
        $setquery = $query;
    }else{
        $setquery->union($query);
    }
    $i++;
  }
$data = $setquery->get();

} else { 
foreach ($get_categories as $val) {
  foreach($employee_type as $ty){
    $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', "=", $ty->emp_type)->where('catg', "=", $val->category_code);
    if($i < 1){
        $setquery = $query;
    }else{
        $setquery->union($query);
    }
    $i++;
  }
}
$data = $setquery->get();
} 
$employee_list=ReportsController::pager($data,30,$page); 
    $send = [
      'categories'=>$get_categories,
      'employee_type'=>$employee_type,
      'employee_list'=>$employee_list
    ];
    
    return view('Frontend.employee-master-list',$send);
  } 


  public function emp_master_list_joining_period(Request $request)
  {
    $all_categories_data = DB::table('emp_mst')
    ->leftJoin('category','emp_mst.catg','=','category.category_code')
    ->select('emp_mst.catg')
    ->where('emp_mst.catg','!=',NULL)
    ->groupBy('emp_mst.catg')
    ->get();
    $employee_type = DB::table('emp_mst')
    ->select('emp_mst.emp_type')
    ->where('emp_mst.emp_type','!=',NULL)
    ->groupBy('emp_mst.emp_type')
    ->orderBy('emp_mst.type_store_by', 'ASC')
    ->get();
    $get_categories = array();
    foreach($all_categories_data as $key => $val){
      $get_categories[] = DB::table('category')->where('category_code','=',$val->catg)->first();
    } 
   

  if(isset($_GET['category'])){
    $category = $request->category ;
  } else {
    $category = "";
  }
  if(isset($_GET['type'])){
    $type = $request->type;
  } else {
    $type ="";
  }
  if(isset($_GET['active_type'])){
      $active_type= $_GET['active_type'];
  } else {
      $active_type= "";
  }
  if(isset($_GET['to'])){
    $to= $_GET['to'];
} else {
    $to= "";
}
if(isset($_GET['from'])){
  $from= $_GET['from'];
} else {
  $from= "";
}

  if(isset($_GET['page'])){
    $page=$request->page;
  } else {
    $page= 1;
  } 
  $i = 0;
  if($category=="" && $type=="" && $active_type=="" && $from=="" && $to==""){
    // echo 1; exit;
  foreach ($get_categories as $val) {
    foreach($employee_type as $ty){
      $query = DB::table('emp_mst')
      ->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', "=", $ty->emp_type)->where('catg', "=", $val->category_code);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
  }
  $data = $setquery->get();
  }  else if($category=="all_cat" && $type=="all_type" && $active_type=="all" && $from=="" && $to==""){
    foreach ($get_categories as $val) {
      foreach($employee_type as $ty){
        $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', "=", $ty->emp_type)->where('catg', "=", $val->category_code);
        if($i < 1){
            $setquery = $query;
        }else{
            $setquery->union($query);
        }
        $i++;
      }
    }
    $data = $setquery->get();
  
  } else if($category!=="all_cat" && $type=="all_type" && $active_type=="all" && $from=="" && $to==""){
    
      foreach($employee_type as $ty){
        $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', "=", $ty->emp_type)->where('catg', "=", $category);
        if($i < 1){
            $setquery = $query;
        }else{
            $setquery->union($query);
        }
        $i++;
      }
    $data = $setquery->get();
  }else if($category=="all_cat" && $type!=="all_type" && $active_type=="all" && $from=="" && $to==""){
    
    foreach ($get_categories as $val) {
        $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', "=", $type)->where('catg', "=", $val->category_code);
        if($i < 1){
            $setquery = $query;
        }else{
            $setquery->union($query);
        }
        $i++;
    }
  $data = $setquery->get();
  }else if($category=="all_cat" && $type=="all_type" && $active_type!=="all" && $from=="" && $to==""){
    foreach ($get_categories as $val) {
      foreach($employee_type as $ty){
        $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', "=", $ty->emp_type)->where('catg', "=", $val->category_code)->where('active_type', "=", $active_type);
        if($i < 1){
            $setquery = $query;
        }else{
            $setquery->union($query);
        }
        $i++;
      }
    }
  $data = $setquery->get();
  }else if($category=="all_cat" && $type=="all_type" && $active_type=="all" && $from!=="" && $to==""){
    foreach ($get_categories as $val) {
      foreach($employee_type as $ty){
        $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', "=", $ty->emp_type)->where('catg', "=", $val->category_code)->where('DOJ', "=", $from);
        if($i < 1){
            $setquery = $query;
        }else{
            $setquery->union($query);
        }
        $i++;
      }
    }
  $data = $setquery->get();
  }else if($category=="all_cat" && $type=="all_type" && $active_type=="all" && $from=="" && $to!==""){
    exit;
    foreach ($get_categories as $val) {
      foreach($employee_type as $ty){
        $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', "=", $ty->emp_type)->where('catg', "=", $val->category_code)->where('DOJ', "=", $to);
        if($i < 1){
            $setquery = $query;
        }else{
            $setquery->union($query);
        }
        $i++;
      }
    }
  $data = $setquery->get();
  }else if($category!=="all_cat" && $type!=="all_type" && $active_type=="all" && $from=="" && $to==""){
  
  $data = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', "=", $type)->where('catg', "=", $category)->get();
  
  }else if($category=="all_cat" && $type!=="all_type" && $active_type!=="all" && $from=="" && $to==""){
    foreach ($get_categories as $val) {
        $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', "=", $type)->where('catg', "=", $val->category_code);
        if($i < 1){
            $setquery = $query;
        }else{
            $setquery->union($query);
        }
        $i++;
    }
  $data = $setquery->get();
  }else if($category!=="all_cat" && $type=="all_type" && $active_type!=="all" && $from=="" && $to==""){
    foreach ($get_categories as $val) {
        $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('catg', "=", $val->category_code)->where('active_type', "=", $active_type);
        if($i < 1){
            $setquery = $query;
        }else{
            $setquery->union($query);
        }
        $i++;
    }
  $data = $setquery->get();
  }else if($category=="all_cat" && $type=="all_type" && $active_type!=="all" && $from!=="" && $to==""){
    foreach ($get_categories as $val) {
      foreach($employee_type as $ty){
        $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', "=", $ty->emp_type)->where('catg', "=", $val->category_code)->where('active_type', "=", $active_type)->where('DOJ', "=", $from);
        if($i < 1){
            $setquery = $query;
        }else{
            $setquery->union($query);
        }
        $i++;
      }
    }
  $data = $setquery->get();
  }else if($category=="all_cat" && $type=="all_type" && $active_type!=="all" && $from=="" && $to!==""){
    foreach ($get_categories as $val) {
      foreach($employee_type as $ty){
        $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', "=", $ty->emp_type)->where('catg', "=", $val->category_code)->where('active_type', "=", $active_type)->where('DOJ', "=", $to);
        if($i < 1){
            $setquery = $query;
        }else{
            $setquery->union($query);
        }
        $i++;
      }
    }
  $data = $setquery->get();
  }else if($category=="all_cat" && $type!=="all_type" && $active_type=="all" && $from=="" && $to!==""){
      foreach($employee_type as $ty){
        $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', "=", $type)->where('catg', "=", $val->category_code)->where('DOJ', "=", $to);
        if($i < 1){
            $setquery = $query;
        }else{
            $setquery->union($query);
        }
        $i++;
      }
  $data = $setquery->get();
  }else if($category!=="all_cat" && $type=="all_type" && $active_type=="all" && $from=="" && $to!==""){
    foreach($employee_type as $ty){
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', "=", $ty->emp_type)->where('catg', "=", $category)->where('DOJ', "=", $to);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
  $data = $setquery->get();
  }else if($category!=="all_cat" && $type=="all_type" && $active_type=="all" && $from!=="" && $to==""){
    foreach($employee_type as $ty){
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', "=", $ty->emp_type)->where('catg', "=", $category)->where('DOJ', "=", $from);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
  $data = $setquery->get();
  }else if($category=="all_cat" && $type!=="all_type" && $active_type=="all" && $from!=="" && $to==""){
    foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', "=", $type)->where('catg', "=", $val->category_code)->where('DOJ', "=", $from);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
  $data = $setquery->get();
  }else if($category=="all_cat" && $type=="all_type" && $active_type!=="all" && $from!=="" && $to==""){
    foreach ($get_categories as $val) {
      foreach($employee_type as $ty){
        $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', "=", $ty->emp_type)->where('catg', "=", $val->category_code)->where('DOJ', '=', $from)->where('active_type', '=', $active_type);
        if($i < 1){
            $setquery = $query;
        }else{
            $setquery->union($query);
        }
        $i++;
      }
    }
  $data = $setquery->get();
  } else if($category=="all_cat" && $type=="all_type" && $active_type=="all" && $from!=="" && $to!==""){
  foreach ($get_categories as $val) {
    foreach($employee_type as $ty){
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', "=", $ty->emp_type)->where('catg', "=", $val->category_code)->where('DOJ', '>=', $from)->where('DOJ', '<=', $to);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
  }
  //->where('DOJ', '>=', $from)->where('DOJ', '<', $to)->get()
  //->whereBetween(DB::raw("(DATE_FORMAT(emp_mst.DOJ,'%Y-%m-%d'))"), [Carbon::createFromFormat('Y-m-d', $from)->startOfDay(), Carbon::createFromFormat('Y-m-d', $to)->endOfDay()]);
  $data = $setquery->get();
  } else if($category=="all_cat" && $type=="all_type" && $active_type=="all" && $from==$to){
    // echo 3; exit;
    foreach ($get_categories as $val) {
      foreach($employee_type as $ty){
        $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', "=", $ty->emp_type)->where('catg', "=", $val->category_code)->where('DOJ', '=', $from)->where('DOJ', '=', $to);
        if($i < 1){
            $setquery = $query;
        }else{
            $setquery->union($query);
        }
        $i++;
      }
    }
    $data = $setquery->get();
  } else if($category=="all_cat" && $type=="all_type" && $active_type=="all" && $to==$from){
    // echo 4; exit;
    foreach ($get_categories as $val) {
      foreach($employee_type as $ty){
        $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', "=", $ty->emp_type)->where('catg', "=", $val->category_code)->where('DOJ', '=', $from)->where('DOJ', '=', $to);
        if($i < 1){
            $setquery = $query;
        }else{
            $setquery->union($query);
        }
        $i++;
      }
    }
    $data = $setquery->get();
  } else if($category!=="all_cat" && $type=="all_type" && $active_type=="all" && $from==$to){
    // echo 5; exit;
      foreach($employee_type as $ty){
        $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', "=", $ty->emp_type)->where('catg', '=', $category)->where('DOJ', '=', $from)->where('DOJ', '=', $to);
        if($i < 1){
            $setquery = $query;
        }else{
            $setquery->union($query);
        }
        $i++;
      }
    $data = $setquery->get();
  } else if($category=="all_cat" && $type!=="all_type" && $active_type=="all" && $from==$to){
    // echo 6; exit;
    foreach ($get_categories as $val) {
        $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('catg', "=", $val->category_code)->where('emp_type', '=', $type)->where('DOJ', '=', $from)->where('DOJ', '=', $to);
        if($i < 1){
            $setquery = $query;
        }else{
            $setquery->union($query);
        }
        $i++;
    }
    $data = $setquery->get();
  } else if($category=="all_cat" && $type=="all_type" && $active_type!=="all" && $from==$to){
    // echo 7; exit;
    foreach ($get_categories as $val) {
      foreach($employee_type as $ty){
        $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', "=", $ty->emp_type)->where('catg', "=", $val->category_code)->where('active_type', '=', $active_type)->where('DOJ', '=', $from)->where('DOJ', '=', $to);
        if($i < 1){
            $setquery = $query;
        }else{
            $setquery->union($query);
        }
        $i++;
      }
    }
    $data = $setquery->get();
  } else if($category!=="all_cat" && $type=="all_type" && $active_type=="all" && $from!=="" && $to!==""){
    // echo 8; exit;
      foreach($employee_type as $ty){
        $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', "=", $ty->emp_type)->where('catg', '=', $category)->where('DOJ', '>=', $from)->where('DOJ', '<=', $to);
        if($i < 1){
            $setquery = $query;
        }else{
            $setquery->union($query);
        }
        $i++;
      }
      $data = $setquery->get();    
  } else if($category=="all_cat" && $type!=="all_type" && $active_type=="all" && $from!=="" && $to!==""){
    // echo 9; exit;
    foreach ($get_categories as $val) {
        $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', '=', $type)->where('catg', "=", $val->category_code)->where('DOJ', '>=', $from)->where('DOJ', '<=', $to);
        if($i < 1){
            $setquery = $query;
        }else{
            $setquery->union($query);
        }
        $i++;
    }
    $data = $setquery->get();
  } else if($category=="all_cat" && $type=="all_type" && $active_type!=="all" && $from!=="" && $to!==""){
    // echo 10; exit;
    foreach ($get_categories as $val) {
      foreach($employee_type as $ty){
        $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', "=", $ty->emp_type)->where('catg', "=", $val->category_code)->where('active_type', '=', $active_type)->where('DOJ', '>=', $from)->where('DOJ', '<=', $to);
        if($i < 1){
            $setquery = $query;
        }else{
            $setquery->union($query);
        }
        $i++;
      }
    }
    $data = $setquery->get();
  } else if($category=="all_cat" && $type!=="all_type" && $active_type!=="all" && $from!=="" && $to!==""){
    // echo 11; exit;
    foreach ($get_categories as $val) {
        $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', '=', $type)->where('catg', "=", $val->category_code)->where('active_type', '=', $active_type)->where('DOJ', '>=', $from)->where('DOJ', '<=', $to);
        if($i < 1){
            $setquery = $query;
        }else{
            $setquery->union($query);
        }
        $i++;
    }
    $data = $setquery->get();
  } else if($category!=="all_cat" && $type!=="all_type" && $active_type!=="all" && $from!=="" && $to!==""){
    // echo 12; exit;
    $data = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', '=', $type)->where('catg', "=", $category)->where('active_type', '=', $active_type)->where('DOJ', '>=', $from)->where('DOJ', '<=', $to)->get();
  
  } else if($category!=="all_cat" && $type!=="all_type" && $active_type=="all" && $from!=="" && $to!==""){
    // echo 13; exit;
    $data = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', '=', $type)->where('catg', "=", $category)->where('DOJ', '>=', $from)->where('DOJ', '<=', $to)->get();
  
  } else if($category=="all_cat" && $type!=="all_type" && $active_type!=="all" && $from!=="" && $to!==""){
    // echo 14; exit;
    foreach ($get_categories as $val) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', '=', $type)->where('catg', "=", $val->category_code)->where('active_type', "=", $active_type)->where('DOJ', '>=', $from)->where('DOJ', '<=', $to);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
  }
  $data = $setquery->get();
  } else if($category!=="all_cat" && $type=="all_type" && $active_type!=="all" && $from!=="" && $to!==""){
    foreach ($employee_type as $ty) {
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', "=", $ty->emp_type)->where('catg', "=", $category)->where('active_type', "=", $active_type)->where('DOJ', '>=', $from)->where('DOJ', '<=', $to);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
  }
  $data = $setquery->get();
  } else { 
  foreach ($get_categories as $val) {
    foreach($employee_type as $ty){
      $query = DB::table('emp_mst')->select('id', 'emp_type', 'catg', 'employee_code','emp_name','emp_no','active_type','DOJ','confirm_date','retirement_date','DOB','reason_desc')->where('emp_type', "=", $ty->emp_type)->where('catg', "=", $val->category_code);
      if($i < 1){
          $setquery = $query;
      }else{
          $setquery->union($query);
      }
      $i++;
    }
  }
  $data = $setquery->get();
  }
  
  
$employee_list=ReportsController::pager($data,30,$page); 
    $send = [
      'categories'=>$get_categories,
      'employee_type'=>$employee_type,
      'employee_list'=>$employee_list
    ];
    
    return view('Frontend.employee-master-list-with-joining-period',$send);
  } 




  public function emp_birthday_report(Request $request){
    if(count($_GET)==0){
      $cto_date= "";
      $cfrom_date= "";
    } else {
      if(isset($_GET['to_date'])){
        $cto_date= $request->to_date;
      } else {
        $cto_date= "";
      }
      if(isset($_GET['from_date'])){
        $cfrom_date= $request->from_date;
      } else {
        $cfrom_date= "";
      }
    }
  if(isset($_GET['active_type'])){
      $active_type=$request->active_type;
  } else {
      $active_type= "all";
  }  
    if($cfrom_date=="" && $cto_date=="" && $active_type==""){
      $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
  ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','pay_grade_mst.pay_grade_code','pay_grade_mst.pay_scale','emp_mst.DOB','emp_mst.employee_code','emp_mst.active_type')
  ->paginate(30);
    } else if($cfrom_date==$cto_date  && $active_type=="all" ){
      $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
  ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','pay_grade_mst.pay_grade_code','pay_grade_mst.pay_scale','emp_mst.DOB','emp_mst.employee_code','emp_mst.active_type')
  ->where('emp_mst.DOB','LIKE',"%$cfrom_date%")
  ->paginate(30);
    } else if($cfrom_date==$cto_date  && $active_type!=="all" ){
      $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
  ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','pay_grade_mst.pay_grade_code','pay_grade_mst.pay_scale','emp_mst.DOB','emp_mst.employee_code','emp_mst.active_type')
  ->where('emp_mst.active_type','=',$active_type)
  ->where('emp_mst.DOB','LIKE',"%$cfrom_date%")
  ->paginate(30);
    } else if($cfrom_date!=="" && $cto_date!==""  && $active_type!=="all" ){
      $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
  ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','pay_grade_mst.pay_grade_code','pay_grade_mst.pay_scale','emp_mst.DOB','emp_mst.employee_code','emp_mst.active_type')
  ->where('emp_mst.active_type','=',$active_type)
  ->whereBetween(DB::raw("(DATE_FORMAT(emp_mst.DOB,'%Y-%m-%d'))"), [Carbon::createFromFormat('Y-m-d', $cfrom_date)->startOfDay(), Carbon::createFromFormat('Y-m-d', $cto_date)->endOfDay()])
  ->paginate(30);
    } else if($cfrom_date!=="" && $cto_date!==""  && $active_type=="all" ){
      $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
  ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','pay_grade_mst.pay_grade_code','pay_grade_mst.pay_scale','emp_mst.DOB','emp_mst.employee_code','emp_mst.active_type')
  // ->where(DB::raw("(DATE_FORMAT(emp_mst.DOB,'%Y-%m-%d'))"), ">=", $cfrom_date)
  // ->where(DB::raw("(DATE_FORMAT(emp_mst.DOB,'%Y-%m-%d'))"), "<=", $cto_date)
  ->whereBetween(DB::raw("(DATE_FORMAT(emp_mst.DOB,'%Y-%m-%d'))"), [Carbon::createFromFormat('Y-m-d', $cfrom_date)->startOfDay(), Carbon::createFromFormat('Y-m-d', $cto_date)->endOfDay()])
  ->paginate(30);
    } else { 
      $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
  ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','pay_grade_mst.pay_grade_code','pay_grade_mst.pay_scale','emp_mst.DOB','emp_mst.employee_code','emp_mst.active_type')
  ->paginate(30);
    }
   
    $data = [
      'employee_list'=>$employee_list
    ];
    return view('Frontend.birthday-fall-report',$data);
   }
   
 

  public function emp_completion_report(Request $request){
    if(count($_GET)==0){
      $cto_date= "";
      $cfrom_date= "";
    } else {
      if(isset($_GET['to_date'])){
        $cto_date= $request->to_date;
      } else {
        $cto_date= "";
      }
      if(isset($_GET['from_date'])){
        $cfrom_date= $request->from_date;
      } else {
        $cfrom_date= "";
      }
    }
  if(isset($_GET['active_type'])){
      $active_type=$request->active_type;
  } else {
      $active_type= "all";
  } 
    if($cfrom_date=="" && $cto_date==""  && $active_type=="all"){
      $employee_list = DB::table('emp_contract_dtl')
      ->leftJoin('emp_mst','emp_contract_dtl.emp_no','=','emp_mst.emp_no')
      ->select('emp_contract_dtl.emp_no')
      ->groupBy('emp_contract_dtl.emp_no')
      ->paginate(30);
    } else if($cfrom_date==$cto_date && $active_type=="all"){
      $employee_list = DB::table('emp_contract_dtl')
      ->leftJoin('emp_mst','emp_contract_dtl.emp_no','=','emp_mst.emp_no')
      ->select('emp_contract_dtl.emp_no')
      ->groupBy('emp_contract_dtl.emp_no')
      ->orWhere('emp_contract_dtl.cont_start_date','=',$cfrom_date)
      ->orWhere('emp_contract_dtl.cont_end_date','=',$cto_date)
      ->paginate(30);
    } else if($cfrom_date==$cto_date && $active_type!=="all"){
      $employee_list = DB::table('emp_contract_dtl')
        ->leftJoin('emp_mst','emp_contract_dtl.emp_no','=','emp_mst.emp_no')
        ->select('emp_contract_dtl.emp_no')
        ->groupBy('emp_contract_dtl.emp_no')
        ->where('emp_mst.active_type','=',$active_type)
        ->orWhere('emp_contract_dtl.cont_start_date','=',$cfrom_date)
        ->orWhere('emp_contract_dtl.cont_end_date','=',$cto_date)
        ->paginate(30);
    } else if($cfrom_date!=="" && $cto_date!=="" && $active_type!=="all"){
      $employee_list = DB::table('emp_contract_dtl')
        ->leftJoin('emp_mst','emp_contract_dtl.emp_no','=','emp_mst.emp_no')
        ->select('emp_contract_dtl.emp_no')
        ->groupBy('emp_contract_dtl.emp_no')
        //->whereBetween('emp_contract_dtl.cont_end_date', [Carbon::createFromFormat('Y-m-d', $cfrom_date)->startOfDay(), Carbon::createFromFormat('Y-m-d', $cto_date)->endOfDay()])
        ->where('emp_contract_dtl.cont_start_date','>=', Carbon::createFromFormat('Y-m-d', $cfrom_date)->startOfDay())
        ->where('emp_contract_dtl.cont_end_date','<=', Carbon::createFromFormat('Y-m-d', $cto_date)->endOfDay())
        ->where('emp_mst.active_type','=',$active_type)
        ->paginate(30);
    } else if($cfrom_date!=="" && $cto_date!=="" && $active_type=="all"){
      $employee_list = DB::table('emp_contract_dtl')
        ->leftJoin('emp_mst','emp_contract_dtl.emp_no','=','emp_mst.emp_no')
        ->select('emp_contract_dtl.emp_no')
        ->groupBy('emp_contract_dtl.emp_no')
        ->where('emp_contract_dtl.cont_start_date','>=', Carbon::createFromFormat('Y-m-d', $cfrom_date)->startOfDay())
        ->where('emp_contract_dtl.cont_end_date','<=', Carbon::createFromFormat('Y-m-d', $cto_date)->endOfDay())
        ->paginate(30);
    } else {
      $employee_list = DB::table('emp_contract_dtl')
      ->leftJoin('emp_mst','emp_contract_dtl.emp_no','=','emp_mst.emp_no')
      ->select('emp_contract_dtl.emp_no')
      ->groupBy('emp_contract_dtl.emp_no')
      ->paginate(30);
    } 
    $data = [
      'employee_list'=>$employee_list
    ];
  return view('Frontend.contract-completion-report',$data);
  }
 
  public function emp_probation_completion_report(Request $request)
  {
    if(count($_GET)==0){
      $cto_date= "";
      $cfrom_date= "";
    } else {
      if(isset($_GET['to_date'])){
        $cto_date= $request->to_date;
      } else {
        $cto_date= "";
      }
      if(isset($_GET['from_date'])){
        $cfrom_date= $request->from_date;
      } else {
        $cfrom_date= "";
      }
    }
    if(isset($_GET['active_type'])){
      $active_type=$request->active_type;
  } else {
      $active_type= "all";
  }
    if($cfrom_date=="" && $cto_date=="" && $active_type=="all"){
      $employee_list = DB::table('emp_mst')
      ->leftJoin('category','emp_mst.catg','=','category.category_code')
      ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
      ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
      ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','emp_mst.DOP','emp_mst.pan_no','emp_mst.current_basic','emp_mst.employee_code','emp_mst.active_type','emp_mst.new_basic_pay')
      ->where('emp_mst.emp_type','=','PR')
      ->paginate(30);
    } else if($cfrom_date==$cto_date && $active_type=="all"){
      $employee_list = DB::table('emp_mst')
      ->leftJoin('category','emp_mst.catg','=','category.category_code')
      ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
      ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
      ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','emp_mst.DOP','emp_mst.pan_no','emp_mst.current_basic','emp_mst.employee_code','emp_mst.active_type','emp_mst.new_basic_pay')
      ->where('emp_mst.emp_type','=','PR')
      ->where('emp_mst.DOP','=',$cto_date)
      ->paginate(30);
    } else if($cfrom_date==$cto_date && $active_type!=="all"){
      $employee_list = DB::table('emp_mst')
      ->leftJoin('category','emp_mst.catg','=','category.category_code')
      ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
      ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
      ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','emp_mst.DOP','emp_mst.pan_no','emp_mst.current_basic','emp_mst.employee_code','emp_mst.active_type','emp_mst.new_basic_pay')
      ->where('emp_mst.emp_type','=','PR')
      ->where('emp_mst.DOP','=',$cto_date)
      ->where('emp_mst.active_type','=',$active_type)
      ->paginate(30);
    }  else if($cfrom_date!=="" && $cto_date!=="" && $active_type!=="all"){
      $employee_list = DB::table('emp_mst')
      ->leftJoin('category','emp_mst.catg','=','category.category_code')
      ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
      ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
      ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','emp_mst.DOP','emp_mst.pan_no','emp_mst.current_basic','emp_mst.employee_code','emp_mst.active_type','emp_mst.new_basic_pay')  
      ->where('emp_mst.emp_type','=','PR')
      ->whereBetween('emp_mst.DOP', [new Carbon($cfrom_date), new Carbon($cto_date)])
      ->where('emp_mst.active_type','=',$active_type)
      ->paginate(30);
    }   else if($cfrom_date!=="" && $cto_date!=="" && $active_type=="all"){
      $employee_list = DB::table('emp_mst')
      ->leftJoin('category','emp_mst.catg','=','category.category_code')
      ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
      ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
      ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','emp_mst.DOP','emp_mst.pan_no','emp_mst.current_basic','emp_mst.employee_code','emp_mst.active_type','emp_mst.new_basic_pay')
      ->where('emp_mst.emp_type','=','PR')
      ->whereBetween('emp_mst.DOP', [new Carbon($cfrom_date), new Carbon($cto_date)])
      ->paginate(30);
    } else {
      $employee_list = DB::table('emp_mst')
      ->leftJoin('category','emp_mst.catg','=','category.category_code')
      ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
      ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
      ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','emp_mst.DOP','emp_mst.pan_no','emp_mst.current_basic','emp_mst.employee_code','emp_mst.active_type','emp_mst.new_basic_pay')
      ->where('emp_mst.emp_type','=','PR')
      ->paginate(30);
    }
    $data = [
      'employee_list'=>$employee_list
    ];
// ->where(DB::raw("(DATE_FORMAT(emp_mst.DOP,'%Y-%m-%d'))"), ">=", $cfrom_date)
// ->where(DB::raw("(DATE_FORMAT(emp_mst.DOP,'%Y-%m-%d'))"), "<=", $cto_date)
// ->whereBetween(DB::raw("(DATE_FORMAT(emp_mst.DOP,'%Y-%m-%d'))"), [Carbon::createFromFormat('Y-m-d', $cfrom_date)->startOfDay(), Carbon::createFromFormat('Y-m-d', $cto_date)->endOfDay()])    
// ->where('emp_mst.DOP', '>=', DB::raw("(DATE_FORMAT(emp_mst.DOP,'%Y-%m-%d'))"),$cfrom_date)
// ->where('emp_mst.DOP', '<=', DB::raw("(DATE_FORMAT(emp_mst.DOP,'%Y-%m-%d'))"),$cto_date)
//$startDate = Carbon::createFromFormat('Y-m-d', '2021-06-01')->startOfDay();
//$endDate = Carbon::createFromFormat('Y-m-d', '2021-06-30')->endOfDay();
//$startDate = Carbon::createFromFormat('d/m/Y', '01/01/2021');
// $endDate = Carbon::createFromFormat('d/m/Y', '06/01/2021');
// ->where('created_at', '>=', $cfrom_date)
// ->where('created_at', '<=', $cto_date)
    return view('Frontend.probation-completion-report',$data);
  }
 
public function emp_retirement_due_report(Request $request)
{
  if(count($_GET)==0){
    $cto_date= "";
    $cfrom_date= "";
  } else {
    if(isset($_GET['to_date'])){
      $cto_date= $request->to_date;
    } else {
      $cto_date= "";
    }
    if(isset($_GET['from_date'])){
      $cfrom_date= $request->from_date;
    } else {
      $cfrom_date= "";
    }
  }
  if(isset($_GET['active_type'])){
    $active_type=$request->active_type;
} else {
    $active_type= "all";
}
  if($cfrom_date=="" && $cto_date=="" && $active_type=="all"){
    $employee_list = DB::table('emp_mst')
    ->leftJoin('category','emp_mst.catg','=','category.category_code')
    ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
    ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
    ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','emp_mst.DOP','emp_mst.pan_no','emp_mst.current_basic','emp_mst.retirement_date','emp_mst.DOB','emp_mst.employee_code','emp_mst.active_type')
    ->where('emp_mst.emp_type','=','PE')
    ->paginate(30);
  } else if($cfrom_date==$cto_date && $active_type=="all"){
    $employee_list = DB::table('emp_mst')
    ->leftJoin('category','emp_mst.catg','=','category.category_code')
    ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
    ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
    ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','emp_mst.DOP','emp_mst.pan_no','emp_mst.current_basic','emp_mst.retirement_date','emp_mst.DOB','emp_mst.employee_code','emp_mst.active_type')
    ->where('emp_mst.emp_type','=','PE')
    ->where('emp_mst.retirement_date','=',$cfrom_date)
    ->paginate(30);
  } else if($cfrom_date!=="" && $cto_date!=="" && $active_type=="all"){
    $employee_list = DB::table('emp_mst')
    ->leftJoin('category','emp_mst.catg','=','category.category_code')
    ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
    ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
    ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','emp_mst.DOP','emp_mst.pan_no','emp_mst.current_basic','emp_mst.retirement_date','emp_mst.DOB','emp_mst.employee_code','emp_mst.active_type')
    ->where('emp_mst.emp_type','=','PE')
    ->where(DB::raw("(DATE_FORMAT(emp_mst.retirement_date,'%Y-%m-%d'))"), ">=", $cfrom_date)
    ->where(DB::raw("(DATE_FORMAT(emp_mst.retirement_date,'%Y-%m-%d'))"), "<=", $cto_date)
    ->paginate(30);
  } else if($cfrom_date!=="" && $cto_date!=="" && $active_type!=="all"){
    $employee_list = DB::table('emp_mst')
    ->leftJoin('category','emp_mst.catg','=','category.category_code')
    ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
    ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
    ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','emp_mst.DOP','emp_mst.pan_no','emp_mst.current_basic','emp_mst.retirement_date','emp_mst.DOB','emp_mst.employee_code','emp_mst.active_type')
    ->where('emp_mst.emp_type','=','PE')
    ->where(DB::raw("(DATE_FORMAT(emp_mst.retirement_date,'%Y-%m-%d'))"), ">=", $cfrom_date)
    ->where(DB::raw("(DATE_FORMAT(emp_mst.retirement_date,'%Y-%m-%d'))"), "<=", $cto_date)
    ->where('emp_mst.active_type','=',$active_type)
    ->paginate(30);
  }  else {
    $employee_list = DB::table('emp_mst')
    ->leftJoin('category','emp_mst.catg','=','category.category_code')
    ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
    ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
    ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','emp_mst.DOP','emp_mst.pan_no','emp_mst.current_basic','emp_mst.retirement_date','emp_mst.DOB','emp_mst.employee_code','emp_mst.active_type')
    ->where('emp_mst.emp_type','=','PE')
    //->where(DB::raw("(DATE_FORMAT(emp_mst.retirement_date,'%Y-%m-%d'))"), ">=", $cfrom_date)
    //->where(DB::raw("(DATE_FORMAT(emp_mst.retirement_date,'%Y-%m-%d'))"), "<=", $cto_date)
    // ->whereBetween('emp_mst.retirement_date', [new Carbon($cfrom_date), new Carbon($cto_date)])
    ->paginate(30);
  }
 
  $data = [
    'employee_list'=>$employee_list
  ]; 
  return view('Frontend.retirement-due-reports',$data);
}

public function emp_retired_report(Request $request)
{

  if(count($_GET)==0){
    $cto_date= "";
    $cfrom_date= "";
  } else {
    if(isset($_GET['to_date'])){
      $cto_date= $request->to_date;
    } else {
      $cto_date= "";
    }
    if(isset($_GET['from_date'])){
      $cfrom_date= $request->from_date;
    } else {
      $cfrom_date= "";
    }
  }
if(isset($_GET['active_type'])){
    $active_type=$request->active_type;
} else {
    $active_type= "all";
}
  if($cfrom_date=="" && $cto_date=="" && $active_type=="all"){
    $employee_list = DB::table('emp_mst')
    ->leftJoin('category','emp_mst.catg','=','category.category_code')
    ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
    ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
    ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','emp_mst.DOP','emp_mst.pan_no','emp_mst.current_basic','emp_mst.retirement_date','emp_mst.DOB','emp_mst.employee_code','emp_mst.active_type')
    ->where('emp_mst.emp_type','=','PE')
    ->paginate(30);
  } else if($cfrom_date==$cto_date && $active_type=="all"){
    $employee_list = DB::table('emp_mst')
    ->leftJoin('category','emp_mst.catg','=','category.category_code')
    ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
    ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
    ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','emp_mst.DOP','emp_mst.pan_no','emp_mst.current_basic','emp_mst.retirement_date','emp_mst.DOB','emp_mst.employee_code','emp_mst.active_type')
    ->where('emp_mst.emp_type','=','PE')
    ->where('emp_mst.retirement_date','=',$cfrom_date)
    ->paginate(30);
  } else if($cfrom_date!=="" && $cto_date!=="" && $active_type=="all"){
    $employee_list = DB::table('emp_mst')
    ->leftJoin('category','emp_mst.catg','=','category.category_code')
    ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
    ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
    ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','emp_mst.DOP','emp_mst.pan_no','emp_mst.current_basic','emp_mst.retirement_date','emp_mst.DOB','emp_mst.employee_code','emp_mst.active_type')
    ->where('emp_mst.emp_type','=','PE')
    ->where(DB::raw("(DATE_FORMAT(emp_mst.retirement_date,'%Y-%m-%d'))"), ">=", $cfrom_date)
    ->where(DB::raw("(DATE_FORMAT(emp_mst.retirement_date,'%Y-%m-%d'))"), "<=", $cto_date)
    ->paginate(30);
  } else if($cfrom_date!=="" && $cto_date!=="" && $active_type!=="all"){
    $employee_list = DB::table('emp_mst')
    ->leftJoin('category','emp_mst.catg','=','category.category_code')
    ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
    ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
    ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','emp_mst.DOP','emp_mst.pan_no','emp_mst.current_basic','emp_mst.retirement_date','emp_mst.DOB','emp_mst.employee_code','emp_mst.active_type')
    ->where('emp_mst.emp_type','=','PE')
    ->where(DB::raw("(DATE_FORMAT(emp_mst.retirement_date,'%Y-%m-%d'))"), ">=", $cfrom_date)
    ->where(DB::raw("(DATE_FORMAT(emp_mst.retirement_date,'%Y-%m-%d'))"), "<=", $cto_date)
    ->where('emp_mst.active_type','=',$active_type)
    ->paginate(30);
  } else {
    $employee_list = DB::table('emp_mst')
    ->leftJoin('category','emp_mst.catg','=','category.category_code')
    ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
    ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
    ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','emp_mst.DOP','emp_mst.pan_no','emp_mst.current_basic','emp_mst.retirement_date','emp_mst.DOB','emp_mst.employee_code','emp_mst.active_type')
    ->where('emp_mst.emp_type','=','PE')
    ->paginate(30);
  }
  $data = [
    'employee_list'=>$employee_list
  ];
  return view('Frontend.retired-employees-detail-reports',$data);
}


public function emp_official_dtl_report(Request $request)
{
  $all_categories_data = DB::table('emp_mst')
      ->leftJoin('category','emp_mst.catg','=','category.category_code')
      ->select('emp_mst.catg')
      ->where('emp_mst.catg','!=',NULL)
      ->groupBy('emp_mst.catg')
      ->get();
      $employee_type = DB::table('emp_mst')
      ->select('emp_mst.emp_type')
      ->where('emp_mst.emp_type','!=',NULL)
      ->groupBy('emp_mst.emp_type')
      ->get();
      $get_categories = array();
      foreach($all_categories_data as $key => $val){
        $get_categories[] = DB::table('category')->where('category_code','=',$val->catg)->first();
      }
     
      if(count($_GET)==0){
        $category = NULL;
        $type = NULL;
      } else {
        if(isset($_GET['category'])){
          $category = $request->category;
        } else {
          $category ="";
        }
        if(isset($_GET['type'])){
          $type = $request->type;
        } else {
          $type ="";
        }
      }
  if(isset($_GET['active_type'])){
        $active_type=$request->active_type;
    } else {
        $active_type= "all";
    }     
if($category=="" && $type=="" && $active_type=="all"){
  $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
  ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','pay_grade_mst.pay_grade_code','pay_grade_mst.pay_scale','emp_mst.UAN','emp_mst.esi_ac_no','emp_mst.pan_no','emp_mst.bank_ac_no','emp_mst.employee_code','emp_mst.active_type','emp_mst.DOJ','emp_mst.DOB','emp_mst.confirm_date','emp_mst.retirement_date')
  ->paginate(30);
} else if($category=="all_cat" && $type=="all_type" && $active_type=="all"){
  $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
  ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','pay_grade_mst.pay_grade_code','pay_grade_mst.pay_scale','emp_mst.UAN','emp_mst.esi_ac_no','emp_mst.pan_no','emp_mst.bank_ac_no','emp_mst.employee_code','emp_mst.active_type','emp_mst.DOJ','emp_mst.DOB','emp_mst.confirm_date','emp_mst.retirement_date')
  ->paginate(30);
} else if($category!=="all_cat" && $type=="all_type" && $active_type=="all"){
  $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
  ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','pay_grade_mst.pay_grade_code','pay_grade_mst.pay_scale','emp_mst.UAN','emp_mst.esi_ac_no','emp_mst.pan_no','emp_mst.bank_ac_no','emp_mst.employee_code','emp_mst.active_type','emp_mst.DOJ','emp_mst.DOB','emp_mst.confirm_date','emp_mst.retirement_date')
  ->where('emp_mst.catg','=',$category)
  ->paginate(30);
} else if($category=="all_cat" && $type!=="all_type" && $active_type=="all"){
  $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
  ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','pay_grade_mst.pay_grade_code','pay_grade_mst.pay_scale','emp_mst.UAN','emp_mst.esi_ac_no','emp_mst.pan_no','emp_mst.bank_ac_no','emp_mst.employee_code','emp_mst.active_type','emp_mst.DOJ','emp_mst.DOB','emp_mst.confirm_date','emp_mst.retirement_date')
  ->where('emp_mst.emp_type','=',$type)
  ->paginate(30);
} else if($category=="all_cat" && $type=="all_type" && $active_type!=="all"){
  $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
  ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','pay_grade_mst.pay_grade_code','pay_grade_mst.pay_scale','emp_mst.UAN','emp_mst.esi_ac_no','emp_mst.pan_no','emp_mst.bank_ac_no','emp_mst.employee_code','emp_mst.active_type','emp_mst.DOJ','emp_mst.DOB','emp_mst.confirm_date','emp_mst.retirement_date')
  ->where('emp_mst.active_type','=',$active_type)
  ->paginate(30);
} else if($category=="all_cat" && $type!=="all_type" && $active_type!=="all"){
  $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
  ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','pay_grade_mst.pay_grade_code','pay_grade_mst.pay_scale','emp_mst.UAN','emp_mst.esi_ac_no','emp_mst.pan_no','emp_mst.bank_ac_no','emp_mst.employee_code','emp_mst.active_type','emp_mst.DOJ','emp_mst.DOB','emp_mst.confirm_date','emp_mst.retirement_date')
  ->where('emp_mst.emp_type','=',$type)
  ->where('emp_mst.active_type','=',$active_type)
  ->paginate(30);
} else if($category!=="all_cat" && $type!=="all_type" && $active_type!=="all"){
  $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
  ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','pay_grade_mst.pay_grade_code','pay_grade_mst.pay_scale','emp_mst.UAN','emp_mst.esi_ac_no','emp_mst.pan_no','emp_mst.bank_ac_no','emp_mst.employee_code','emp_mst.active_type','emp_mst.DOJ','emp_mst.DOB','emp_mst.confirm_date','emp_mst.retirement_date')
  ->where('emp_mst.catg','=',$category)
  ->where('emp_mst.emp_type','=',$type)
  ->where('emp_mst.active_type','=',$active_type)
  ->paginate(30);
} else if($category!=="all_cat" && $type!=="all_type" && $active_type=="all"){
  $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
  ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','pay_grade_mst.pay_grade_code','pay_grade_mst.pay_scale','emp_mst.UAN','emp_mst.esi_ac_no','emp_mst.pan_no','emp_mst.bank_ac_no','emp_mst.employee_code','emp_mst.active_type','emp_mst.DOJ','emp_mst.DOB','emp_mst.confirm_date','emp_mst.retirement_date')
  ->where('emp_mst.catg','=',$category)
  ->where('emp_mst.emp_type','=',$type)
  ->paginate(30);
} else if($category!=="all_cat" && $type=="all_type" && $active_type!=="all"){
  $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
  ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','pay_grade_mst.pay_grade_code','pay_grade_mst.pay_scale','emp_mst.UAN','emp_mst.esi_ac_no','emp_mst.pan_no','emp_mst.bank_ac_no','emp_mst.employee_code','emp_mst.active_type','emp_mst.DOJ','emp_mst.DOB','emp_mst.confirm_date','emp_mst.retirement_date')
  ->where('emp_mst.catg','=',$category)
  ->where('emp_mst.active_type','=',$active_type)
  ->paginate(30);
} else {
  $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
  ->select('emp_mst.catg','category.category_name','emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.dept_no','dept_master.dept_no','dept_master.dept_name','emp_mst.DOJ','pay_grade_mst.pay_grade_code','pay_grade_mst.pay_scale','emp_mst.UAN','emp_mst.esi_ac_no','emp_mst.pan_no','emp_mst.bank_ac_no','emp_mst.employee_code','emp_mst.active_type','emp_mst.DOJ','emp_mst.DOB','emp_mst.confirm_date','emp_mst.retirement_date')
  // ->where('emp_mst.emp_type','=',$type)
  // ->where('emp_mst.catg','=',$category)
  ->paginate(30);
}
  
      $data = [
        'categories'=>$get_categories,
        'employee_type'=>$employee_type,
        'employee_list'=>$employee_list
      ];
  return view('Frontend.employee-official-information-details-report',$data);
}

 
public function emp_personal_dtl_report(Request $request)
{
  $all_categories_data = DB::table('emp_mst')
      ->leftJoin('category','emp_mst.catg','=','category.category_code')
      ->select('emp_mst.catg')
      ->where('emp_mst.catg','!=',NULL)
      ->groupBy('emp_mst.catg')
      ->get();
      $employee_type = DB::table('emp_mst')
      ->select('emp_mst.emp_type')
      ->where('emp_mst.emp_type','!=',NULL)
      ->groupBy('emp_mst.emp_type')
      ->get();
      $get_categories = array();
      foreach($all_categories_data as $key => $val){
        $get_categories[] = DB::table('category')->where('category_code','=',$val->catg)->first();
      }
     
      if(count($_GET)==0){
        $category = NULL;
        $type = NULL;
      } else {
        if(isset($_GET['category'])){
          $category = $request->category;
        } else {
          $category ="";
        }
        if(isset($_GET['type'])){
          $type = $request->type;
        } else {
          $type ="";
        }
      }
    if(isset($_GET['active_type'])){
        $active_type=$request->active_type;
    } else {
        $active_type= "all";
    }       
if($category=="" && $type=="" && $active_type=="all"){
  $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
  ->select('emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.sex','emp_mst.spouse_name','emp_mst.father_name','emp_mst.mother_name','emp_mst.present_address1','emp_mst.present_address2','emp_mst.present_address3','emp_mst.PERM_ADDRESS1','emp_mst.PERM_ADDRESS2','emp_mst.PERM_ADDRESS3','emp_mst.ph_no','emp_mst.email','emp_mst.blood_group','emp_mst.marital_status','emp_mst.employee_code','emp_mst.active_type')
  ->paginate(30);
} else if($category=="all_cat" && $type=="all_type" && $active_type=="all"){
  $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
  ->select('emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.sex','emp_mst.spouse_name','emp_mst.father_name','emp_mst.mother_name','emp_mst.present_address1','emp_mst.present_address2','emp_mst.present_address3','emp_mst.PERM_ADDRESS1','emp_mst.PERM_ADDRESS2','emp_mst.PERM_ADDRESS3','emp_mst.ph_no','emp_mst.email','emp_mst.blood_group','emp_mst.marital_status','emp_mst.employee_code','emp_mst.active_type')
  ->paginate(30);
} else if($category!=="all_cat" && $type=="all_type" && $active_type=="all"){
  $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
  ->select('emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.sex','emp_mst.spouse_name','emp_mst.father_name','emp_mst.mother_name','emp_mst.present_address1','emp_mst.present_address2','emp_mst.present_address3','emp_mst.PERM_ADDRESS1','emp_mst.PERM_ADDRESS2','emp_mst.PERM_ADDRESS3','emp_mst.ph_no','emp_mst.email','emp_mst.blood_group','emp_mst.marital_status','emp_mst.employee_code','emp_mst.active_type')
  ->where('emp_mst.catg','=',$category)
  ->paginate(30);
} else if($category=="all_cat" && $type!=="all_type" && $active_type=="all"){
  $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
  ->select('emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.sex','emp_mst.spouse_name','emp_mst.father_name','emp_mst.mother_name','emp_mst.present_address1','emp_mst.present_address2','emp_mst.present_address3','emp_mst.PERM_ADDRESS1','emp_mst.PERM_ADDRESS2','emp_mst.PERM_ADDRESS3','emp_mst.ph_no','emp_mst.email','emp_mst.blood_group','emp_mst.marital_status','emp_mst.employee_code','emp_mst.active_type')
  ->where('emp_mst.emp_type','=',$type)
  ->paginate(30);
} else if($category=="all_cat" && $type=="all_type" && $active_type!=="all"){
  $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
  ->select('emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.sex','emp_mst.spouse_name','emp_mst.father_name','emp_mst.mother_name','emp_mst.present_address1','emp_mst.present_address2','emp_mst.present_address3','emp_mst.PERM_ADDRESS1','emp_mst.PERM_ADDRESS2','emp_mst.PERM_ADDRESS3','emp_mst.ph_no','emp_mst.email','emp_mst.blood_group','emp_mst.marital_status','emp_mst.employee_code','emp_mst.active_type')
  ->where('emp_mst.active_type','=',$active_type)
  ->paginate(30);
} else if($category=="all_cat" && $type!=="all_type" && $active_type!=="all"){
  $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
  ->select('emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.sex','emp_mst.spouse_name','emp_mst.father_name','emp_mst.mother_name','emp_mst.present_address1','emp_mst.present_address2','emp_mst.present_address3','emp_mst.PERM_ADDRESS1','emp_mst.PERM_ADDRESS2','emp_mst.PERM_ADDRESS3','emp_mst.ph_no','emp_mst.email','emp_mst.blood_group','emp_mst.marital_status','emp_mst.employee_code','emp_mst.active_type')
  ->where('emp_mst.emp_type','=',$type)
  ->where('emp_mst.active_type','=',$active_type)
  ->paginate(30);
} else if($category!=="all_cat" && $type!=="all_type" && $active_type!=="all"){
  $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
  ->select('emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.sex','emp_mst.spouse_name','emp_mst.father_name','emp_mst.mother_name','emp_mst.present_address1','emp_mst.present_address2','emp_mst.present_address3','emp_mst.PERM_ADDRESS1','emp_mst.PERM_ADDRESS2','emp_mst.PERM_ADDRESS3','emp_mst.ph_no','emp_mst.email','emp_mst.blood_group','emp_mst.marital_status','emp_mst.employee_code','emp_mst.active_type')
  ->where('emp_mst.catg','=',$category)
  ->where('emp_mst.emp_type','=',$type)
  ->where('emp_mst.active_type','=',$active_type)
  ->paginate(30);
} else if($category=="all_cat" && $type!=="all_type" && $active_type!=="all"){
  $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
  ->select('emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.sex','emp_mst.spouse_name','emp_mst.father_name','emp_mst.mother_name','emp_mst.present_address1','emp_mst.present_address2','emp_mst.present_address3','emp_mst.PERM_ADDRESS1','emp_mst.PERM_ADDRESS2','emp_mst.PERM_ADDRESS3','emp_mst.ph_no','emp_mst.email','emp_mst.blood_group','emp_mst.marital_status','emp_mst.employee_code','emp_mst.active_type')
  ->where('emp_mst.emp_type','=',$type)
  ->where('emp_mst.active_type','=',$active_type)
  ->paginate(30);
} else if($category!=="all_cat" && $type=="all_type" && $active_type!=="all"){
  $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
  ->select('emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.sex','emp_mst.spouse_name','emp_mst.father_name','emp_mst.mother_name','emp_mst.present_address1','emp_mst.present_address2','emp_mst.present_address3','emp_mst.PERM_ADDRESS1','emp_mst.PERM_ADDRESS2','emp_mst.PERM_ADDRESS3','emp_mst.ph_no','emp_mst.email','emp_mst.blood_group','emp_mst.marital_status','emp_mst.employee_code','emp_mst.active_type')
  ->where('emp_mst.catg','=',$category)
  ->where('emp_mst.active_type','=',$active_type)
  ->paginate(30);
} else if($category!=="all_cat" && $type!=="all_type" && $active_type=="all"){
  $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
  ->select('emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.sex','emp_mst.spouse_name','emp_mst.father_name','emp_mst.mother_name','emp_mst.present_address1','emp_mst.present_address2','emp_mst.present_address3','emp_mst.PERM_ADDRESS1','emp_mst.PERM_ADDRESS2','emp_mst.PERM_ADDRESS3','emp_mst.ph_no','emp_mst.email','emp_mst.blood_group','emp_mst.marital_status','emp_mst.employee_code','emp_mst.active_type')
  ->where('emp_mst.catg','=',$category)
  ->where('emp_mst.emp_type','=',$type)
  ->paginate(30);
} else {
  $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
  ->select('emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.sex','emp_mst.spouse_name','emp_mst.father_name','emp_mst.mother_name','emp_mst.present_address1','emp_mst.present_address2','emp_mst.present_address3','emp_mst.PERM_ADDRESS1','emp_mst.PERM_ADDRESS2','emp_mst.PERM_ADDRESS3','emp_mst.ph_no','emp_mst.email','emp_mst.blood_group','emp_mst.marital_status','emp_mst.employee_code','emp_mst.active_type')
  //->where('emp_mst.emp_type','=',$type)
  //->where('emp_mst.catg','=',$category)
  ->paginate(30);
}
     
      $data = [
        'categories'=>$get_categories,
        'employee_type'=>$employee_type,
        'employee_list'=>$employee_list
      ];
  return view('Frontend.employee-personal-information-details-report',$data);
}



public function emp_contract_renewal_report(Request $request)
  {
    $all_categories_data = DB::table('emp_mst')
    ->leftJoin('category','emp_mst.catg','=','category.category_code')
    ->select('emp_mst.catg')
    ->where('emp_mst.catg','!=',NULL)
    ->groupBy('emp_mst.catg')
    ->get();
    $get_categories = array();
    foreach($all_categories_data as $key => $val){
      $get_categories[] = DB::table('category')->where('category_code','=',$val->catg)->first();
    }
    if(count($_GET)==0){
      $category = NULL;
      $from_date = NULL;
      $to_date = NULL;
    } else {
      if(isset($_GET['category'])){
        $category = $request->category;
      } else {
        $category =NULL;
      }
      if(isset($_GET['from_date'])){
        $from_date = $request->from_date;
      } else {
        $from_date = NULL;
      }
      if(isset($_GET['to_date'])){
        $to_date = $request->to_date;
      } else {
        $to_date = NULL;
      }
    }
  if(isset($_GET['active_type'])){
      $active_type=$request->active_type;
  } else {
      $active_type= "all";
  } 
    if($category=="" && $from_date=="" && $to_date=="" && $active_type=="all"){
      $employee_list = DB::table('emp_contract_dtl')
      ->leftJoin('emp_mst','emp_contract_dtl.emp_no','=','emp_mst.emp_no')
      ->select('emp_contract_dtl.emp_no')
      ->groupBy('emp_contract_dtl.emp_no')
      ->paginate(30); 
    } elseif($category=="all_cat" &&  $active_type=="all" && $from_date!=="" && $to_date!=="") {
        $employee_list = DB::table('emp_contract_dtl')
        ->leftJoin('emp_mst','emp_contract_dtl.emp_no','=','emp_mst.emp_no')
        ->select('emp_contract_dtl.emp_no')
        ->groupBy('emp_contract_dtl.emp_no')
        ->where('emp_contract_dtl.cont_start_date', '>=', $from_date)
        ->where('emp_contract_dtl.cont_end_date', '<=', $to_date)
        ->paginate(30);
    } elseif($category!=="all_cat" &&  $active_type=="all" && $from_date!=="" && $to_date!=="") {
      $employee_list = DB::table('emp_contract_dtl')
      ->leftJoin('emp_mst','emp_contract_dtl.emp_no','=','emp_mst.emp_no')
      ->select('emp_contract_dtl.emp_no')
      ->groupBy('emp_contract_dtl.emp_no')
      ->where('emp_contract_dtl.cont_start_date', '>=', $from_date)
      ->where('emp_contract_dtl.cont_end_date', '<=', $to_date)
      ->where('emp_mst.catg','=',$category)
      ->paginate(30);
    } elseif($category!=="all_cat" &&  $active_type!=="all" && $from_date!=="" && $to_date!=="") {
      $employee_list = DB::table('emp_contract_dtl')
      ->leftJoin('emp_mst','emp_contract_dtl.emp_no','=','emp_mst.emp_no')
      ->select('emp_contract_dtl.emp_no')
      ->groupBy('emp_contract_dtl.emp_no')
      ->where('emp_contract_dtl.cont_start_date', '>=', $from_date)
      ->where('emp_contract_dtl.cont_end_date', '<=', $to_date)
      ->where('emp_mst.catg','=',$category)
      ->where('emp_mst.active_type','=',$active_type)
      ->paginate(30);
    } elseif($category=="all_cat" &&  $active_type!=="all" && $from_date!=="" && $to_date!=="") {
      $employee_list = DB::table('emp_contract_dtl')
      ->leftJoin('emp_mst','emp_contract_dtl.emp_no','=','emp_mst.emp_no')
      ->select('emp_contract_dtl.emp_no')
      ->groupBy('emp_contract_dtl.emp_no')
      ->where('emp_contract_dtl.cont_start_date', '>=', $from_date)
      ->where('emp_contract_dtl.cont_end_date', '<=', $to_date)
      ->where('emp_mst.active_type','=',$active_type)
      ->paginate(30);
    } elseif($category=="all_cat" &&  $active_type!=="all" && $from_date==$to_date) {
      $employee_list = DB::table('emp_contract_dtl')
      ->leftJoin('emp_mst','emp_contract_dtl.emp_no','=','emp_mst.emp_no')
      ->select('emp_contract_dtl.emp_no')
      ->groupBy('emp_contract_dtl.emp_no')
      ->where('emp_contract_dtl.cont_start_date','=', $from_date)
      ->where('emp_contract_dtl.cont_end_date','=', $to_date)
      ->where('emp_mst.active_type','=',$active_type)
      ->paginate(30);
    } elseif($category!=="all_cat" &&  $active_type=="all" && $from_date==$to_date) {
      $employee_list = DB::table('emp_contract_dtl')
      ->leftJoin('emp_mst','emp_contract_dtl.emp_no','=','emp_mst.emp_no')
      ->select('emp_contract_dtl.emp_no')
      ->groupBy('emp_contract_dtl.emp_no')
      ->orWhere('emp_contract_dtl.cont_start_date','=', $from_date)
      ->orWhere('emp_contract_dtl.cont_end_date','=', $to_date)
      ->where('emp_mst.catg','=',$category)
      ->paginate(30);
    } elseif($category!=="all_cat" &&  $active_type!=="all" && $from_date==$to_date) {
      $employee_list = DB::table('emp_contract_dtl')
      ->leftJoin('emp_mst','emp_contract_dtl.emp_no','=','emp_mst.emp_no')
      ->select('emp_contract_dtl.emp_no')
      ->groupBy('emp_contract_dtl.emp_no')
      ->where('emp_mst.catg','=',$category)
      ->where('emp_mst.active_type','=',$active_type)
      ->orWhere('emp_contract_dtl.cont_start_date','=', $from_date)
      ->orWhere('emp_contract_dtl.cont_end_date','=', $to_date)
      ->paginate(30);
    }elseif($category=="all_cat" &&  $active_type=="all" && $from_date==$to_date) {
      $employee_list = DB::table('emp_contract_dtl')
      ->leftJoin('emp_mst','emp_contract_dtl.emp_no','=','emp_mst.emp_no')
      ->select('emp_contract_dtl.emp_no')
      ->groupBy('emp_contract_dtl.emp_no')
      ->orWhere('emp_contract_dtl.cont_start_date','=', $from_date)
      ->orWhere('emp_contract_dtl.cont_end_date','=', $to_date)
      ->paginate(30);
    } else {
      $employee_list = DB::table('emp_contract_dtl')
      ->leftJoin('emp_mst','emp_contract_dtl.emp_no','=','emp_mst.emp_no')
      ->select('emp_contract_dtl.emp_no')
      ->groupBy('emp_contract_dtl.emp_no')
      ->paginate(30);
    }
    // $chekno = array(); 
    // $new_employee_list = array(); 
    // foreach ($employee_list as $key => $line ) { 
    //  if ( !in_array($line->emp_no, $chekno) ) { 
    //       $chekno[] = $line->emp_no; 
    //       $new_employee_list[] = $line; 
    //     } 
    // } 
     // ->whereBetween('emp_contract_dtl.cont_start_date', [new Carbon($from_date), new Carbon($to_date)])
        // ->whereBetween('emp_contract_dtl.cont_end_date', [new Carbon($from_date), new Carbon($to_date)])
  //  $datauser = ReportsController::paginate($new_employee_list);
    $data = [
      'categories'=>$get_categories,
      'employee_list'=>$employee_list
    ];
    return view('Frontend.employee-contract-renewal-details-report',$data);
  }


  public function emp_data_dtl_report(Request $request)
  {
    $all_categories_data = DB::table('emp_mst')
    ->leftJoin('category','emp_mst.catg','=','category.category_code')
    ->select('emp_mst.catg')
    ->where('emp_mst.catg','!=',NULL)
    ->groupBy('emp_mst.catg')
    ->get();
    $employee_type = DB::table('emp_mst')
    ->select('emp_mst.emp_type')
    ->where('emp_mst.emp_type','!=',NULL)
    ->groupBy('emp_mst.emp_type')
    ->get();
    $get_categories = array();
    foreach($all_categories_data as $key => $val){
      $get_categories[] = DB::table('category')->where('category_code','=',$val->catg)->first();
    }
   
    if(count($_GET)==0){
      $category = NULL;
      $type = NULL;
    } else {
      if(isset($_GET['category'])){
        $category = $request->category;
      } else {
        $category =NULL;
      }
      if(isset($_GET['type'])){
        $type = $request->type;
      } else {
        $type =NULL;
      }
    }
    if(isset($_GET['active_type'])){
      $active_type= $request->active_type;
  } else {
      $active_type= "all";
  } 
if($category=="" && $type=="" && $active_type=="all"){
$employee_list = DB::table('emp_mst')
->leftJoin('category','emp_mst.catg','=','category.category_code')
->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
->select('emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.sex','emp_mst.spouse_name','emp_mst.father_name','emp_mst.mother_name','emp_mst.present_address1','emp_mst.present_address2','emp_mst.present_address3','emp_mst.PERM_ADDRESS1','emp_mst.PERM_ADDRESS2','emp_mst.PERM_ADDRESS3','emp_mst.ph_no','emp_mst.email','emp_mst.blood_group','emp_mst.marital_status','dept_master.dept_name','emp_mst.DOJ','emp_mst.DOB','emp_mst.emp_type','category.category_name','emp_mst.DOC','emp_mst.retirement_date','emp_mst.employee_code','emp_mst.active_type','emp_mst.confirm_date') 
 ->paginate(30);
} else if($category=="all_cat" && $type=="all_type" && $active_type=="all"){
$employee_list = DB::table('emp_mst')
->leftJoin('category','emp_mst.catg','=','category.category_code')
->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
->select('emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.sex','emp_mst.spouse_name','emp_mst.father_name','emp_mst.mother_name','emp_mst.present_address1','emp_mst.present_address2','emp_mst.present_address3','emp_mst.PERM_ADDRESS1','emp_mst.PERM_ADDRESS2','emp_mst.PERM_ADDRESS3','emp_mst.ph_no','emp_mst.email','emp_mst.blood_group','emp_mst.marital_status','dept_master.dept_name','emp_mst.DOJ','emp_mst.DOB','emp_mst.emp_type','category.category_name','emp_mst.DOC','emp_mst.retirement_date','emp_mst.employee_code','emp_mst.active_type','emp_mst.confirm_date')
 ->paginate(30);
} else if($category!=="all_cat" && $type=="all_type" && $active_type=="all"){
$employee_list = DB::table('emp_mst')
->leftJoin('category','emp_mst.catg','=','category.category_code')
->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
->select('emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.sex','emp_mst.spouse_name','emp_mst.father_name','emp_mst.mother_name','emp_mst.present_address1','emp_mst.present_address2','emp_mst.present_address3','emp_mst.PERM_ADDRESS1','emp_mst.PERM_ADDRESS2','emp_mst.PERM_ADDRESS3','emp_mst.ph_no','emp_mst.email','emp_mst.blood_group','emp_mst.marital_status','dept_master.dept_name','emp_mst.DOJ','emp_mst.DOB','emp_mst.emp_type','category.category_name','emp_mst.DOC','emp_mst.retirement_date','emp_mst.employee_code','emp_mst.active_type','emp_mst.confirm_date')
->where('emp_mst.catg','=',$category)
 ->paginate(30);
} else if($category=="all_cat" && $type!=="all_type" && $active_type=="all"){
$employee_list = DB::table('emp_mst')
->leftJoin('category','emp_mst.catg','=','category.category_code')
->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
->select('emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.sex','emp_mst.spouse_name','emp_mst.father_name','emp_mst.mother_name','emp_mst.present_address1','emp_mst.present_address2','emp_mst.present_address3','emp_mst.PERM_ADDRESS1','emp_mst.PERM_ADDRESS2','emp_mst.PERM_ADDRESS3','emp_mst.ph_no','emp_mst.email','emp_mst.blood_group','emp_mst.marital_status','dept_master.dept_name','emp_mst.DOJ','emp_mst.DOB','emp_mst.emp_type','category.category_name','emp_mst.DOC','emp_mst.retirement_date','emp_mst.employee_code','emp_mst.active_type','emp_mst.confirm_date')
->where('emp_mst.emp_type','=',$type)
 ->paginate(30);
} else if($category=="all_cat" && $type=="all_type" && $active_type!=="all"){
  $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->select('emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.sex','emp_mst.spouse_name','emp_mst.father_name','emp_mst.mother_name','emp_mst.present_address1','emp_mst.present_address2','emp_mst.present_address3','emp_mst.PERM_ADDRESS1','emp_mst.PERM_ADDRESS2','emp_mst.PERM_ADDRESS3','emp_mst.ph_no','emp_mst.email','emp_mst.blood_group','emp_mst.marital_status','dept_master.dept_name','emp_mst.DOJ','emp_mst.DOB','emp_mst.emp_type','category.category_name','emp_mst.DOC','emp_mst.retirement_date','emp_mst.employee_code','emp_mst.active_type','emp_mst.confirm_date')
  ->where('emp_mst.active_type','=',$active_type)
   ->paginate(30);
} else if($category=="all_cat" && $type!=="all_type" && $active_type!=="all"){
  $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->select('emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.sex','emp_mst.spouse_name','emp_mst.father_name','emp_mst.mother_name','emp_mst.present_address1','emp_mst.present_address2','emp_mst.present_address3','emp_mst.PERM_ADDRESS1','emp_mst.PERM_ADDRESS2','emp_mst.PERM_ADDRESS3','emp_mst.ph_no','emp_mst.email','emp_mst.blood_group','emp_mst.marital_status','dept_master.dept_name','emp_mst.DOJ','emp_mst.DOB','emp_mst.emp_type','category.category_name','emp_mst.DOC','emp_mst.retirement_date','emp_mst.employee_code','emp_mst.active_type','emp_mst.confirm_date')
  ->where('emp_mst.emp_type','=',$type)
  ->where('emp_mst.active_type','=',$active_type)
   ->paginate(30);
} else if($category!=="all_cat" && $type!=="all_type" && $active_type!=="all"){
  $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->select('emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.sex','emp_mst.spouse_name','emp_mst.father_name','emp_mst.mother_name','emp_mst.present_address1','emp_mst.present_address2','emp_mst.present_address3','emp_mst.PERM_ADDRESS1','emp_mst.PERM_ADDRESS2','emp_mst.PERM_ADDRESS3','emp_mst.ph_no','emp_mst.email','emp_mst.blood_group','emp_mst.marital_status','dept_master.dept_name','emp_mst.DOJ','emp_mst.DOB','emp_mst.emp_type','category.category_name','emp_mst.DOC','emp_mst.retirement_date','emp_mst.employee_code','emp_mst.active_type','emp_mst.confirm_date')
  ->where('emp_mst.catg','=',$category)
  ->where('emp_mst.emp_type','=',$type)
  ->where('emp_mst.active_type','=',$active_type)
  ->paginate(30);
} else if($category!=="all_cat" && $type!=="all_type" && $active_type=="all"){
  $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->select('emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.sex','emp_mst.spouse_name','emp_mst.father_name','emp_mst.mother_name','emp_mst.present_address1','emp_mst.present_address2','emp_mst.present_address3','emp_mst.PERM_ADDRESS1','emp_mst.PERM_ADDRESS2','emp_mst.PERM_ADDRESS3','emp_mst.ph_no','emp_mst.email','emp_mst.blood_group','emp_mst.marital_status','dept_master.dept_name','emp_mst.DOJ','emp_mst.DOB','emp_mst.emp_type','category.category_name','emp_mst.DOC','emp_mst.retirement_date','emp_mst.employee_code','emp_mst.active_type','emp_mst.confirm_date')
  ->where('emp_mst.catg','=',$category)
  ->where('emp_mst.emp_type','=',$type)
  ->paginate(30);
} else if($category!=="all_cat" && $type=="all_type" && $active_type!=="all"){
  $employee_list = DB::table('emp_mst')
  ->leftJoin('category','emp_mst.catg','=','category.category_code')
  ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
  ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
  ->select('emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.sex','emp_mst.spouse_name','emp_mst.father_name','emp_mst.mother_name','emp_mst.present_address1','emp_mst.present_address2','emp_mst.present_address3','emp_mst.PERM_ADDRESS1','emp_mst.PERM_ADDRESS2','emp_mst.PERM_ADDRESS3','emp_mst.ph_no','emp_mst.email','emp_mst.blood_group','emp_mst.marital_status','dept_master.dept_name','emp_mst.DOJ','emp_mst.DOB','emp_mst.emp_type','category.category_name','emp_mst.DOC','emp_mst.retirement_date','emp_mst.employee_code','emp_mst.active_type','emp_mst.confirm_date')
  ->where('emp_mst.catg','=',$category)
  ->where('emp_mst.active_type','=',$active_type)
  ->paginate(30);
} else {
$employee_list = DB::table('emp_mst')
->leftJoin('category','emp_mst.catg','=','category.category_code')
->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
->select('emp_mst.emp_no','emp_mst.emp_name','emp_mst.desg_code','desg_mst.desg_code','desg_mst.desg_name','emp_mst.sex','emp_mst.spouse_name','emp_mst.father_name','emp_mst.mother_name','emp_mst.present_address1','emp_mst.present_address2','emp_mst.present_address3','emp_mst.PERM_ADDRESS1','emp_mst.PERM_ADDRESS2','emp_mst.PERM_ADDRESS3','emp_mst.ph_no','emp_mst.email','emp_mst.blood_group','emp_mst.marital_status','dept_master.dept_name','emp_mst.DOJ','emp_mst.DOB','emp_mst.emp_type','category.category_name','emp_mst.DOC','emp_mst.retirement_date','emp_mst.employee_code','emp_mst.active_type','emp_mst.confirm_date')
//->where('emp_mst.emp_type','=',$type)
//->where('emp_mst.catg','=',$category)
 ->paginate(30);
}

    $data = [
      'categories'=>$get_categories,
      'employee_type'=>$employee_type,
      'employee_list'=>$employee_list
    ];
    return view('Frontend.employee-master-data-report',$data);
  }
 

  public function emp_qualification_experience_dtl_report(Request $request){
    $all_categories_data = DB::table('emp_mst')
    ->leftJoin('category','emp_mst.catg','=','category.category_code')
    ->select('emp_mst.catg')
    ->where('emp_mst.catg','!=',NULL)
    ->groupBy('emp_mst.catg')
    ->get();
    $employee_type = DB::table('emp_mst')
    ->select('emp_mst.emp_type')
    ->where('emp_mst.emp_type','!=',NULL)
    ->groupBy('emp_mst.emp_type')
    ->get();
    $get_categories = array();
    foreach($all_categories_data as $key => $val){
      $get_categories[] = DB::table('category')->where('category_code','=',$val->catg)->first();
    }
   
    if(count($_GET)==0){
      $category = NULL;
      $type = NULL;
    } else {
      if(isset($_GET['category'])){
        $category = $request->category;
      } else {
        $category =NULL;
      }
      if(isset($_GET['type'])){
        $type = $request->type;
      } else {
        $type =NULL;
      }
    }
  if(isset($_GET['active_type'])){
      $active_type= $request->active_type;
  } else {
      $active_type= "all";
  } 
    if($category=="" && $type=="" && $active_type=="all"){
      $employee_list = DB::table('emp_mst')
    ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
    ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
    ->select('emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','desg_mst.desg_name','dept_master.dept_name','emp_mst.employee_code','emp_mst.active_type')
    ->paginate(30);
    } else if($category=="all_cat" && $type=="all_type" && $active_type=="all"){
      $employee_list = DB::table('emp_mst')
    ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
    ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
    ->select('emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','desg_mst.desg_name','dept_master.dept_name','emp_mst.employee_code','emp_mst.active_type')
    ->paginate(30);
    } else if($category!=="all_cat" && $type=="all_type" && $active_type=="all"){
      $employee_list = DB::table('emp_mst')
    ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
    ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
    ->select('emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','desg_mst.desg_name','dept_master.dept_name','emp_mst.employee_code','emp_mst.active_type')
    ->where('emp_mst.emp_type','=',$type)
    ->where('emp_mst.catg','=',$category)
    ->paginate(30);
    } else if($category=="all_cat" && $type!=="all_type" && $active_type=="all"){
      $employee_list = DB::table('emp_mst')
    ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
    ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
    ->select('emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','desg_mst.desg_name','dept_master.dept_name','emp_mst.employee_code','emp_mst.active_type')
    ->where('emp_mst.emp_type','=',$type)
    ->paginate(30);
    } else if($category=="all_cat" && $type=="all_type" && $active_type!=="all"){
      $employee_list = DB::table('emp_mst')
    ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
    ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
    ->select('emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','desg_mst.desg_name','dept_master.dept_name','emp_mst.employee_code','emp_mst.active_type')
    ->where('emp_mst.active_type','=',$active_type)
    ->paginate(30);
    } else if($category=="all_cat" && $type!=="all_type" && $active_type!=="all"){
      $employee_list = DB::table('emp_mst')
    ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
    ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
    ->select('emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','desg_mst.desg_name','dept_master.dept_name','emp_mst.employee_code','emp_mst.active_type')
    ->where('emp_mst.active_type','=',$active_type)
    ->where('emp_mst.emp_type','=',$type)
    ->paginate(30);
    } else if($category!=="all_cat" && $type!=="all_type" && $active_type!=="all"){
      $employee_list = DB::table('emp_mst')
    ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
    ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
    ->select('emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','desg_mst.desg_name','dept_master.dept_name','emp_mst.employee_code','emp_mst.active_type')
    ->where('emp_mst.catg','=',$category)
    ->where('emp_mst.active_type','=',$active_type)
    ->where('emp_mst.emp_type','=',$type)
    ->paginate(30);
    } else if($category!=="all_cat" && $type!=="all_type" && $active_type=="all"){
      $employee_list = DB::table('emp_mst')
    ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
    ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
    ->select('emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','desg_mst.desg_name','dept_master.dept_name','emp_mst.employee_code','emp_mst.active_type')
    ->where('emp_mst.catg','=',$category)
    ->where('emp_mst.emp_type','=',$type)
    ->paginate(30);
    } else if($category!=="all_cat" && $type=="all_type" && $active_type!=="all"){
      $employee_list = DB::table('emp_mst')
    ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
    ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
    ->select('emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','desg_mst.desg_name','dept_master.dept_name','emp_mst.employee_code','emp_mst.active_type')
    ->where('emp_mst.catg','=',$category)
    ->where('emp_mst.active_type','=',$active_type)
    ->paginate(30);
    }  else { 
      $employee_list = DB::table('emp_mst')
    ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
    ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
    ->select('emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','desg_mst.desg_name','dept_master.dept_name','emp_mst.employee_code','emp_mst.active_type')
    ->where('emp_mst.emp_type','=',$type)
    ->where('emp_mst.catg','=',$category)
    ->paginate(30);
    }
    $data = [ 
      'categories'=>$get_categories,
      'employee_type'=>$employee_type,
      'employee_list'=>$employee_list,
    ];
    return view('Frontend.employee-qualification-experience-details-report',$data);
  }
 

  public function paginate($items, $perPage = 20, $page = null)
  {
      $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
      $total = count($items);
      $currentpage = $page;
      $offset = ($currentpage * $perPage) - $perPage ;
      $itemstoshow = array_slice($items , $offset , $perPage);
      return new LengthAwarePaginator($itemstoshow ,$total   ,$perPage);
  }
 
 
  





  public function emp_service_pay_dtl_report(Request $request){ 
    $all_categories_data = DB::table('emp_mst')
    ->leftJoin('category','emp_mst.catg','=','category.category_code')
    ->select('emp_mst.catg')
    ->where('emp_mst.catg','!=',NULL)
    ->groupBy('emp_mst.catg')
    ->get();
    $employee_type = DB::table('emp_mst')
    ->select('emp_mst.emp_type')
    ->where('emp_mst.emp_type','!=',NULL)
    ->groupBy('emp_mst.emp_type')
    ->get();
    $get_categories = array();
    foreach($all_categories_data as $key => $val){
      $get_categories[] = DB::table('category')->where('category_code','=',$val->catg)->first();
    } 
    if(isset($_GET['category'])){
      $category= $request->category;
      } else {
          $category= "";
      }
  if(isset($_GET['type'])){
          $type= $request->type;
      } else {
          $type= "";
      }
  if(isset($_GET['active_type'])){
          $active_type= $request->active_type;
      } else {
          $active_type= "all";
      }
  if(isset($_GET['to'])){
      $to= $request->to;
  } else {
      $to= "";
  }
  if(isset($_GET['from'])){
      $from = $request->from;
  } else {
      $from = "";
  }

  if($category=="" && $type=="" && $active_type=="all" && $from=="" && $to==""){
    $employee_list = DB::table('emp_mst')
    ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
    ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
    ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
    ->select('emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','desg_mst.desg_name','dept_master.dept_name','emp_mst.employee_code','pay_grade_mst.pay_grade_code','pay_grade_mst.pay_scale','emp_mst.DOB','emp_mst.DOJ','emp_mst.DOC','emp_mst.active_type','emp_mst.confirm_date')
    ->paginate(30);
  }elseif($category=="all_cat" && $type=="all_type" && $active_type=="all" && $from!=="" && $to!==""){
    $employee_list = DB::table('emp_mst')
    ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
    ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
    ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
    ->select('emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','desg_mst.desg_name','dept_master.dept_name','emp_mst.employee_code','pay_grade_mst.pay_grade_code','pay_grade_mst.pay_scale','emp_mst.DOB','emp_mst.DOJ','emp_mst.DOC','emp_mst.active_type','emp_mst.confirm_date')
    ->where(DB::raw("(DATE_FORMAT(emp_mst.DOJ,'%Y-%m-%d'))"), ">=", $from)
    ->where(DB::raw("(DATE_FORMAT(emp_mst.DOJ,'%Y-%m-%d'))"), "<=", $to)
    ->paginate(30);
  }elseif($category!=="all_cat" && $type=="all_type" && $active_type=="all" && $from!=="" && $to!==""){
    $employee_list = DB::table('emp_mst')
    ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
    ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
    ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
    ->select('emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','desg_mst.desg_name','dept_master.dept_name','emp_mst.employee_code','pay_grade_mst.pay_grade_code','pay_grade_mst.pay_scale','emp_mst.DOB','emp_mst.DOJ','emp_mst.DOC','emp_mst.active_type','emp_mst.confirm_date')
    ->where('emp_mst.catg','=',$category)
    ->where(DB::raw("(DATE_FORMAT(emp_mst.DOJ,'%Y-%m-%d'))"), ">=", $from)
    ->where(DB::raw("(DATE_FORMAT(emp_mst.DOJ,'%Y-%m-%d'))"), "<=", $to)
    ->paginate(30);
  }elseif($category!=="all_cat" && $type!=="all_type" && $active_type=="all" && $from!=="" && $to!==""){
    $employee_list = DB::table('emp_mst')
    ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
    ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
    ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
    ->select('emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','desg_mst.desg_name','dept_master.dept_name','emp_mst.employee_code','pay_grade_mst.pay_grade_code','pay_grade_mst.pay_scale','emp_mst.DOB','emp_mst.DOJ','emp_mst.DOC','emp_mst.active_type','emp_mst.confirm_date')
    ->where('emp_mst.emp_type','=',$type)
    ->where('emp_mst.catg','=',$category)
    ->where(DB::raw("(DATE_FORMAT(emp_mst.DOJ,'%Y-%m-%d'))"), ">=", $from)
    ->where(DB::raw("(DATE_FORMAT(emp_mst.DOJ,'%Y-%m-%d'))"), "<=", $to)
    ->paginate(30);
  }elseif($category!=="all_cat" && $type!=="all_type" && $active_type!=="all" && $from!=="" && $to!==""){
    $employee_list = DB::table('emp_mst')
    ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
    ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
    ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
    ->select('emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','desg_mst.desg_name','dept_master.dept_name','emp_mst.employee_code','pay_grade_mst.pay_grade_code','pay_grade_mst.pay_scale','emp_mst.DOB','emp_mst.DOJ','emp_mst.DOC','emp_mst.active_type','emp_mst.confirm_date')
    ->where('emp_mst.emp_type','=',$type)
    ->where('emp_mst.catg','=',$category)
    ->where('emp_mst.active_type','=',$active_type)
    ->where(DB::raw("(DATE_FORMAT(emp_mst.DOJ,'%Y-%m-%d'))"), ">=", $from)
    ->where(DB::raw("(DATE_FORMAT(emp_mst.DOJ,'%Y-%m-%d'))"), "<=", $to)
    ->paginate(30);
  }elseif($category=="all_cat" && $type!=="all_type" && $active_type!=="all" && $from!=="" && $to!==""){
    $employee_list = DB::table('emp_mst')
    ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
    ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
    ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
    ->select('emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','desg_mst.desg_name','dept_master.dept_name','emp_mst.employee_code','pay_grade_mst.pay_grade_code','pay_grade_mst.pay_scale','emp_mst.DOB','emp_mst.DOJ','emp_mst.DOC','emp_mst.active_type','emp_mst.confirm_date')
    ->where('emp_mst.emp_type','=',$type)
    ->where('emp_mst.active_type','=',$active_type)
    ->where(DB::raw("(DATE_FORMAT(emp_mst.DOJ,'%Y-%m-%d'))"), ">=", $from)
    ->where(DB::raw("(DATE_FORMAT(emp_mst.DOJ,'%Y-%m-%d'))"), "<=", $to)
    ->paginate(30);
  }elseif($category=="all_cat" && $type=="all_type" && $active_type!=="all" && $from!=="" && $to!==""){
    $employee_list = DB::table('emp_mst')
    ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
    ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
    ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
    ->select('emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','desg_mst.desg_name','dept_master.dept_name','emp_mst.employee_code','pay_grade_mst.pay_grade_code','pay_grade_mst.pay_scale','emp_mst.DOB','emp_mst.DOJ','emp_mst.DOC','emp_mst.active_type','emp_mst.confirm_date')
    ->where('emp_mst.active_type','=',$active_type)
    ->where(DB::raw("(DATE_FORMAT(emp_mst.DOJ,'%Y-%m-%d'))"), ">=", $from)
    ->where(DB::raw("(DATE_FORMAT(emp_mst.DOJ,'%Y-%m-%d'))"), "<=", $to)
    ->paginate(30);
  }elseif($category=="all_cat" && $type!=="all_type" && $active_type=="all" && $from!=="" && $to!==""){
    $employee_list = DB::table('emp_mst')
    ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
    ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
    ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
    ->select('emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','desg_mst.desg_name','dept_master.dept_name','emp_mst.employee_code','pay_grade_mst.pay_grade_code','pay_grade_mst.pay_scale','emp_mst.DOB','emp_mst.DOJ','emp_mst.DOC','emp_mst.active_type','emp_mst.confirm_date')
    ->where('emp_mst.emp_type','=',$type)
    ->where(DB::raw("(DATE_FORMAT(emp_mst.DOJ,'%Y-%m-%d'))"), ">=", $from)
    ->where(DB::raw("(DATE_FORMAT(emp_mst.DOJ,'%Y-%m-%d'))"), "<=", $to)
    ->paginate(30);
  }elseif($category!=="all_cat" && $type=="all_type" && $active_type!=="all" && $from!=="" && $to!==""){
    $employee_list = DB::table('emp_mst')
    ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
    ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
    ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
    ->select('emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','desg_mst.desg_name','dept_master.dept_name','emp_mst.employee_code','pay_grade_mst.pay_grade_code','pay_grade_mst.pay_scale','emp_mst.DOB','emp_mst.DOJ','emp_mst.DOC','emp_mst.active_type','emp_mst.confirm_date')
    ->where('emp_mst.catg','=',$category)
    ->where('emp_mst.active_type','=',$active_type)
    ->where(DB::raw("(DATE_FORMAT(emp_mst.DOJ,'%Y-%m-%d'))"), ">=", $from)
    ->where(DB::raw("(DATE_FORMAT(emp_mst.DOJ,'%Y-%m-%d'))"), "<=", $to)
    ->paginate(30);
  }else{
    $employee_list = DB::table('emp_mst')
    ->leftJoin('desg_mst','emp_mst.desg_code','=','desg_mst.desg_code')
    ->leftJoin('dept_master','emp_mst.dept_no','=','dept_master.dept_no')
    ->leftJoin('pay_grade_mst','emp_mst.grade_code','=','pay_grade_mst.pay_grade_code')
    ->select('emp_mst.emp_type','emp_mst.emp_no','emp_mst.emp_name','desg_mst.desg_name','dept_master.dept_name','emp_mst.employee_code','pay_grade_mst.pay_grade_code','pay_grade_mst.pay_scale','emp_mst.DOB','emp_mst.DOJ','emp_mst.DOC','emp_mst.active_type','emp_mst.confirm_date')
    ->paginate(30);
  }
    $data = [
      'categories'=>$get_categories,
      'employee_type'=>$employee_type,
      'employee_list'=>$employee_list
    ];
  return view('Frontend.employee-yr-of-service-qualification-pay-grade-details',$data);
  }

  public function daily_processing_data(Request $request){
    $allData = [];
    if ($request->department_from != NULL && $request->department_to != NULL && $request->employee_from != NULL && $request->employee_to != NULL) {
      $departmentEmployee = Attendance::select('emp_no')->whereBetween('punching_date', [$request->from_date, $request->to_date])->whereBetween('dept_no', [$request->department_from, $request->department_to])->groupBy('emp_no')->get();
      $allData = $departmentEmployee;

    } else if ($request->employee_from != NULL && $request->employee_to != NULL) {
      $attendanceEmployee = Attendance::select('emp_no')->whereBetween('emp_no', [$request->employee_from, $request->employee_to])->whereBetween('punching_date', [$request->from_date, $request->to_date])->groupBy('emp_no')->get();
      $allData = $attendanceEmployee;

    } else if ($request->department_from != NULL && $request->department_to != NULL) {
      $department = Attendance::select('emp_no')->whereBetween('punching_date', [$request->from_date, $request->to_date])->whereBetween('dept_no', [$request->department_from, $request->department_to])->groupBy('emp_no')->get();
      $allData = $department;

    } else  {
      $attendanceData = Attendance::select('emp_no')->whereBetween('punching_date', [$request->from_date, $request->to_date])->groupBy('emp_no')->get();
      $allData = $attendanceData;
    }
    $dailyProcessing = [];
    foreach ($allData as $ky => $value) {
      $attendancePunchingDate = Attendance::whereBetween('punching_date', [$request->from_date, $request->to_date])->groupBy('punching_date')->get();
      foreach ($attendancePunchingDate as $key => $val) {
        $month = date('m', strtotime($val->punching_date));
        $year  = date('Y', strtotime($val->punching_date));
        $day   = date('d', strtotime($val->punching_date));
        $monthlyShiftGenerate = MonthlyShiftGenerate::where(['empcode' => $value->emp_no, 'month' => $month, 'year' => $year])->get();
        $attendance  = Attendance::where(['emp_no' => $value->emp_no, 'punching_date' => $val->punching_date])->get();
        if (count($monthlyShiftGenerate) == 1) {
          $d_date        = 'd'.$day;
          $shiftDate     = $monthlyShiftGenerate[0]->$d_date;
          $shift         = Shift::where(['Scode' => $shiftDate])->first();
          if ($shift) {
            if(count($attendance) > 0) {
              if (count($attendance) % 2 === 0) {
                $outtime  = $attendance[count($attendance) - 1]->punching_log;
                
                $time1         = new DateTime($shift->outtime);
                $time2         = new DateTime($outtime);
                $interval      = $time1->diff($time2);
                $diffInSeconds = $interval->s + $interval->i * 60 + $interval->h * 3600;
                $hours         = floor($diffInSeconds / 3600);
                $minutes       = floor(($diffInSeconds % 3600) / 60);
                $seconds       = $diffInSeconds % 60;
                $overhrsdata   = "$hours:$minutes:$seconds";
                if($overhrsdata < "0:15:00") {
                  $overhrs = "00";
                } else {
                  $overhrs = "$hours:$minutes:$seconds";
                }
              } else {
                $outtime = "00";
                $overhrs = "00";
              }
              if ($attendance[0]->punching_log < $shift->InTime) {
                $time1         = new DateTime($shift->InTime);
                $time2         = new DateTime($attendance[0]->punching_log);
                $interval      = $time1->diff($time2);
                $diffInSeconds = $interval->s + $interval->i * 60 + $interval->h * 3600;
                $hours         = floor($diffInSeconds / 3600);
                $minutes       = floor(($diffInSeconds % 3600) / 60);
                $seconds       = $diffInSeconds % 60;
                $earlhrs       = "$hours:$minutes:$seconds";
                $remark        = "Elr";
              } else  {
                $earlhrs = "00";
                $remark  = "";
              }
              $punchingLogs = [];
              foreach ($attendance as $key => $item) {
                if ($key % 2 === 0) {
                  $punchingLogs[] = "intime-$item->punching_log";
                } else {
                  $punchingLogs[] = "outtime-$item->punching_log";
                }
              }

              $outtimeData   = new DateTime($attendance[count($attendance) - 1]->punching_log);
              $intime        = new DateTime($attendance[0]->punching_log);
              $intervaldata  = $outtimeData->diff($intime);
              $diffSeconds   = $intervaldata->s + $intervaldata->i * 60 + $intervaldata->h * 3600;
              $hoursData     = floor($diffSeconds / 3600);
              $minutesData   = floor(($diffSeconds % 3600) / 60);
              $secondsData   = $diffSeconds % 60;
              $earlhrsData   = "$hoursData:$minutesData:$secondsData";

              $jsonPunchingLogs = json_encode($punchingLogs);

              $dailyProcessing[] = [
                'emp_no'        => $value->emp_no,
                'emp_name'      => Emp_mst_live::where('EMP_NO', $value->emp_no)->first()->EMP_NAME,
                'dept_name'     => Department_master::where('DEPT_NO', Emp_mst_live::where('EMP_NO', $value->emp_no)->first()->DEPT_NO)->first()->DEPT_NAME,
                'punching_date' => $val->punching_date,
                'shift'         => $shift->Scode,
                'in_time'       => $attendance[0]->punching_log,
                'punching_log'  => $jsonPunchingLogs,
                'out_time'      => $outtime,
                'wrkhrs'        => $earlhrsData,
                'earlhrs'       => $earlhrs,
                'overtime'      => $overhrs,
                'status'        => "PP",
                'remark'        => $remark,
                'IRR'           => "",
              ];
            } else {
              $dailyProcessing[] = [
                'emp_no'        => $value->emp_no,
                'emp_name'      => Emp_mst_live::where('EMP_NO', $value->emp_no)->first()->EMP_NAME,
                'dept_name'     => Department_master::where('DEPT_NO', Emp_mst_live::where('EMP_NO', $value->emp_no)->first()->DEPT_NO)->first()->DEPT_NAME,
                'punching_date' => $val->punching_date,
                'shift'         => $shift->Scode,
                'in_time'       => "00",
                'punching_log'  => "00",
                'out_time'      => "00",
                'wrkhrs'        => "00",
                'earlhrs'       => "00",
                'overtime'      => "00",
                'status'        => "AA",
                'remark'        => "00",
                'IRR'           => "",
              ];
            }            
          } else {
            $separated = explode('/', $shiftDate);
            $shift     = Shift::where(['Scode' => $separated[1]])->first();
            if(count($attendance) > 0) {
              if (count($attendance) % 2 === 0) {
                $outtime = $attendance[count($attendance) - 1]->punching_log;

                $time1         = new DateTime($shift->outtime);
                $time2         = new DateTime($outtime);
                $interval      = $time1->diff($time2);
                $diffInSeconds = $interval->s + $interval->i * 60 + $interval->h * 3600;
                $hours         = floor($diffInSeconds / 3600);
                $minutes       = floor(($diffInSeconds % 3600) / 60);
                $seconds       = $diffInSeconds % 60;
                $overhrsdata   = "$hours:$minutes:$seconds";
                if($overhrsdata < "0:15:00") {
                  $overhrs = "00";
                } else {
                  $overhrs = "$hours:$minutes:$seconds";
                }
              } else {
                $outtime = "00";
                $overhrs = "00";
              }
              if ($attendance[0]->punching_log < $shift->InTime) {
                $time1         = new DateTime($shift->InTime);
                $time2         = new DateTime($attendance[0]->punching_log);
                $interval      = $time1->diff($time2);
                $diffInSeconds = $interval->s + $interval->i * 60 + $interval->h * 3600;
                $hours         = floor($diffInSeconds / 3600);
                $minutes       = floor(($diffInSeconds % 3600) / 60);
                $seconds       = $diffInSeconds % 60;
                $earlhrs       = "$hours:$minutes:$seconds";
              } else  {
                $earlhrs = "00";
              }
              $punchingLogs = [];
              foreach ($attendance as $key => $item) {
                if ($key % 2 === 0) {
                  $punchingLogs[] = "intime-$item->punching_log";
                } else {
                  $punchingLogs[] = "outtime-$item->punching_log";
                }
              }

              $outtimeData   = new DateTime($attendance[count($attendance) - 1]->punching_log);
              $intime        = new DateTime($attendance[0]->punching_log);
              $intervaldata  = $outtimeData->diff($intime);
              $diffSeconds   = $intervaldata->s + $intervaldata->i * 60 + $intervaldata->h * 3600;
              $hoursData     = floor($diffSeconds / 3600);
              $minutesData   = floor(($diffSeconds % 3600) / 60);
              $secondsData   = $diffSeconds % 60;
              $earlhrsData   = "$hoursData:$minutesData:$secondsData";

              $jsonPunchingLogs = json_encode($punchingLogs);          
              $dailyProcessing[] = [
                'emp_no'        => $value->emp_no,
                'emp_name'      => Emp_mst_live::where('EMP_NO', $value->emp_no)->first()->EMP_NAME,
                'dept_name'     => Department_master::where('DEPT_NO', Emp_mst_live::where('EMP_NO', $value->emp_no)->first()->DEPT_NO)->first()->DEPT_NAME,
                'punching_date' => $val->punching_date,
                'shift'         => $shift->Scode,
                'in_time'       => $attendance[0]->punching_log,
                'punching_log'  => $jsonPunchingLogs,
                'out_time'      => $outtime,
                'wrkhrs'        => $earlhrsData,
                'earlhrs'       => $earlhrs,
                'overtime'      => $overhrs,
                'status'        => "WWp",
                'remark'        => "WWp",
                'IRR'           => "",
              ];
            } else {
              $dailyProcessing[] = [
                'emp_no'        => $value->emp_no,
                'emp_name'      => Emp_mst_live::where('EMP_NO', $value->emp_no)->first()->EMP_NAME,
                'dept_name'     => Department_master::where('DEPT_NO', Emp_mst_live::where('EMP_NO', $value->emp_no)->first()->DEPT_NO)->first()->DEPT_NAME,
                'punching_date' => $val->punching_date,
                'shift'         => $shift->Scode,
                'in_time'       => "00",
                'punching_log'  => "00",
                'out_time'      => "00",
                'wrkhrs'        => "00",
                'earlhrs'       => "00",
                'overtime'      => "00",
                'status'        => "WW",
                'remark'        => "00",
                'IRR'           => "",
              ];
            }            
          }        
        }
      }
    }
    return view('Frontend.daily-processingtable', ['dailyProcessing' => $dailyProcessing]);
  }
  
  public function night_shift_data(Request $request) {
    $allData = [];
    $month = date('m', strtotime($request->month));
    $year  = date('Y', strtotime($request->month));
    if ($request->employeeSort == 1) {
      if ($request->empCodeWise == 1) {
        $monthlyShiftGenerate = MonthlyShiftGenerate::where(['month' => $month, 'year' => $year])->get();
        $allData = $monthlyShiftGenerate;
      } else {
        $monthlyShiftGenerate = MonthlyShiftGenerate::where(['month' => $month, 'year' => $year])->whereBetween('empcode', [$request->employee_from, $request->employee_to])->get();
        $allData = $monthlyShiftGenerate;
      }
    } else {
      if ($request->departmentWise == 1) {
        $monthlyShiftGenerate = MonthlyShiftGenerate::where(['month' => $month, 'year' => $year])->get();
        $allData = $monthlyShiftGenerate;
      } else {
        $Empmstlive = Emp_mst_live::select('EMP_NO')->whereBetween('DEPT_NO', [$request->department_from, $request->department_to])->plkuck('EMP_NO');
        $monthlyShiftGenerate = MonthlyShiftGenerate::where(['month' => $month, 'year' => $year])->whereIn('empcode' , $Empmstlive)->get();
        $allData = $monthlyShiftGenerate;
      }
    }
    $nightProcessing = [];
    $numDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    foreach($allData as $key => $value) {
      $totalday = 0;
      $count    = 0;
      for ($i=1; $i<=$numDays; $i++) {
        $date      = $year . "-" . $month . "-" . $i;
        $day       = "d" . $i;
        $shiftcode = $value->$day;
        $shift     = Shift::where(['Scode' => $shiftcode])->first();
        if ($shift) {
          if ($shift->InTime > "16:00" && $shift->outtime < "07:00") {
            $attendance  = Attendance::where(['emp_no' => $value->emp_no, 'punching_date' => $date])->get();
            if ($attendance) {
              $count++;
            }
          }
          $totalday++;
        } else {
          $separated = explode('/', $shiftcode);
          $shift     = Shift::where(['Scode' => $separated[1]])->first();
          if ($shift->InTime > "16:00" && $shift->outtime < "07:00") {
            $attendance  = Attendance::where(['emp_no' => $value->emp_no, 'punching_date' => $date])->get();
            if ($attendance) {
              $count++;
            }
          }
        }
      }
      $nightProcessing[] = [
        'emp_no'   => $value->empcode,
        'emp_name' => Emp_mst_live::where('EMP_NO', $value->empcode)->first()->EMP_NAME,
        'days_for' => $count,
        'total_day' => $totalday,
      ];
    }
    return view('Frontend.night-processingtable', ['nightProcessing' => $nightProcessing]);
  }

  public function late_arrival_data(Request $request) {
    $allData = [];
    $month = date('m', strtotime($request->month));
    $year  = date('Y', strtotime($request->month));
    if ($request->employeeSort == 1) {
      if ($request->empCodeWise == 1) {
        $monthlyShiftGenerate = MonthlyShiftGenerate::where(['month' => $month, 'year' => $year])->get();
        $allData = $monthlyShiftGenerate;
      } else {
        $monthlyShiftGenerate = MonthlyShiftGenerate::where(['month' => $month, 'year' => $year])->whereBetween('empcode', [$request->employee_from, $request->employee_to])->get();
        $allData = $monthlyShiftGenerate;
      }
    } else {
      if ($request->departmentWise == 1) {
        $monthlyShiftGenerate = MonthlyShiftGenerate::where(['month' => $month, 'year' => $year])->get();
        $allData = $monthlyShiftGenerate;
      } else {
        $Empmstlive = Emp_mst_live::select('EMP_NO')->whereBetween('DEPT_NO', [$request->department_from, $request->department_to])->plkuck('EMP_NO');
        $monthlyShiftGenerate = MonthlyShiftGenerate::where(['month' => $month, 'year' => $year])->whereIn('empcode' , $Empmstlive)->get();
        $allData = $monthlyShiftGenerate;
      }
    }
    $lateArrivals = [];
    $numDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    foreach($allData as $key => $value) {
      $latetime['emp_no'] = $value->empcode;
      $latetime['emp_name'] = Emp_mst_live::where('EMP_NO', $value->empcode)->first()->EMP_NAME;
      $latetime['month'] = $numDays;
      $latetime['monthName'] = date('F Y', strtotime($request->month));
      for ($i=1; $i<=$numDays; $i++) {
        $date      = $year . "-" . $month . "-" . $i;
        $day       = "d" . $i;
        $shiftcode = $value->$day;
        $shift     = Shift::where(['Scode' => $shiftcode])->first();
        $str       = (string) $i;
        if ($shift) {
          $attendance  = Attendance::where(['emp_no' => $value->empcode, 'punching_date' => $date])->get();
          if (count($attendance) > 0) {
            $intime = $attendance[0]->punching_log;
            if ($shift->InTime < $intime) {
              $outtimeData   = new DateTime($shift->InTime);
              $shiftOuttime  = new DateTime($intime);
              $intervaldata  = $outtimeData->diff($shiftOuttime);
              $diffSeconds   = $intervaldata->s + $intervaldata->i * 60 + $intervaldata->h * 3600;
              $hoursData     = floor($diffSeconds / 3600);
              $minutesData   = floor(($diffSeconds % 3600) / 60);
              $secondsData   = $diffSeconds % 60;
              $latehrsData   = "$hoursData:$minutesData:$secondsData";
              $latetime[$str] = $latehrsData;
            } else  {
              $latetime[$str] = "";
            }
          } else {
            $latetime[$str] = "";
          }
        } else {
          $separated  = explode('/', $shiftcode);
          $shift      = Shift::where(['Scode' => $separated[1]])->first();
          $attendance = Attendance::where(['emp_no' => $value->empcode, 'punching_date' => $date])->get();
          if (count($attendance) > 0) {
            $intime = $attendance[0]->punching_log;
            if ($shift->InTime < $intime) {
              $outtimeData   = new DateTime($shift->InTime);
              $shiftOuttime  = new DateTime($intime);
              $intervaldata  = $outtimeData->diff($shiftOuttime);
              $diffSeconds   = $intervaldata->s + $intervaldata->i * 60 + $intervaldata->h * 3600;
              $hoursData     = floor($diffSeconds / 3600);
              $minutesData   = floor(($diffSeconds % 3600) / 60);
              $secondsData   = $diffSeconds % 60;
              $latehrsData   = "$hoursData:$minutesData:$secondsData";
              $latetime[$str] = $latehrsData;
            } else  {
              $latetime[$str] = $latehrsData;
            }
          } else {
            $latetime[$str] = "";
          }        
        }        
      }
      $lateArrivals[] = $latetime;
    }
    return view('Frontend.late-arrivaltable', ['lateArrivals' => $lateArrivals]);
  }

  public function daily_performance_data(Request $request) {
    $allData = [];
    $month = date('m', strtotime($request->date));
    $year  = date('Y', strtotime($request->date));
    if ($request->employeeSort == 1) {
      if ($request->empCodeWise == 1) {
        $monthlyShiftGenerate = MonthlyShiftGenerate::where(['month' => $month, 'year' => $year])->get();
        $allData = $monthlyShiftGenerate;
      } else {
        $monthlyShiftGenerate = MonthlyShiftGenerate::where(['month' => $month, 'year' => $year])->whereBetween('empcode', [$request->employee_from, $request->employee_to])->get();
        $allData = $monthlyShiftGenerate;
      }
    } else {
      if ($request->departmentWise == 1) {
        $monthlyShiftGenerate = MonthlyShiftGenerate::where(['month' => $month, 'year' => $year])->get();
        $allData = $monthlyShiftGenerate;
      } else {
        $Empmstlive = Emp_mst_live::select('EMP_NO')->whereBetween('DEPT_NO', [$request->department_from, $request->department_to])->plkuck('EMP_NO');
        $monthlyShiftGenerate = MonthlyShiftGenerate::where(['month' => $month, 'year' => $year])->whereIn('empcode' , $Empmstlive)->get();
        $allData = $monthlyShiftGenerate;
      }
    }
    $dailyPerformance = [];
    $numDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    foreach($allData as $key => $value) {
      $i         = date('d', strtotime($request->date));
      $day       = "d" . $i;
      $shiftcode = $value->$day;
      $shift     = Shift::where(['Scode' => $shiftcode])->first();
      if ($shift) {
        $attendance  = Attendance::where(['emp_no' => $value->empcode, 'punching_date' => $request->date])->get();
        if (count($attendance) > 0) {
          if (count($attendance) % 2 === 0) {
            $outtime  = $attendance[count($attendance) - 1]->punching_log;
            
            $time1         = new DateTime($shift->outtime);
            $time2         = new DateTime($outtime);
            $interval      = $time1->diff($time2);
            $diffInSeconds = $interval->s + $interval->i * 60 + $interval->h * 3600;
            $hours         = floor($diffInSeconds / 3600);
            $minutes       = floor(($diffInSeconds % 3600) / 60);
            $seconds       = $diffInSeconds % 60;
            $overhrsdata   = "$hours:$minutes:$seconds";
            if($overhrsdata < "0:15:00") {
              $overhrs = "00";
            } else {
              $overhrs = "$hours:$minutes:$seconds";
            }
          } else {
            $outtime = "00";
            $overhrs = "00";
          }
          if ($attendance[0]->punching_log < $shift->InTime) {
            $time1         = new DateTime($shift->InTime);
            $time2         = new DateTime($attendance[0]->punching_log);
            $interval      = $time1->diff($time2);
            $diffInSeconds = $interval->s + $interval->i * 60 + $interval->h * 3600;
            $hours         = floor($diffInSeconds / 3600);
            $minutes       = floor(($diffInSeconds % 3600) / 60);
            $seconds       = $diffInSeconds % 60;
            $earlhrs       = "$hours:$minutes:$seconds";
            $remark        = "Elr";
          } else  {
            $earlhrs = "00";
            $remark  = "";
          }
          $punchingLogs = [];
          foreach ($attendance as $key => $item) {
            if ($key % 2 === 0) {
              $punchingLogs = "intime-$item->punching_log";
            } else {
              $punchingLogs = "outtime-$item->punching_log";
            }
          }

          $outtimeData   = new DateTime($attendance[count($attendance) - 1]->punching_log);
          $intime        = new DateTime($attendance[0]->punching_log);
          $intervaldata  = $outtimeData->diff($intime);
          $diffSeconds   = $intervaldata->s + $intervaldata->i * 60 + $intervaldata->h * 3600;
          $hoursData     = floor($diffSeconds / 3600);
          $minutesData   = floor(($diffSeconds % 3600) / 60);
          $secondsData   = $diffSeconds % 60;
          $earlhrsData   = "$hoursData:$minutesData:$secondsData";

          $jsonPunchingLogs = json_encode($punchingLogs);

          $dailyProcessing[] = [
            'emp_no'        => $value->empcode,
            'emp_name'      => Emp_mst_live::where('EMP_NO', $value->empcode)->first()->EMP_NAME,
            'dept_name'     => Department_master::where('DEPT_NO', Emp_mst_live::where('EMP_NO', $value->empcode)->first()->DEPT_NO)->first()->DEPT_NAME,
            'punching_date' => $request->date,
            'shift'         => $shift->Scode,
            'in_time'       => $attendance[0]->punching_log,
            'punching_log'  => $jsonPunchingLogs,
            'out_time'      => $outtime,
            'wrkhrs'        => $earlhrsData,
            'earlhrs'       => $earlhrs,
            'overtime'      => $overhrs,
            'status'        => "PP",
            'remark'        => $remark,
            'IRR'           => "",
          ];
        } else {
          $dailyPerformance[] = [
            'emp_no'        => $value->empcode,
            'emp_name'      => Emp_mst_live::where('EMP_NO', $value->empcode)->first()->EMP_NAME,
            'dept_name'     => Department_master::where('DEPT_NO', Emp_mst_live::where('EMP_NO', $value->empcode)->first()->DEPT_NO)->first()->DEPT_NAME,
            'punching_date' => $request->date,
            'shift'         => $shift->Scode,
            'in_time'       => "00",
            'punching_log'  => "00",
            'out_time'      => "00",
            'wrkhrs'        => "00",
            'earlhrs'       => "00",
            'overtime'      => "00",
            'status'        => "AA",
            'remark'        => "00",
            'IRR'           => "",
          ];
        }
      } else {
        $separated  = explode('/', $shiftcode);
        $shift      = Shift::where(['Scode' => $separated[1]])->first();
        $attendance = Attendance::where(['emp_no' => $value->empcode, 'punching_date' => $request->date])->get();
        if (count($attendance) > 0) {
          if (count($attendance) % 2 === 0) {
            $outtime = $attendance[count($attendance) - 1]->punching_log;

            $time1         = new DateTime($shift->outtime);
            $time2         = new DateTime($outtime);
            $interval      = $time1->diff($time2);
            $diffInSeconds = $interval->s + $interval->i * 60 + $interval->h * 3600;
            $hours         = floor($diffInSeconds / 3600);
            $minutes       = floor(($diffInSeconds % 3600) / 60);
            $seconds       = $diffInSeconds % 60;
            $overhrsdata   = "$hours:$minutes:$seconds";
            if($overhrsdata < "0:15:00") {
              $overhrs = "00";
            } else {
              $overhrs = "$hours:$minutes:$seconds";
            }
          } else {
            $outtime = "00";
            $overhrs = "00";
          }
          if ($attendance[0]->punching_log < $shift->InTime) {
            $time1         = new DateTime($shift->InTime);
            $time2         = new DateTime($attendance[0]->punching_log);
            $interval      = $time1->diff($time2);
            $diffInSeconds = $interval->s + $interval->i * 60 + $interval->h * 3600;
            $hours         = floor($diffInSeconds / 3600);
            $minutes       = floor(($diffInSeconds % 3600) / 60);
            $seconds       = $diffInSeconds % 60;
            $earlhrs       = "$hours:$minutes:$seconds";
          } else  {
            $earlhrs = "00";
          }
          $punchingLogs = [];
          foreach ($attendance as $key => $item) {
            if ($key % 2 === 0) {
              $punchingLogs = "intime-$item->punching_log";
            } else {
              $punchingLogs = "outtime-$item->punching_log";
            }
          }

          $outtimeData   = new DateTime($attendance[count($attendance) - 1]->punching_log);
          $intime        = new DateTime($attendance[0]->punching_log);
          $intervaldata  = $outtimeData->diff($intime);
          $diffSeconds   = $intervaldata->s + $intervaldata->i * 60 + $intervaldata->h * 3600;
          $hoursData     = floor($diffSeconds / 3600);
          $minutesData   = floor(($diffSeconds % 3600) / 60);
          $secondsData   = $diffSeconds % 60;
          $earlhrsData   = "$hoursData:$minutesData:$secondsData";

          $jsonPunchingLogs = json_encode($punchingLogs);          
          $dailyPerformance[] = [
            'emp_no'        => $value->empcode,
            'emp_name'      => Emp_mst_live::where('EMP_NO', $value->empcode)->first()->EMP_NAME,
            'dept_name'     => Department_master::where('DEPT_NO', Emp_mst_live::where('EMP_NO', $value->empcode)->first()->DEPT_NO)->first()->DEPT_NAME,
            'punching_date' => $request->date,
            'shift'         => $shift->Scode,
            'in_time'       => $attendance[0]->punching_log,
            'punching_log'  => $jsonPunchingLogs,
            'out_time'      => $outtime,
            'wrkhrs'        => $earlhrsData,
            'earlhrs'       => $earlhrs,
            'overtime'      => $overhrs,
            'status'        => "WWp",
            'remark'        => "WWp",
            'IRR'           => "",
          ];
        } else {
          $dailyPerformance[] = [
            'emp_no'        => $value->empcode,
            'emp_name'      => Emp_mst_live::where('EMP_NO', $value->empcode)->first()->EMP_NAME,
            'dept_name'     => Department_master::where('DEPT_NO', Emp_mst_live::where('EMP_NO', $value->empcode)->first()->DEPT_NO)->first()->DEPT_NAME,
            'punching_date' => $request->date,
            'shift'         => $shift->Scode,
            'in_time'       => "00",
            'punching_log'  => "00",
            'out_time'      => "00",
            'wrkhrs'        => "00",
            'earlhrs'       => "00",
            'overtime'      => "00",
            'status'        => "WW",
            'remark'        => "00",
            'IRR'           => "",
          ];
        }        
      }
    }
    return view('Frontend.daily-performancetable', ['dailyPerformance' => $dailyPerformance]);
  }

  public function periodic_performance_data(Request $request){
    $allData = [];
    if($request->employeeSort == 1){
      if($request->empCodeWise == 1){
        $allEmployee = Attendance::select('emp_no')->whereBetween('punching_date', [$request->from_date, $request->to_date])->groupBy('emp_no')->get();
        $allData = $allEmployee;
      } else {
        $EmployeeWiseData = Attendance::select('emp_no')->whereBetween('emp_no', [$request->employee_from, $request->employee_to])->whereBetween('punching_date', [$request->from_date, $request->to_date])->groupBy('emp_no')->get();
        $allData = $EmployeeWiseData;
      }
    } else {
      if($request->departmentWise == 1){
        $allDepartment = Attendance::select('emp_no')->whereBetween('punching_date', [$request->from_date, $request->to_date])->groupBy('emp_no')->get();
        $allData = $allDepartment;
      } else {
        $DepartmentWiseData = Attendance::select('emp_no')->whereBetween('punching_date', [$request->from_date, $request->to_date])->whereBetween('dept_no', [$request->department_from, $request->department_to])->groupBy('emp_no')->get();
        $allData = $DepartmentWiseData;
      }
    }
    $periodicPerformance = [];
    foreach ($allData as $ky => $value) {
      $dailyProcessing = [];
      $attendancePunchingDate = Attendance::whereBetween('punching_date', [$request->from_date, $request->to_date])->groupBy('punching_date')->get();
      foreach ($attendancePunchingDate as $key => $val) {
        $month = date('m', strtotime($val->punching_date));
        $year  = date('Y', strtotime($val->punching_date));
        $day   = date('d', strtotime($val->punching_date));
        $monthlyShiftGenerate = MonthlyShiftGenerate::where(['empcode' => $value->emp_no, 'month' => $month, 'year' => $year])->get();
        $attendance  = Attendance::where(['emp_no' => $value->emp_no, 'punching_date' => $val->punching_date])->get();
        if (count($monthlyShiftGenerate) == 1) {
          $d_date        = 'd'.$day;
          $shiftDate     = $monthlyShiftGenerate[0]->$d_date;
          $shift         = Shift::where(['Scode' => $shiftDate])->first();
          if ($shift) {
            if(count($attendance) > 0) {
              if (count($attendance) % 2 === 0) {
                $outtime  = $attendance[count($attendance) - 1]->punching_log;
                
                $time1         = new DateTime($shift->outtime);
                $time2         = new DateTime($outtime);
                $interval      = $time1->diff($time2);
                $diffInSeconds = $interval->s + $interval->i * 60 + $interval->h * 3600;
                $hours         = floor($diffInSeconds / 3600);
                $minutes       = floor(($diffInSeconds % 3600) / 60);
                $seconds       = $diffInSeconds % 60;
                $overhrsdata   = "$hours:$minutes:$seconds";
                if($overhrsdata < "0:15:00") {
                  $overhrs = "00";
                } else {
                  $overhrs = "$hours:$minutes:$seconds";
                }
              } else {
                $outtime = "00";
                $overhrs = "00";
              }
              if ($attendance[0]->punching_log < $shift->InTime) {
                $time1         = new DateTime($shift->InTime);
                $time2         = new DateTime($attendance[0]->punching_log);
                $interval      = $time1->diff($time2);
                $diffInSeconds = $interval->s + $interval->i * 60 + $interval->h * 3600;
                $hours         = floor($diffInSeconds / 3600);
                $minutes       = floor(($diffInSeconds % 3600) / 60);
                $seconds       = $diffInSeconds % 60;
                $earlhrs       = "$hours:$minutes:$seconds";
                $remark        = "Elr";
              } else  {
                $earlhrs = "00";
                $remark  = "";
              }
              $punchingLogs = [];
              foreach ($attendance as $key => $item) {
                if ($key % 2 === 0) {
                  $punchingLogs[] = "intime-$item->punching_log";
                } else {
                  $punchingLogs[] = "outtime-$item->punching_log";
                }
              }

              $outtimeData   = new DateTime($attendance[count($attendance) - 1]->punching_log);
              $intime        = new DateTime($attendance[0]->punching_log);
              $intervaldata  = $outtimeData->diff($intime);
              $diffSeconds   = $intervaldata->s + $intervaldata->i * 60 + $intervaldata->h * 3600;
              $hoursData     = floor($diffSeconds / 3600);
              $minutesData   = floor(($diffSeconds % 3600) / 60);
              $secondsData   = $diffSeconds % 60;
              $earlhrsData   = "$hoursData:$minutesData:$secondsData";

              $jsonPunchingLogs = json_encode($punchingLogs);

              $dailyProcessing[] = [
                'emp_no'        => $value->emp_no,
                'emp_name'      => Emp_mst_live::where('EMP_NO', $value->emp_no)->first()->EMP_NAME,
                'card_no'       => Emp_mst_live::where('EMP_NO', $value->emp_no)->first()->card_no,
                'dept_name'     => Department_master::where('DEPT_NO', Emp_mst_live::where('EMP_NO', $value->emp_no)->first()->DEPT_NO)->first()->DEPT_NAME,
                'punching_date' => $val->punching_date,
                'shift'         => $shift->Scode,
                'in_time'       => $attendance[0]->punching_log,
                'punching_log'  => $jsonPunchingLogs,
                'out_time'      => $outtime,
                'wrkhrs'        => $earlhrsData,
                'earlhrs'       => $earlhrs,
                'overtime'      => $overhrs,
                'status'        => "PP",
                'remark'        => $remark,
                'IRR'           => "",
              ];
            } else {
              $dailyProcessing[] = [
                'emp_no'        => $value->emp_no,
                'emp_name'      => Emp_mst_live::where('EMP_NO', $value->emp_no)->first()->EMP_NAME,
                'card_no'       => Emp_mst_live::where('EMP_NO', $value->emp_no)->first()->card_no,
                'dept_name'     => Department_master::where('DEPT_NO', Emp_mst_live::where('EMP_NO', $value->emp_no)->first()->DEPT_NO)->first()->DEPT_NAME,
                'punching_date' => $val->punching_date,
                'shift'         => $shift->Scode,
                'in_time'       => "00",
                'punching_log'  => "00",
                'out_time'      => "00",
                'wrkhrs'        => "00",
                'earlhrs'       => "00",
                'overtime'      => "00",
                'status'        => "AA",
                'remark'        => "00",
                'IRR'           => "",
              ];
            }            
          } else {
            $separated = explode('/', $shiftDate);
            $shift     = Shift::where(['Scode' => $separated[1]])->first();
            if(count($attendance) > 0) {
              if (count($attendance) % 2 === 0) {
                $outtime = $attendance[count($attendance) - 1]->punching_log;

                $time1         = new DateTime($shift->outtime);
                $time2         = new DateTime($outtime);
                $interval      = $time1->diff($time2);
                $diffInSeconds = $interval->s + $interval->i * 60 + $interval->h * 3600;
                $hours         = floor($diffInSeconds / 3600);
                $minutes       = floor(($diffInSeconds % 3600) / 60);
                $seconds       = $diffInSeconds % 60;
                $overhrsdata   = "$hours:$minutes:$seconds";
                if($overhrsdata < "0:15:00") {
                  $overhrs = "00";
                } else {
                  $overhrs = "$hours:$minutes:$seconds";
                }
              } else {
                $outtime = "00";
                $overhrs = "00";
              }
              if ($attendance[0]->punching_log < $shift->InTime) {
                $time1         = new DateTime($shift->InTime);
                $time2         = new DateTime($attendance[0]->punching_log);
                $interval      = $time1->diff($time2);
                $diffInSeconds = $interval->s + $interval->i * 60 + $interval->h * 3600;
                $hours         = floor($diffInSeconds / 3600);
                $minutes       = floor(($diffInSeconds % 3600) / 60);
                $seconds       = $diffInSeconds % 60;
                $earlhrs       = "$hours:$minutes:$seconds";
              } else  {
                $earlhrs = "00";
              }
              $punchingLogs = [];
              foreach ($attendance as $key => $item) {
                if ($key % 2 === 0) {
                  $punchingLogs[] = "intime-$item->punching_log";
                } else {
                  $punchingLogs[] = "outtime-$item->punching_log";
                }
              }

              $outtimeData   = new DateTime($attendance[count($attendance) - 1]->punching_log);
              $intime        = new DateTime($attendance[0]->punching_log);
              $intervaldata  = $outtimeData->diff($intime);
              $diffSeconds   = $intervaldata->s + $intervaldata->i * 60 + $intervaldata->h * 3600;
              $hoursData     = floor($diffSeconds / 3600);
              $minutesData   = floor(($diffSeconds % 3600) / 60);
              $secondsData   = $diffSeconds % 60;
              $earlhrsData   = "$hoursData:$minutesData:$secondsData";

              $jsonPunchingLogs = json_encode($punchingLogs);          
              $dailyProcessing[] = [
                'emp_no'        => $value->emp_no,
                'emp_name'      => Emp_mst_live::where('EMP_NO', $value->emp_no)->first()->EMP_NAME,
                'card_no'       => Emp_mst_live::where('EMP_NO', $value->emp_no)->first()->card_no,
                'dept_name'     => Department_master::where('DEPT_NO', Emp_mst_live::where('EMP_NO', $value->emp_no)->first()->DEPT_NO)->first()->DEPT_NAME,
                'punching_date' => $val->punching_date,
                'shift'         => $shift->Scode,
                'in_time'       => $attendance[0]->punching_log,
                'punching_log'  => $jsonPunchingLogs,
                'out_time'      => $outtime,
                'wrkhrs'        => $earlhrsData,
                'earlhrs'       => $earlhrs,
                'overtime'      => $overhrs,
                'status'        => "WWp",
                'remark'        => "WWp",
                'IRR'           => "",
              ];
            } else {
              $dailyProcessing[] = [
                'emp_no'        => $value->emp_no,
                'emp_name'      => Emp_mst_live::where('EMP_NO', $value->emp_no)->first()->EMP_NAME,
                'card_no'       => Emp_mst_live::where('EMP_NO', $value->emp_no)->first()->card_no,
                'dept_name'     => Department_master::where('DEPT_NO', Emp_mst_live::where('EMP_NO', $value->emp_no)->first()->DEPT_NO)->first()->DEPT_NAME,
                'punching_date' => $val->punching_date,
                'shift'         => $shift->Scode,
                'in_time'       => "00",
                'punching_log'  => "00",
                'out_time'      => "00",
                'wrkhrs'        => "00",
                'earlhrs'       => "00",
                'overtime'      => "00",
                'status'        => "WW",
                'remark'        => "00",
                'IRR'           => "",
              ];
            }            
          }        
        }
      }
      $periodicPerformance[] = $dailyProcessing;
    }
    return view('Frontend.periodic-performancetable', ['periodicPerformance' => $periodicPerformance, 'fromDate' => $request->from_date, 'toDate' => $request->to_date]);
  }
}