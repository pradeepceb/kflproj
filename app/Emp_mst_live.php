<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Emp_mst_live extends Model
{
//
    protected $table = 'emp_mst_live';
    protected $fillable = ['EMP_NO','EMP_NAME','DEPT_NO','GRADE_CODE','DESG_CODE',
    'DOB','DOJ','RETIREMENT_DATE','EMP_TYPE','ACTIVE_TYPE','INACTIVE_REASON','CONT_END_DATE','CONT_SAL','PROB_START_DATE','CONFIRM_DATE','SEX','MARITAL_STATUS','BLOOD_GROUP','ID_MARK','SPOUSE_NAME','FATHER_NAME','PRESENT_ADDRESS1','PRESENT_ADDRESS2','PRESENT_ADDRESS3','PERM_ADDRESS1','PERM_ADDRESS2','PERM_ADDRESS3','CITY','PIN','PH_NO','QUALIFICATION','REFERENCE','EMAIL','PAYMENT_MODE','BANK_AC_NO','BANK_CODE','PF_AC_NO','BASIC_PAY','INCR_AMT','INCR_DUE_DATE','PROB_END_DATE','VPF_PERC','CATG','DA_PAY','SRL_NO','LEAVE_ENCASH_DAYS','PF_DED','SPL_ALLOW','ESI_DED','SAL_CATG','ESI_AC_NO','CONV_ALLOW','VP_PERC','PP1','PP2','PAY_GRADE_CODE','NEW_BASIC_PAY','MOTHER_NAME','SPOUSE_DOB','FATHER_DOB','MOTHER_DOB','EMPLOYEE_CODE','LEFTON_DATE','PAN_NO','SPL_ALLOW2','UAN','AADHAAR_NO','RETIRE','TO_DATE','SUB_DPT_WORKPLACE','CARD_NO','CARD_NO2','OVER_TIME','ENTRY_REQUIRED','shift_type','SHIFT_ROTATION_ID','week_off','AUTO_UPDATE','is_regular_employee','eligible_for_ph_if_present','conciding_with_weekoff','eligible_for_ch_if_not','eligigble_for_PH_if_not_present','entitled_for_night_shift'];

    public static function Employee_Master_view()
    {
        $Employee_view = DB::table('emp_mst_live')
        ->orderBy('id','DESC')
        ->get();

        return $Employee_view;
    }
    public static function Employee_Master_Last_record_view()
    {
        $Employee_Last_record_view = DB::table('emp_mst_live')
                        ->orderBy('id','DESC')
                        ->limit(1)
                        ->first();
        $emp_no =  $Employee_Last_record_view->EMP_NO;            
        return $emp_no;
  }
  public static function Employee_Master_first_record_view()
    {
        $Employee_first_record_view = DB::table('emp_mst_live')->orderBy('id','ASC')->first();
        $empfirst_no =  $Employee_first_record_view->EMP_NO;            
        return $empfirst_no;
  }
  public static function Employee_Master_delete_record_view($request)
    {
      $empno = $request->input('search_emp');
      $Employee_id =DB::table('emp_mst_live')->where('emp_no',$empno)->first();
      $emp_id =  $Employee_id->id;  
      $emp_no =  $Employee_id->EMP_NO;    
      $empnext_no = DB::table('empmst_official')->where('id',$emp_id)->delete();  
      $empnext_no = DB::table('emp_dependent_dtl')->where('emp_no',$emp_no)->delete(); 
      $empnext_no = DB::table('emp_nominee_dtl')->where('emp_no',$emp_no)->delete();
      $empnext_no = DB::table('emp_qualification_dtl')->where('emp_no',$emp_no)->delete();
      $empnext_no = DB::table('emp_experience_dtl')->where('emp_no',$emp_no)->delete(); 
      $empnext_no = DB::table('emp_trnasfer_dtl')->where('emp_no',$emp_no)->delete();
      $empnext_no = DB::table('employee_promotion_dtl')->where('emp_no',$emp_no)->delete();   
      $empnext_no = DB::table('emp_probation_dtl')->where('emp_no',$emp_no)->delete();
      $empnext_no = DB::table('emp_contract_dtl')->where('emp_no',$emp_no)->delete();
      $empnext_no = DB::table('emp_antecedent_dtl')->where('emp_no',$emp_id)->delete();
      $empnext_no = DB::table('emp_revocation_dtl')->where('emp_no',$emp_id)->delete(); 
      $empnext_no = DB::table('emp_remark_dtl')->where('emp_no',$emp_no)->delete(); 
      $empnext_no = DB::table('emp_achievement_dtl')->where('emp_no',$emp_id)->delete();
      $empnext_no = DB::table('emp_reward')->where('emp_no',$emp_id)->delete(); 
      $empnext_no = DB::table('emp_appreciation')->where('emp_no',$emp_id)->delete(); 
      $empnext_no = DB::table('emp_mst_live')->where('id',$emp_id)->delete();                                                    
      return $empnext_no;
    }
    
    public static function Employee_Master_next_record_view($request)
    {
        $empno = $request->input('search_emp');
     
        $Employee_id =DB::table('emp_mst_live')
                                    ->select('id')
                                    ->where('emp_no',$empno)
                                    ->first();
        $id = $Employee_id->id;

       $empnext_no = DB::table('emp_mst_live')
                       ->where('id', '>', $id)
                       ->select('emp_no')
                       ->min('id');
      if($empnext_no>0)
       {
           $Empno_next =DB::table('emp_mst_live')
                            ->select('emp_no')                      
                            ->where('id',$empnext_no)
                            ->first();
           return $Empno_next->EMP_NO;
      }
       else
       {
            return $Empno_next="";
       }               
    }
    public static function Employee_Master_previous_record_view($request)
    {
        $empno = $request->input('search_emp');
     
        $Employee_id =DB::table('emp_mst_live')
                                    ->select('id')
                                    ->where('emp_no',$empno)
                                    ->first();
        $id = $Employee_id->id;
  //$previous = User::where('id', '<', $user->id)->max('id');
       $empnext_no = DB::table('emp_mst_live')
                       ->where('id', '<', $id)
                       ->select('emp_no')
                       ->max('id');
      if($empnext_no>0)
       {
           $Empno_next =DB::table('emp_mst_live')
                            ->select('emp_no')                      
                            ->where('id',$empnext_no)
                            ->first();
           return $Empno_next->EMP_NO;
      }
       else
       {
            return $Empno_next="";
       }               
    }
   


   public function getAllEmployeeInfo($employee_number) 
     {
 
      $employeeListing = DB::table('emp_mst_live')            
        ->where('emp_no',$employee_number)
        ->first();      
       //echo"<pre>";print_r($employeeListing );echo"</pre>";exit();

    return $employeeListing;
        }
    public function getAllEmployeeOfficialInfo($employee_number) 
     {
      // $OfficialListing= DB::table('emp_mst_live')
      //       ->select('id')            
      //       ->where('emp_no',$employee_number)
      //       ->first();
      //       $off_id = $OfficialListing->id;

      $official_user_info = DB::table('empmst_official')->where('emp_no',$employee_number)->first(); 
       // echo"<pre>";print_r($OfficialListing );echo"</pre>";exit();
      return $official_user_info;
        }

        public function getAllNomineeInfo($employee_number) 
     {
      $NomineeListing= DB::table('emp_mst_live')
            ->select('id')            
            ->where('emp_no',$employee_number)
            ->first();
      $nom_id = $NomineeListing->id;

      $Nominee_user_info = DB::table('emp_nominee_dtl')->where('emp_no',$nom_id)->first(); 
       // echo"<pre>";print_r($Nominee_user_info );echo"</pre>";exit();
      return $Nominee_user_info;
        }





        public function getDependentInfo($employee_number) 
      {
        $user = DB::table('emp_mst_live')->where('EMP_NO',$employee_number)->first();
        $emp_no = $user->EMP_NO;
        $emp_id = $user->id;
        $check =  DB::table('emp_dependent_dtl')->where('EMP_NO',$emp_no)->count();
        if($check > 0){
          $slno_check =  DB::table('emp_dependent_dtl')->where('EMP_NO',$emp_no)->where('SL_NO','!=',"")->count();
          $date_check =  DB::table('emp_dependent_dtl')->where('EMP_NO',$emp_no)->where('depd_dob','!=',"")->count();
          if($slno_check == 0 && $date_check == 0){
            $dependent_user_info = DB::table('emp_dependent_dtl')->orderBy('id','DESC')->where('EMP_NO',$emp_no)->get();  
          } else {
            if($slno_check > 0 && $date_check > 0){
              $dependent_user_info = DB::table('emp_dependent_dtl')->orderBy('SL_NO','ASC')->where('EMP_NO',$emp_no)->get();  
            } else {
              if($slno_check > 0 ){
                $dependent_user_info = DB::table('emp_dependent_dtl')->orderBy('SL_NO','ASC')->where('EMP_NO',$emp_no)->get(); 
              } elseif($date_check > 0){ 
                $dependent_user_info = DB::table('emp_dependent_dtl')->orderBy('depd_dob','ASC')->where('EMP_NO',$emp_no)->get(); 
              }else{
                $dependent_user_info = DB::table('emp_dependent_dtl')->orderBy('id','DESC')->where('EMP_NO',$emp_no)->get();  
              }
            }
          }
        } else {
          $dependent_user_info = DB::table('emp_dependent_dtl')->orderBy('id','DESC')->where('emp_no',$emp_no)->get();  
        }
        return $dependent_user_info;
        }



      public function getAllQualificationInfo($employee_number) 
      {
        $user = DB::table('emp_mst_live')->where('EMP_NO',$employee_number)->first();
        $emp_no = $user->EMP_NO;
        $emp_id = $user->id;
        $check =  DB::table('emp_qualification_dtl')->where('EMP_NO',$emp_no)->count();
        if($check > 0){
          $slno_check =  DB::table('emp_qualification_dtl')->where('EMP_NO',$emp_no)->where('SL_NO','!=',"")->count();
          $date_check =  DB::table('emp_qualification_dtl')->where('EMP_NO',$emp_no)->where('year_passing','!=',"")->count();
          if($slno_check == 0 && $date_check == 0){
            $Qualification_user_info = DB::table('emp_qualification_dtl')->where('EMP_NO',$emp_no)->orderBy('id','DESC')->get(); 
          } else { 
            if($slno_check > 0 && $date_check > 0){
              $Qualification_user_info = DB::table('emp_qualification_dtl')->where('EMP_NO',$emp_no)->orderBy('SL_NO','ASC')->get(); 
            } else {
              if($slno_check > 0 ){
                $Qualification_user_info = DB::table('emp_qualification_dtl')->where('EMP_NO',$emp_no)->orderBy('SL_NO','ASC')->get();
              } elseif($date_check > 0){
                $Qualification_user_info = DB::table('emp_qualification_dtl')->where('EMP_NO',$emp_no)->orderBy('year_passing','ASC')->get();
              }else{
                $Qualification_user_info = DB::table('emp_qualification_dtl')->where('EMP_NO',$emp_no)->orderBy('id','DESC')->get(); 
              }
            }
          }
        } else {
          $Qualification_user_info = DB::table('emp_qualification_dtl')->where('EMP_NO',$emp_no)->orderBy('id','DESC')->get(); 
        }  
      return $Qualification_user_info;
      }  

     public function getExperienceInfo($employee_number) 
      {
        $user = DB::table('emp_mst_live')->where('EMP_NO',$employee_number)->first();
        $emp_no = $user->EMP_NO;
        $emp_id = $user->id;
        $check =  DB::table('emp_experience_dtl')->where('EMP_NO',$emp_no)->count();
        if($check > 0){
          $slno_check =  DB::table('emp_experience_dtl')->where('EMP_NO',$emp_no)->where('SL_NO','!=',"")->count();
          $date_check =  DB::table('emp_experience_dtl')->where('EMP_NO',$emp_no)->where('start_date','!=',"")->count();
          if($slno_check == 0 && $date_check == 0){
            $Experience_user_info = DB::table('emp_experience_dtl')->where('EMP_NO',$emp_no)->orderBy('id','DESC')->get(); 
          } else {
            if($slno_check > 0 && $date_check > 0){
              $Experience_user_info = DB::table('emp_experience_dtl')->where('EMP_NO',$emp_no)->orderBy('SL_NO','ASC')->get(); 
            } else {
              if($slno_check > 0 ){
                $Experience_user_info = DB::table('emp_experience_dtl')->where('EMP_NO',$emp_no)->orderBy('SL_NO','ASC')->get();
              } elseif($date_check > 0){
                $Experience_user_info = DB::table('emp_experience_dtl')->where('EMP_NO',$emp_no)->orderBy('start_date','ASC')->get();
              }else{
                $Experience_user_info = DB::table('emp_experience_dtl')->where('EMP_NO',$emp_no)->orderBy('id','DESC')->get(); 
              }
            }
          }
        } else {
          $Experience_user_info = DB::table('emp_experience_dtl')->where('EMP_NO',$emp_no)->orderBy('id','DESC')->get(); 
        }
      return $Experience_user_info;
      }

      public function getTransferInfo($employee_number) 
      {
        $user = DB::table('emp_mst_live')->where('EMP_NO',$employee_number)->first();
        $emp_no = $user->EMP_NO;
        $emp_id = $user->id;
        $check =  DB::table('emp_trnasfer_dtl')->where('EMP_NO',$emp_no)->count();
        if($check > 0){
          $slno_check =  DB::table('emp_trnasfer_dtl')->where('EMP_NO',$emp_no)->where('SL_NO','!=',"")->count();
          $date_check =  DB::table('emp_trnasfer_dtl')->where('EMP_NO',$emp_no)->where('trans_date','!=',"")->count();
          if($slno_check == 0 && $date_check == 0){
            $Transfer_user_info = DB::table('emp_trnasfer_dtl')->where('EMP_NO',$emp_no)->orderBy('id','DESC')->get(); 
          } else {
            if($slno_check > 0 && $date_check > 0){
              $Transfer_user_info = DB::table('emp_trnasfer_dtl')->where('EMP_NO',$emp_no)->orderBy('SL_NO','ASC')->get(); 
            } else {
              if($slno_check > 0 ){
                $Transfer_user_info = DB::table('emp_trnasfer_dtl')->where('EMP_NO',$emp_no)->orderBy('SL_NO','ASC')->get();
              } elseif($date_check > 0){
                $Transfer_user_info = DB::table('emp_trnasfer_dtl')->where('EMP_NO',$emp_no)->orderBy('trans_date','ASC')->get();
              }else{
                $Transfer_user_info = DB::table('emp_trnasfer_dtl')->where('EMP_NO',$emp_no)->orderBy('id','DESC')->get(); 
              }
            }
          }
        } else {
          $Transfer_user_info = DB::table('emp_trnasfer_dtl')->where('EMP_NO',$emp_no)->orderBy('id','DESC')->get(); 
        }
      return $Transfer_user_info;
      }  

      public function getPromotionInfo($employee_number) 
      {
        $user = DB::table('emp_mst_live')->where('EMP_NO',$employee_number)->first();
        $emp_no = $user->EMP_NO;
        $emp_id = $user->id;
        $check =  DB::table('employee_promotion_dtl')->where('EMP_NO',$emp_no)->count();
        if($check > 0){
          $slno_check =  DB::table('employee_promotion_dtl')->where('EMP_NO',$emp_no)->where('SL_NO','!=',"")->count();
          $date_check =  DB::table('employee_promotion_dtl')->where('EMP_NO',$emp_no)->where('promotion_date','!=',"")->count();
          if($slno_check == 0 && $date_check == 0){
            $Promotion_user_info = DB::table('employee_promotion_dtl')->where('EMP_NO',$emp_no)->orderBy('id','DESC')->get(); 
          } else {
            if($slno_check > 0 && $date_check > 0){
              $Promotion_user_info = DB::table('employee_promotion_dtl')->where('EMP_NO',$emp_no)->orderBy('SL_NO','ASC')->get(); 
            } else {
              if($slno_check > 0 ){
                $Promotion_user_info = DB::table('employee_promotion_dtl')->where('EMP_NO',$emp_no)->orderBy('SL_NO','ASC')->get();
              } elseif($date_check > 0){
                $Promotion_user_info = DB::table('employee_promotion_dtl')->where('EMP_NO',$emp_no)->orderBy('promotion_date','ASC')->get();
              }else{
                $Promotion_user_info = DB::table('employee_promotion_dtl')->where('EMP_NO',$emp_no)->orderBy('id','DESC')->get(); 
              }
            }
          }
        } else {
          $Promotion_user_info = DB::table('employee_promotion_dtl')->where('EMP_NO',$emp_no)->orderBy('id','DESC')->get(); 
        }
      return $Promotion_user_info;
      } 


    public function getProbationInfo($employee_number) 
    {
      $user = DB::table('emp_mst_live')->where('EMP_NO',$employee_number)->first();
      $emp_no = $user->EMP_NO;
      $emp_id = $user->id;
      $check =  DB::table('emp_probation_dtl')->where('EMP_NO',$emp_no)->count();
      if($check > 0){
        $slno_check =  DB::table('emp_probation_dtl')->where('EMP_NO',$emp_no)->where('SL_NO','!=',"")->count();
        $date_check =  DB::table('emp_probation_dtl')->where('EMP_NO',$emp_no)->where('prob_start_date','!=',"")->count();
        if($slno_check == 0 && $date_check == 0){
          $Probation_user_info = DB::table('emp_probation_dtl')->where('EMP_NO',$emp_no)->orderBy('id','DESC')->get(); 
        } else {
          if($slno_check > 0 && $date_check > 0){
            $Probation_user_info = DB::table('emp_probation_dtl')->where('EMP_NO',$emp_no)->orderBy('SL_NO','ASC')->get(); 
          } else {
            if($slno_check > 0 ){
              $Probation_user_info = DB::table('emp_probation_dtl')->where('EMP_NO',$emp_no)->orderBy('SL_NO','ASC')->get();
            } elseif($date_check > 0){
              $Probation_user_info = DB::table('emp_probation_dtl')->where('EMP_NO',$emp_no)->orderBy('prob_start_date','ASC')->get();
            }else{
              $Probation_user_info = DB::table('emp_probation_dtl')->where('EMP_NO',$emp_no)->orderBy('id','DESC')->get(); 
            }
          }
        }
      } else {
        $Probation_user_info = DB::table('emp_probation_dtl')->where('EMP_NO',$emp_no)->orderBy('id','DESC')->get();  
      }
      return $Probation_user_info;
    } 

 

      public function getContractInfo($employee_number) 
      {
        $user = DB::table('emp_mst_live')->where('EMP_NO',$employee_number)->first();
        $emp_no = $user->EMP_NO;
        $emp_id = $user->id;
        $check =  DB::table('emp_contract_dtl')->where('EMP_NO',$emp_no)->count();
        if($check > 0){
          $slno_check =  DB::table('emp_contract_dtl')->where('EMP_NO',$emp_no)->where('Sl_NO','!=',"")->count();
          $date_check =  DB::table('emp_contract_dtl')->where('EMP_NO',$emp_no)->where('cont_start_date','!=',"")->count();
          if($slno_check == 0 && $date_check == 0){
            $Contract_user_info = DB::table('emp_contract_dtl')->where('EMP_NO',$emp_no)->orderBy('id','DESC')->get(); 
          } else { 
            if($slno_check > 0 && $date_check > 0){
              $Contract_user_info = DB::table('emp_contract_dtl')->where('EMP_NO',$emp_no)->orderBy('Sl_NO','ASC')->get(); 
            } else {
              if($slno_check > 0 ){
                $Contract_user_info = DB::table('emp_contract_dtl')->where('EMP_NO',$emp_no)->orderBy('Sl_NO','ASC')->get();
              } elseif($date_check > 0) {
                $Contract_user_info = DB::table('emp_contract_dtl')->where('EMP_NO',$emp_no)->orderBy('cont_start_date','ASC')->get();
              } else {
                $Contract_user_info = DB::table('emp_contract_dtl')->where('EMP_NO',$emp_no)->orderBy('id','DESC')->get(); 
              }
            }
          }
        } else {
          $Contract_user_info = DB::table('emp_contract_dtl')->where('EMP_NO',$employee_number)->orderBy('id','DESC')->get();   
        } 
      return $Contract_user_info;
      } 



    public function getAntecedentInfo($employee_number) 
      {
      $user = DB::table('emp_mst_live')->where('EMP_NO',$employee_number)->first();
      $emp_no = $user->EMP_NO;
      $emp_id = $user->id;
      $check =  DB::table('emp_antecedent_dtl')->where('EMP_NO',$emp_id)->count();
      if($check > 0){
        $slno_check =  DB::table('emp_antecedent_dtl')->where('EMP_NO',$emp_id)->where('slno','!=',"")->count();
        $date_check =  DB::table('emp_antecedent_dtl')->where('EMP_NO',$emp_id)->where('order_date','!=',"")->count();
        if($slno_check == 0 && $date_check == 0){
          $Antecedent_user_info = DB::table('emp_antecedent_dtl')->where('EMP_NO',$emp_id)->orderBy('id','DESC')->get(); 
        } else {
          if($slno_check > 0 && $date_check > 0){
            $Antecedent_user_info = DB::table('emp_antecedent_dtl')->where('EMP_NO',$emp_id)->orderBy('slno','ASC')->get(); 
          } else {
            if($slno_check > 0 ){
              $Antecedent_user_info = DB::table('emp_antecedent_dtl')->where('EMP_NO',$emp_id)->orderBy('slno','ASC')->get();
            } elseif($date_check > 0){
              $Antecedent_user_info = DB::table('emp_antecedent_dtl')->where('EMP_NO',$emp_id)->orderBy('order_date','ASC')->get();
            }else{
              $Antecedent_user_info = DB::table('emp_antecedent_dtl')->where('EMP_NO',$emp_id)->orderBy('id','DESC')->get(); 
            }
          }
        }
      } else {
        $Antecedent_user_info = DB::table('emp_antecedent_dtl')->where('EMP_NO',$emp_id)->orderBy('id','DESC')->get(); 
      } 
      return $Antecedent_user_info;
        } 


   public function getRevocationInfo($employee_number) 
      {
        $user = DB::table('emp_mst_live')->where('EMP_NO',$employee_number)->first();
        $emp_no = $user->EMP_NO;
        $emp_id = $user->id;
        $check =  DB::table('emp_revocation_dtl')->where('EMP_NO',$emp_id)->count();
        if($check > 0){
          $slno_check =  DB::table('emp_revocation_dtl')->where('EMP_NO',$emp_id)->where('slno','!=',"")->count();
          $date_check =  DB::table('emp_revocation_dtl')->where('EMP_NO',$emp_id)->where('revocation_order_date','!=',"")->count();
          if($slno_check == 0 && $date_check == 0){
            $Revocation_user_info = DB::table('emp_revocation_dtl')->where('EMP_NO',$emp_id)->orderBy('id','DESC')->get(); 
          } else {
            if($slno_check > 0 && $date_check > 0){
              $Revocation_user_info = DB::table('emp_revocation_dtl')->where('EMP_NO',$emp_id)->orderBy('slno','ASC')->get(); 
            } else {
              if($slno_check > 0 ){
                $Revocation_user_info = DB::table('emp_revocation_dtl')->where('EMP_NO',$emp_id)->orderBy('slno','ASC')->get();
              } elseif($date_check > 0){
                $Revocation_user_info = DB::table('emp_revocation_dtl')->where('EMP_NO',$emp_id)->orderBy('revocation_order_date','ASC')->get();
              }else{
                $Revocation_user_info = DB::table('emp_revocation_dtl')->where('EMP_NO',$emp_id)->orderBy('id','DESC')->get(); 
              }
            }
          }
        } else {
          $Revocation_user_info = DB::table('emp_revocation_dtl')->where('EMP_NO',$emp_id)->orderBy('id','DESC')->get(); 
        } 
        return $Revocation_user_info;
        } 

    /**/
       public function getIntitionInfo($employee_number) 
      {
        $user = DB::table('emp_mst_live')->where('EMP_NO',$employee_number)->first();
        $emp_no = $user->EMP_NO;
        $emp_id = $user->id;
        $check =  DB::table('emp_initiation_dtl')->where('EMP_NO',$emp_id)->count();
        if($check > 0){
          $slno_check =  DB::table('emp_initiation_dtl')->where('EMP_NO',$emp_id)->where('slno','!=',"")->count();
          $date_check =  DB::table('emp_initiation_dtl')->where('EMP_NO',$emp_id)->where('initiative_date','!=',"")->count();
          if($slno_check == 0 && $date_check == 0){
            $Intition_user_info = DB::table('emp_initiation_dtl')->where('EMP_NO',$emp_id)->orderBy('id','DESC')->get(); 
          } else {
            if($slno_check > 0 && $date_check > 0){
              $Intition_user_info = DB::table('emp_initiation_dtl')->where('EMP_NO',$emp_id)->orderBy('slno','ASC')->get(); 
            } else {
              if($slno_check > 0 ){
                $Intition_user_info = DB::table('emp_initiation_dtl')->where('EMP_NO',$emp_id)->orderBy('slno','ASC')->get();
              } elseif($date_check > 0){
                $Intition_user_info = DB::table('emp_initiation_dtl')->where('EMP_NO',$emp_id)->orderBy('initiative_date','ASC')->get();
              }else{
                $Intition_user_info = DB::table('emp_initiation_dtl')->where('EMP_NO',$emp_id)->orderBy('id','DESC')->get(); 
              }
            }
          }
        } else {
          $Intition_user_info = DB::table('emp_initiation_dtl')->where('EMP_NO',$emp_id)->orderBy('id','DESC')->get();  
        } 
      return $Intition_user_info;
        }

    public function getAchievementInfo($employee_number) 
      {
        $user = DB::table('emp_mst_live')->where('EMP_NO',$employee_number)->first();
        $emp_no = $user->EMP_NO;
        $emp_id = $user->id;
        $check =  DB::table('emp_achievement_dtl')->where('EMP_NO',$emp_id)->count();
        if($check > 0){
          $slno_check =  DB::table('emp_achievement_dtl')->where('EMP_NO',$emp_id)->where('slno','!=',"")->count();
          $date_check =  DB::table('emp_achievement_dtl')->where('EMP_NO',$emp_id)->where('achievement_date','!=',"")->count();
          if($slno_check == 0 && $date_check == 0){
            $Achievement_user_info = DB::table('emp_achievement_dtl')->where('EMP_NO',$emp_id)->orderBy('id','DESC')->get(); 
          } else {
            if($slno_check > 0 && $date_check > 0){
              $Achievement_user_info = DB::table('emp_achievement_dtl')->where('EMP_NO',$emp_id)->orderBy('slno','ASC')->get(); 
            } else {
              if($slno_check > 0 ){
                $Achievement_user_info = DB::table('emp_achievement_dtl')->where('EMP_NO',$emp_id)->orderBy('slno','ASC')->get();
              } elseif($date_check > 0){
                $Achievement_user_info = DB::table('emp_achievement_dtl')->where('EMP_NO',$emp_id)->orderBy('achievement_date','ASC')->get();
              }else{
                $Achievement_user_info = DB::table('emp_achievement_dtl')->where('EMP_NO',$emp_id)->orderBy('id','DESC')->get(); 
              }
            }
          }
        } else {
          $Achievement_user_info = DB::table('emp_achievement_dtl')->where('EMP_NO',$emp_id)->orderBy('id','DESC')->get();   
        } 
      return $Achievement_user_info;
      }
      public function getappreciationInfo($employee_number) 
        { 
          $user = DB::table('emp_mst_live')->where('EMP_NO',$employee_number)->first();
          $emp_no = $user->EMP_NO;
          $emp_id = $user->id;
          $check =  DB::table('emp_appreciation')->where('EMP_NO',$emp_id)->count();
          if($check > 0){
            $slno_check =  DB::table('emp_appreciation')->where('EMP_NO',$emp_id)->where('slno','!=',"")->count();
            $date_check =  DB::table('emp_appreciation')->where('EMP_NO',$emp_id)->where('order_date','!=',"")->count();
            if($slno_check == 0 && $date_check == 0){
              $appreciation_user_info = DB::table('emp_appreciation')->where('EMP_NO',$emp_id)->orderBy('id','DESC')->get(); 
            } else {
              if($slno_check > 0 && $date_check > 0){
                $appreciation_user_info = DB::table('emp_appreciation')->where('EMP_NO',$emp_id)->orderBy('slno','ASC')->get(); 
              } else {
                if($slno_check > 0 ){
                  $appreciation_user_info = DB::table('emp_appreciation')->where('EMP_NO',$emp_id)->orderBy('slno','ASC')->get();
                } elseif($date_check > 0){
                  $appreciation_user_info = DB::table('emp_appreciation')->where('EMP_NO',$emp_id)->orderBy('order_date','ASC')->get();
                }else{
                  $appreciation_user_info = DB::table('emp_appreciation')->where('EMP_NO',$emp_id)->orderBy('id','DESC')->get(); 
                }
              }
            }
          } else {
            $appreciation_user_info = DB::table('emp_appreciation')->where('EMP_NO',$emp_id)->orderBy('id','DESC')->get(); 
          } 
        return $appreciation_user_info;
        }

       public function getRewardInfo($employee_number) 
          {
            $user = DB::table('emp_mst_live')->where('EMP_NO',$employee_number)->first();
            $emp_no = $user->EMP_NO;
            $emp_id = $user->id;
            $check =  DB::table('emp_reward')->where('EMP_NO',$emp_id)->count();
            if($check > 0){
              $slno_check =  DB::table('emp_reward')->where('EMP_NO',$emp_id)->where('slno','!=',"")->count();
              $date_check =  DB::table('emp_reward')->where('EMP_NO',$emp_id)->where('reorder_date','!=',"")->count();
              if($slno_check == 0 && $date_check == 0){
                $reward_user_info = DB::table('emp_reward')->where('EMP_NO',$emp_id)->orderBy('id','DESC')->get(); 
              } else {
                if($slno_check > 0 && $date_check > 0){
                  $reward_user_info = DB::table('emp_reward')->where('EMP_NO',$emp_id)->orderBy('slno','ASC')->get(); 
                } else {
                  if($slno_check > 0 ){
                    $reward_user_info = DB::table('emp_reward')->where('EMP_NO',$emp_id)->orderBy('slno','ASC')->get();
                  } elseif($date_check > 0){
                    $reward_user_info = DB::table('emp_reward')->where('EMP_NO',$emp_id)->orderBy('reorder_date','ASC')->get();
                  }else{
                    $reward_user_info = DB::table('emp_reward')->where('EMP_NO',$emp_id)->orderBy('id','DESC')->get(); 
                  }
                }
              }
            } else {
              $reward_user_info = DB::table('emp_reward')->where('EMP_NO',$emp_id)->orderBy('id','DESC')->get();  
            } 
           return $reward_user_info;
          }  

          public function getRemark($employee_number) 
          {
            $user = DB::table('emp_mst_live')->where('EMP_NO',$employee_number)->first();
            $emp_no = $user->EMP_NO;
            $emp_id = $user->id;
            $check =  DB::table('emp_remark_dtl')->where('EMP_NO',$emp_no)->count();
            if($check > 0){
              $slno_check =  DB::table('emp_remark_dtl')->where('EMP_NO',$emp_no)->where('slno','!=',"")->count();
              if($slno_check == 0 ){
                $remark_dtl = DB::table('emp_remark_dtl')->where('EMP_NO',$emp_no)->orderBy('id','DESC')->get(); 
              } else {
                $remark_dtl = DB::table('emp_remark_dtl')->where('EMP_NO',$emp_no)->orderBy('slno','ASC')->get(); 
              }
            } else {
              $remark_dtl = DB::table('emp_remark_dtl')->where('EMP_NO',$emp_no)->orderBy('id','DESC')->get();  
            } 
           return $remark_dtl;
          }
}