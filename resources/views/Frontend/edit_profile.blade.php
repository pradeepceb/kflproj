@extends('Frontend.footer')

@extends('Frontend.master')

@section('content')
<?php 
if (isset($_COOKIE['samaj_data'])) { 
  $button = trim($_COOKIE['samaj_data']);
} else {
  $button = "0";
}
?>
 

<style type="text/css">
    #bank
{
    font-size: 13px;
    color: black;
}
#wrong-egn{
  display: none;
  font-size: 12px;
  color: red;
}
#wrong-egn3{
  display: none;
  font-size: 12px;
  color: red;
}
#wrong-egn2{
  display: none;
  font-size: 12px;
  color: red;
}
#wrong-egn1{
  display: none;
  font-size: 12px;
  color: red;
}
.employeemaster{
    color: #f70c0c;
}
#ui-datepicker-div
{
  position: absolute;

    width: 299px;
}
.fa-file-pdf{
  color: #91111a;
}
.fa-file-excel{
  color: #77a957;
}
.fa-file-word{
  color: #6193ca;
}

     .tableFixHead {
        overflow-y: auto;
        height: 350px;
      }
      .tableFixHead thead th {
        position: sticky;
        top: 0;
      }
      .tableFixHead table {
        border-collapse: collapse;
        width: 100%;
      }
      .tableFixHead th,
      .tableFixHead td {
          text-align: center;
        padding:4px; 
        border: 1px solid #ccc;
      }
      .tableFixHead th {
        background: #eee;
        z-index: 9999999999;
      }
      .tableFixHead td{
        z-index: -4;
      }
      .tableFixHead th{
        z-index: 1 !important;
      }
.td2{
  width: 70px;
}
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}


label{
    margin-bottom: 0px !important;
}
</style>

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" />

        <!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
<div class="layout-px-spacing">                

<div class="account-settings-container layout-top-spacing">

<div class="account-content">
<div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
<div class="row">

@php
   use Carbon\Carbon;
    function agecounter($data){
      $user_age = Carbon::parse($data)->diff(Carbon::now())->format('%y');
      //$user_age = Carbon::parse($data)->diff(Carbon::now())->format('%y_%m_%d');
      return $user_age;
    }
@endphp





  <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
  
    <form onsubmit="return form_validation()" id="general-info" class="section general-info"
     action="{{url('/')}}/updateEmployeeDetails" method="post" enctype="multipart/form-data" novalidate>
    
      <div class="form-group" style="text-align: right;color: white;">
        <button type="submit" class="btn btn button1"
          style="background-color: #1b55e2;color:#fff;">
        Save</button>
      </div> 

@if(session()->has('SuccessStatus'))
<div class="alert alert-success alert-dismissible fade show" role="alert" style="color: black; font-size: initial;">
    {{ session()->get('SuccessStatus') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
@endif

    <input type="hidden" class="form-control "  name="emp_id" value="{{ $EmployeeAllInfo->id }}">  
    
    {!! csrf_field() !!}  
    
        <div class="info">
    
        <h6 class="">EMPLOYEE MASTER</h6>
    
        <div class="row">
        <div class="col-lg-11 mx-auto">
            <div class="row">
                 {{-- <div class="col-xl-2 col-lg-12 col-md-4">
                    <div class="upload mt-4 pr-md-4">
                       </div>
                    @if($EmployeeAllInfo->image!="")
                       
                       
                       <input type="file" accept="image/png, image/gif, image/jpeg" id="input-file-max-fs" class="dropify" data-default-file="{{ url('public/image/'.$EmployeeAllInfo->image) }}" data-max-file-size="2M" name="image" />
                          <input type="hidden" name="old_empImage" value="{{$EmployeeAllInfo->image}}">
                                @else
                                
                                <div class="upload mt-4" >
                              <input type="file" accept="image/png, image/gif, image/jpeg" id="input-file-max-fs" class="dropify" data-default-file="{{url('/')}}/public/assets/img/download.jpg" data-max-file-size="2M"  name="image" />
                          </div>
                           @endif
                </div> --}}
    
    <style>
      .hide{
        display: none;
      }
    </style>
    <input type="hidden" name="editid" value="{{ $EmployeeAllInfo->id }}">
                <div class="col-xl-12 col-lg-12 col-md-12 mt-md-0 mt-4">
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="fullName">Employee Code<span class="employeemaster">*</span></label>
                                    <input type="text" class="form-control " id="emp_no"  name="EMP_NO" value="{{ $EmployeeAllInfo->EMP_NO }}" readonly="readonly">
                         <label class="text-danger hide" id="emp_no_label">This field is required </label>
                                </div>
                            </div>
                           <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="fullName">Employee List</label>
                                   <button type="button" class="btn btn-primary " data-toggle="modal" data-target=".bd-example-modal-xl">List</button>
                                  
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <label class="dob-input">Active Type<span class="employeemaster">*</span></label>
                          
                                    <div class="form-group mr-1">
                                        <select class="form-control" id="active_type" name="ACTIVE_TYPE" onchange="showfield(this.value)" 
                                        value ="{{$EmployeeAllInfo->ACTIVE_TYPE }}">
                                          <option <?php if($EmployeeAllInfo->ACTIVE_TYPE == 'A'){ echo "selected"; } else { echo ""; } ?> value="A">Active</option>
                                           <option <?php if($EmployeeAllInfo->ACTIVE_TYPE == 'I'){ echo "selected"; } else { echo ""; } ?> value="I">Inactive</option>
                                        </select>
                                        <div id="div1"></div>
                                      </div>
    
                                     
                                       <div class="form-group mt-2">
                                         <div class="row">
                                           <div class="col-6 r_class " style="display: none">
                                              <select class="form-control" name="inactive_reason" id="reason" >
                                                <option>Select</option>
                                                <option value="Superannuation">Superannuation</option>
                                                <option value= "Resignation">Resignation</option>
                                                <option value= "Termination">Termination</option>
                                                <option value= "Death">Death</option>
                                                <option value= "Illness">Illness</option>
                                                <option value= "Others">Others</option>
                                                
                                              </select>
                                           </div>
                                           <div class="col-6 r_class"  style="display: none">
                                              <input type="date" class="form-control "  
                                              name="inactive_date" value="" id="r_dob" required>
                                           </div>
                                           <div class="col-12 r_class" style="display: none">
                                             <textarea  class="form-control " id="r_txtReason" name="reason_desc" rows="2" cols=""placeholder="describe your reason"></textarea required>
                                           </div>
                                         </div>
                                      </div>
                                      
                                     
    
                               </div>
    
    
                             <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="fullName">Name<span class="employeemaster">*</span></label>
                                    <input type="text" class="form-control " id="emp_name" name="EMP_NAME"  value="{{ $EmployeeAllInfo->EMP_NAME }}" required=""/>
                                    <label class="text-danger hide" id="emp_name_label">This field is required </label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="fullName">Father/Husband<span class="employeemaster">*</span></label>
                                    <input type="text" class="form-control " id="EMP_NO" name="FATHER_NAME"   value="{{ $EmployeeAllInfo->FATHER_NAME }}" required>
                                    <label class="text-danger hide" id="emp_code_label">This field is required </label>
                                </div>
                            </div>


                            <div class="col-sm-4">
                              <div class="form-group">
                                  <label for="fullName">Address1<span class="employeemaster">*</span></label>
                                  <input type="text" class="form-control " id="PRESENT_ADDRESS1" name="PRESENT_ADDRESS1"   value="{{ $EmployeeAllInfo->PRESENT_ADDRESS1 }}" required>
                                  <label class="text-danger hide" id="emp_code_label">This field is required </label>
                              </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                                <label for="fullName">Address2<span class="employeemaster">*</span></label>
                                <input type="text" class="form-control " id="PRESENT_ADDRESS2" name="PRESENT_ADDRESS2"   value="{{ $EmployeeAllInfo->PRESENT_ADDRESS2 }}" required>
                                <label class="text-danger hide" id="emp_code_label">This field is required </label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group">
                              <label for="fullName">City<span class="employeemaster">*</span></label>
                              <input type="text" class="form-control " id="CITY" name="CITY"   value="{{ $EmployeeAllInfo->CITY }}" required>
                              <label class="text-danger hide" id="emp_code_label">This field is required </label>
                          </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                            <label for="fullName">Phone No<span class="employeemaster">*</span></label>
                            <input type="text" class="form-control " id="PH_NO" name="PH_NO"   value="{{ $EmployeeAllInfo->PH_NO }}" required>
                            <label class="text-danger hide" id="emp_code_label">This field is required </label>
                        </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                          <label for="fullName">Qualification<span class="employeemaster">*</span></label>
                          <input type="text" class="form-control " id="QUALIFICATION" name="QUALIFICATION"   value="{{ $EmployeeAllInfo->QUALIFICATION }}" required>
                          <label class="text-danger hide" id="emp_code_label">This field is required </label>
                      </div>
                  </div>
                  <div class="col-sm-4"> 
                    <div class="form-group">
                        <label for="fullName">Date Of Birth<span class="employeemaster">*</span></label>
                      <input  id="DOB" type='date' class="form-control " name="DOB" value="@php
                        if(!$EmployeeAllInfo->DOB=="")
                        echo date('Y-m-d', strtotime($EmployeeAllInfo->DOB));
                      @endphp"required >
                      <label class="text-danger hide" id="dtpFrDate_label">This field is required </label>  

                    </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                      <label for="fullName">Sex(M/F)<span class="employeemaster">*</span></label>

                      <select name="SEX" id="SEX" class="form-control">
                        <option value=" ">--select option--</option>
                        <option value="M" <?php if($EmployeeAllInfo->SEX=='M') { ?>selected<?php } ?>>M - Male</option>
                        <option value="F" <?php if($EmployeeAllInfo->SEX=='F') { ?>selected<?php } ?>>F - Female</option>
                        <option value="O" <?php if($EmployeeAllInfo->SEX=='O') { ?>selected<?php } ?>>Others</option>
                     </select>
                            <label class="text-danger hide" id="department_label">This field is required </label>        
                  </div>
              </div>
              <div class="col-sm-4"> 
                <div class="form-group">
                    <label for="fullName">Reference<span class="employeemaster">*</span></label>
<input  id="REFERENCE" type='text' class="form-control " name="REFERENCE" value="{{$EmployeeAllInfo->REFERENCE}}" required >
                  <label class="text-danger hide" id="dtpFrDate_label">This field is required </label>  
                </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label for="fullName">Designation<span class="employeemaster">*</span></label>
                @php
                  $Designation_view = DB::table('desg_mst_live')->orderby('DESG_NAME')->get(); 
                @endphp
                <select name="DESG_CODE" class="form-control">
                  @foreach($Designation_view as $desg)
                    <option value="{{ $desg->id }}" <?php if($EmployeeAllInfo->DESG_CODE==$desg->id) { ?>selected<?php } ?>>{{ $desg->DESG_NAME }}</option>
                  @endforeach
                </select>
                <label class="text-danger hide" id="designation_label">This field is required </label>
              </div>
            </div>

            <div class="col-sm-4">
              <div class="form-group">
                <label for="fullName">Department<span class="employeemaster">*</span></label>
                @php
                $Dept_view = DB::table('dept_mst_live')->orderby('id','DESC')->get(); 
            @endphp
            <?php 
           ?>
            <select name="DEPT_NO" class="form-control showdep" onchange="showDepartname(this.value);">
                @foreach($Dept_view as $dept)
                    <option value="{{ $dept->id }}" <?php if($EmployeeAllInfo->DEPT_NO==$dept->id){?>selected<?php } ?>>{{ $dept->DEPT_NO }} - {{ $dept->DEPT_NAME }}</option>
                @endforeach
            </select>
                <label class="text-danger hide" id="department_label">This field is required </label>        
              </div>
            </div>


            <div class="col-sm-4">
              <div class="form-group">
                <label for="workplace">Sub Department/Workplace<span class="employeemaster">*</span></label>
                <select class="form-control " id="workplace" name="SUB_DPT_WORKPLACE" required>
                  <option value="">select</option>
                  @foreach($Workplace_fetch as $ky=>$val)
                  <option value="{{$val->id}}"{{$val->id==$EmployeeAllInfo->SUB_DPT_WORKPLACE ? 'selected':''}}>{{$val->workplace_name}}
                  </option>
                @endforeach
                </select>
                <label class="text-danger hide" id="workplace_label">This field is required </label>
              </div>
            </div>

            <div class="col-sm-4">
              <div class="form-group">
              <label for="fullName">Date Of Joining<span class="employeemaster">*</span></label>
              @if($EmployeeAllInfo->DOJ==null)
              <input id="dtpFrDate1" type="date" class="form-control "  name="DOJ"  >
              @else
              <input id="dtpFrDate1" type="date" class="form-control "  name="DOJ"  value="{{date('Y-m-d', strtotime( $EmployeeAllInfo->DOJ)) }}" >
              @endif
              <label class="text-danger hide" id="dtpFrDate1_label">This field is required </label>  
              </div>
            </div>


            <div class="col-sm-4">
              <div class="form-group">
              <label for="fullName">Over Time<span class="employeemaster">*</span></label>
              <select class="form-control" id="" name="OVER_TIME">
                <option value="No" <?php if($EmployeeAllInfo->OVER_TIME=="No") {?>selected<?php } ?>>No</option>
                <option value="Yes" <?php if($EmployeeAllInfo->OVER_TIME=="Yes") {?>selected<?php } ?>>Yes</option>
            </select>
              <label class="text-danger hide" id="dtpFrDate1_label">This field is required </label>  
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
              <label for="category">Category<span class="employeemaster">*</span></label>
              @php
              $Cat_view = DB::table('category')->orderby('category_name')->get(); 
          @endphp
          <select name="CATG" id="category" class="form-control">
              <option value="">---</option>
              @foreach($Cat_view as $cat)
              <option value="{{ $cat->id }}" <?php if($EmployeeAllInfo->CATG==$cat->id) {?>selected<?php } ?>>{{ $cat->category_name }}</option>
          @endforeach
          </select>
              <label class="text-danger hide" id="category_label">This field is required </label>
              </div>
            </div>

            <div class="col-sm-4">
              <div class="form-group">
                <label for="fullName">Group/Employee Type<span class="employeemaster">*</span>
                </label>
                @php
                                    $Emp_view = DB::table('employee_type')->orderby('employee_type_name')->get(); 
                                @endphp
                                <select name="EMP_TYPE" id="group" class="form-control">
                                    <option value="">---</option>
                                    @foreach($Emp_view as $emptype)
                                    <option value="{{ $emptype->id }}" <?php if($EmployeeAllInfo->EMP_TYPE== $emptype->id) {?>selected<?php } ?>>{{ $emptype->emp_type_code }} - {{ $emptype->employee_type_name }}</option>
                                @endforeach
                                </select>
                <label class="text-danger hide" id="emp_type_label">This field is required </label>
              </div>
            </div>

            <div class="col-sm-4"> 
              <div class="form-group">
                  <label for="fullName"> Card No.<span class="employeemaster">*</span></label>
                <input  id="DOB" type='text' class="form-control " name="CARD_NO" value="{{ $EmployeeAllInfo->CARD_NO }}" required >
                <label class="text-danger hide" id="dtpFrDate_label">This field is required </label>  
              </div>
            </div>
            <div class="col-sm-4"> 
              <div class="form-group">
                  <label for="fullName"> Card2<span class="employeemaster">*</span></label>
                <input  id="DOB" type='text' class="form-control " name="CARD_NO2" value="{{ $EmployeeAllInfo->CARD_NO2 }}" required >
                <label class="text-danger hide" id="dtpFrDate_label">This field is required </label>  
              </div>
            </div>
            <div class="col-sm-4"> 
              <div class="form-group">
                  <label for="fullName"> Entry Required<span class="employeemaster">*</span></label>
                <input  id="DOB" type='text' class="form-control " name="ENTRY_REQUIRED" value="{{ $EmployeeAllInfo->ENTRY_REQUIRED }}" required >
                <label class="text-danger hide" id="dtpFrDate_label">This field is required </label>  
              </div>
            </div>
            <div class="col-sm-4"> 
              <div class="form-group">
                  <label for="fullName"> LeftOn<span class="employeemaster">*</span></label>
                <input  id="DOB" type='text' class="form-control " name="LEFTON_DATE" value="{{ $EmployeeAllInfo->LEFTON_DATE }}" required >
                <label class="text-danger hide" id="dtpFrDate_label">This field is required </label>  
              </div>
            </div>

            <div class="col-sm-4"> 
              <div class="form-group">
                  <label for="fullName"> Shift Type<span class="employeemaster">*</span></label>
                  <select class="form-control" id="shift_type" name="shift_type">
                    <option value="">--select an option--</option>
                    <option value="0" <?php if($EmployeeAllInfo->shift_type=='0') { ?>selected<?php } ?>>0-Fixed</option>
                    <option value="1" <?php if($EmployeeAllInfo->shift_type=='1') { ?>selected<?php } ?>>1-Rotational</option>
                </select>
                <label class="text-danger hide" id="dtpFrDate_label">This field is required </label>  
              </div>
            </div>
    
            <div class="col-sm-4"> 
              <div class="form-group">
                  <label for="fullName"> Shift\Rotation<span class="employeemaster">*</span></label>
                  <select name="child_cat_id"  class="form-control child_cat_id">
                    <option value=" ">--select shift--</option>
                </select>
              </div>
            </div>  
            
            <div class="col-sm-4"> 
              <div class="form-group">
                <label for="fullName"> Week Off<span class="employeemaster">*</span></label>
                <select class="form-control" id="" name="week_off">
                  <option value="0" <?php if($EmployeeAllInfo->week_off=='0') { ?>selected<?php } ?>> 0- None</option>
                  <option value="1" <?php if($EmployeeAllInfo->week_off=='1') { ?>selected<?php } ?>>1- Sunday</option>
                  <option value="2" <?php if($EmployeeAllInfo->week_off=='2') { ?>selected<?php } ?>>2- Monday</option>
                  <option value="3" <?php if($EmployeeAllInfo->week_off=='3') { ?>selected<?php } ?>>3- Tuesday</option>
                  <option value="4" <?php if($EmployeeAllInfo->week_off=='4') { ?>selected<?php } ?>>4- Wednesday</option>
                  <option value="5" <?php if($EmployeeAllInfo->week_off=='5') { ?>selected<?php } ?>>5- Thursday</option>
                  <option value="6" <?php if($EmployeeAllInfo->week_off=='6') { ?>selected<?php } ?>>6- Friday</option>
                  <option value="7" <?php if($EmployeeAllInfo->week_off=='7') { ?>selected<?php } ?>>7- Saturday</option>
              </select>
              </div> 
            </div> 

            <div class="col-sm-4"> 
              <div class="form-group">
                <label for="fullName"> 2nd Option<span class="employeemaster">*</span></label>
                <select class="form-control" id="" name="second_off">
                  <option value="0" <?php if($EmployeeAllInfo->second_off=='0') { ?>selected<?php } ?>> 0- None</option>
                  <option value="1" <?php if($EmployeeAllInfo->second_off=='1') { ?>selected<?php } ?>>1- All Full</option>
                  <option value="2" <?php if($EmployeeAllInfo->second_off=='2') { ?>selected<?php } ?>>2- All Half</option>
                  <option value="3" <?php if($EmployeeAllInfo->second_off=='3') { ?>selected<?php } ?>>3- 2nd  &amp; 4th</option>
                  <option value="4" <?php if($EmployeeAllInfo->second_off=='4') { ?>selected<?php } ?>>4- 2nd</option>
                  <option value="5" <?php if($EmployeeAllInfo->second_off=='5') { ?>selected<?php } ?>>5- 4th</option>
                  <option value="6" <?php if($EmployeeAllInfo->second_off=='6') { ?>selected<?php } ?>>6- Except 1st &amp; Last</option>
                  <option value="7" <?php if($EmployeeAllInfo->second_off=='7') { ?>selected<?php } ?>>7- 1st &amp; 3rd</option>
                  <option value="8" <?php if($EmployeeAllInfo->second_off=='8') { ?>selected<?php } ?>>8- 2nd Half</option>
                  <option value="9" <?php if($EmployeeAllInfo->second_off=='9') { ?>selected<?php } ?>>9- 1st</option>
                  <option value="10" <?php if($EmployeeAllInfo->second_off=='10') { ?>selected<?php } ?>>10- 3rd</option>
                  <option value="11" <?php if($EmployeeAllInfo->second_off=='11') { ?>selected<?php } ?>>11- 1st,3rd&amp;5th</option>
              </select>
              </div> 
            </div> 


            <div class="col-sm-4"> 
              <div class="form-group">
                <label for="fullName"> Auto Update<span class="employeemaster">*</span></label>
                <select class="form-control" id="" name="AUTO_UPDATE">
                  <option value="true" <?php if($EmployeeAllInfo->AUTO_UPDATE=='true') { ?>selected<?php } ?>>True</option>
                  <option value="false" <?php if($EmployeeAllInfo->AUTO_UPDATE=='false') { ?>selected<?php } ?>>False</option>
              </select>
              </div> 
            </div> 
             </div>
                       
                                    <div class="row" style="background-color:#f3f3f3; padding:7px 10px;margin-top:8px;">
                                      <div class="col-12">
                                          <h5 class="py-2 text-center">Other Information</h5>
                                          <div class="row">
                                              <div class="col-md-6">
                                                 <input type="checkbox" style="margin-left: 20px;" id="vehicle2"
                                                          name="is_regular_employee" <?php if($EmployeeAllInfo->is_regular_employee=='1') { ?>checked<?php } ?> value="1">
                                                  <label for="vehicle1">Is Regular Employee</label><br>
                                                  <div>
                                                      <input type="checkbox" style="margin-left: 20px;" id="vehicle2"
                                                          name="eligible_for_ph_if_present" <?php if($EmployeeAllInfo->eligible_for_ph_if_present=='1') { ?>checked<?php } ?> value="1">
                                                      <label for="vehicle2">Eligible for PH If Present</label><br>
                                                      <input type="checkbox" style="margin-left: 40px;" id="vehicle3"
                                                          name="conciding_with_weekoff" <?php if($EmployeeAllInfo->conciding_with_weekoff=='1') { ?>checked<?php } ?> value="1">
                                                      <label for="vehicle3">Coinciding with Week off Applicable</label> <br>
                                                      <input type="checkbox" style="margin-left: 20px;" id="vehicle2"
                                                          name="eligible_for_ch_if_not" <?php if($EmployeeAllInfo->eligible_for_ch_if_not=='1') { ?>checked<?php } ?> value="1">
                                                      <label for="vehicle2">Eligible for CH if not present</label><br>
                                                      <input type="checkbox" style="margin-left: 20px;" id="vehicle3"
                                                          name="eligigble_for_PH_if_not_present" 
                                                          <?php if($EmployeeAllInfo->eligigble_for_PH_if_not_present=='1') { ?>checked<?php } ?> value="1">
                                                      <label for="vehicle3">Eligible for PH if not present</label>
                                                  </div>
                                                  <input type="checkbox" id="vehicle2" name="entitled_for_night_shift" <?php if($EmployeeAllInfo->entitled_for_night_shift=='1') { ?>checked<?php } ?> value="1">
                                                  <label for="vehicle2">Entitled for Night Shift</label>
                                              </div>
                                              <div class="col-md-6">
                                                 
                                              </div>
                                          </div>
                                      </div>
                                  </div>


                                    
                                   </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>
    
                 <script>
      
                  var emp_type = document.getElementById('emp_type');
    
                  var DOP = document.getElementById('dtpFrDate2');
                  var DOC = document.getElementById('dtpFrDate3');
                  var retirement = document.getElementById('dtpFrDate4');
                  
                  var dop_div = document.getElementById('dop_div');
                  var doc_div = document.getElementById('doc_div');
                  var retire_div = document.getElementById('retire_div');
                  
                  function check(){
                      if(emp_type.value=="CO"){
                          DOP.removeAttribute("required");
                          dop_div.innerHTML="";
                          DOC.removeAttribute("required");
                          doc_div.innerHTML="";
                          retirement.setAttribute("disabled", "disabled");
                          retire_div.innerHTML="";
                      }else if(emp_type.value=="PR"){
                          DOP.setAttribute("required", "required");
                          dop_div.innerHTML="*";
                          DOC.removeAttribute("required");
                          doc_div.innerHTML="";
                          retirement.removeAttribute("disabled");
                          retirement.removeAttribute("required");
                          retire_div.innerHTML="";
                      }else if(emp_type.value=="PE"){
                          // DOP.setAttribute("required", "required");
                          // dop_div.innerHTML="*";
                          // DOP.value="";
                          DOP.removeAttribute("required");
                          dop_div.innerHTML="";
                          DOC.setAttribute("required", "required");
                          doc_div.innerHTML="*";
                          retirement.removeAttribute("disabled");
                          retirement.setAttribute("required", "required");
                          retire_div.innerHTML="*";
                      } else {
                          DOP.setAttribute("required", "required");
                          DOC.setAttribute("required", "required");
                          retirement.removeAttribute("disabled");
                          retirement.removeAttribute("required");
                          dop_div.innerHTML="";
                          doc_div.innerHTML="";
                          retire_div.innerHTML="";
                      }
                  }
                  </script>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>



<script type="text/javascript">
var main_url = `{{ url('/')}}`;
function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
        return true;
}


 function storetype(type){
  window.localStorage.clear();
  var expires = "";
  var date = new Date();
  let data = {"lastbtn":type,"date": date};

  window.localStorage.setItem("samaj_data", JSON.stringify(data));
  date.setTime(date.getTime() + (1 * 24 * 60 * 60 * 1000));
  expires = "; expires=" + date.toUTCString();
  document.cookie = "samaj_data" + "=" + (type || "") + expires + "; path=/";
 }



function openmodal(url){
  let checkType = url.split(".")
  // let num = checkType.slice(-1);
  let num = checkType.length-1;
  let forimg = document.getElementById("set_img_url");
  let fordoc = document.getElementById("set_doc_url");
  if(!url==""){
      if(checkType[num]=="pdf"){
        fordoc.removeAttribute("src");
        fordoc.setAttribute("src",`${main_url}/${url}`);
        $("#docModal").modal('show');
      } else {
        forimg.removeAttribute("src");
        forimg.setAttribute("src",`${main_url}/${url}`);
        $("#exampleModal").modal('show');
      }
  }
}
</script>
 
  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript">
    function form_validation(){
      var emp_no = $('#emp_no').val();
      var active_type = $('#active_type').val();
      var emp_name = $('#emp_name').val();
      var emp_code = $('#emp_code').val();
      var department = $('#department').val();
      var emp_type = $('#emp_type').val();
      var designation = $('#designation').val();
      var category = $('#category').val();
      var workplace = $('#workplace').val();
      var DOB = $('#DOB').val();
      var DOJ = $('#dtpFrDate1').val();
      var DOP = $('#dtpFrDate2').val();
      var DOC = $('#dtpFrDate3').val();
      var retirement_date = $('#dtpFrDate4').val();
      var vpf_val = $('#vperc_textbox').val();
      var esi_val = $('#esiacc').val();
      var uan_val = $('#uano').val();
      var email = $('#email').val();
      if(emp_no==""){
        $('#emp_no').focus();
        $("#emp_no_label").css('display','block');
        return false; 
      } else {
        $("#emp_no_label").css('display','none');
      }
      if(active_type==""){
        $('#active_type').focus();
        return false; 
      }
      if(emp_name==""){
        $('#emp_name').focus();
        $("#emp_name_label").css('display','block');
        return false; 
      }else {
        $("#emp_name_label").css('display','none');
      }
      if(emp_code==""){
        $('#emp_code').focus();
        $("#emp_code_label").css('display','block');
        return false; 
      }else {
        $("#emp_code_label").css('display','none');
      }
      if(department==""){
        $('#department').focus();
        $("#department_label").css('display','block');
        return false; 
      }else {
        $("#department_label").css('display','none');
      }
      if(emp_type==""){
        $('#emp_type').focus();
        $("#emp_type_label").css('display','block');
        return false; 
      }else {
        $("#emp_type_label").css('display','none');
      }
      if(designation==""){
        $('#designation').focus();
        $("#designation_label").css('display','block');
        return false; 
      }else {
        $("#designation_label").css('display','none');
      }
      if(category==""){
        $('#category').focus();
        $("#category_label").css('display','block');
        return false; 
      }else {
        $("#category_label").css('display','none');
      }
      if(workplace==""){
        $('#workplace').focus();
        $("#workplace_label").css('display','block');
        return false; 
      }else {
        $("#workplace_label").css('display','none');
      }

      if(DOB==""){
        $('#DOB').focus();
        $("#dtpFrDate_label").css('display','block');
        return false; 
      }else {
        $("#dtpFrDate_label").css('display','none');
      }

      if(emp_type=="CO"){
        //   if(DOJ==""){
        //   $('#dtpFrDate1').focus();
        //   $("#dtpFrDate1_label").css('display','block');
        //   return false; 
        // }else {
        //   $("#dtpFrDate1_label").css('display','none');
        // }
        // if(DOC==""){
        //   $('#dtpFrDate3').focus();
        //   $("#dtpFrDate3_label").css('display','block');
        //   return false; 
        // }else {
        //   $("#dtpFrDate3_label").css('display','none');
        // }
      }else if(emp_type=="PR"){
          if(DOP==""){
          $('#dtpFrDate2').focus();
          $("#dtpFrDate2_label").css('display','block');
          return false; 
        }else {
          $("#dtpFrDate2_label").css('display','none');
        }
      }else if(emp_type=="PE"){
        if(DOC==""){
          $("#doc_div").html("*");
          $('#dtpFrDate3').focus();
          $("#dtpFrDate3_label").css('display','block');
          return false; 
        }else {
          $("#dtpFrDate3_label").css('display','none');
        }
        // if(DOP==""){
        //   $('#dtpFrDate2').focus();
        //   $("#dtpFrDate2_label").css('display','block');
        //   return false; 
        // }else {
        //   $("#dtpFrDate2_label").css('display','none');
        // }
        if(retirement_date==""){
          $("#retire_div").html("*");
        $('#dtpFrDate4').focus();
        $("#dtpFrDate4_label").css('display','block');
        return false; 
      }else {
        $("#dtpFrDate4_label").css('display','none');
      }
      }
     
     if(DOJ==""){
          $('#dtpFrDate1').focus();
          $("#dtpFrDate1_label").css('display','block');
          return false; 
        }else {
          $("#dtpFrDate1_label").css('display','none');
        }
      
       
      if(!esi_val==""){
        if(isNaN(esi_val))
        {
            alert ("Please enter ESI as number");
            return false; 
        } else if(esi_val.length < 10){
            alert ("ESI no should be 10 digit");
            $('#esiacc').focus();
            return false; 
        } else if(esi_val.length > 10){
            alert ("ESI no should be 10 digit");
            $('#esiacc').focus();
            return false; 
        }
      }
      if(!uan_val==""){
        if(isNaN(uan_val))
        {
            alert ("Please enter UAN as number");
            return false; 
        } else if(uan_val.length < 12){
            alert ("UAN should be 12 digit");
            $('#uano').focus();
            return false; 
        } else if(uan_val.length > 12){
            alert ("UAN should be 12 digit");
            $('#uano').focus();
            return false; 
        }
      }
      let aadhar = $("#input-payment-egn3").val();
      if(!aadhar==""){ 
            // alert ("Please enter aadhaar no");
            // $('#input-payment-egn3').focus();
            // return false;
          if(isNaN(aadhar)) {
              alert ("Please enter aadhaar no as number");
              $('#input-payment-egn3').focus();
              return false; 
          } else if(aadhar.length < 12){
              alert ("Aadhaar no should be 12 digit");
              $('#uinput-payment-egn3ano').focus();
              return false; 
          } else if(aadhar.length > 12){
              alert ("Aadhaar no should be 12 digit");
              $('#input-payment-egn3').focus();
              return false; 
          }
      }
      if(email=="")
        {
            alert("Please enter email id");
            return false; 
        }

    }
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>

 $(document).on('click', 'button.deletebtn', function () {
     $(this).closest('tr').remove();
     return false;
 });
</script>


<script>
            
$(document).ready(function(){
$("#myInput").on("keyup", function() {
var value = $(this).val().toLowerCase();
$("#myTable tr").filter(function() {
$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
});
});
});

    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
      alert(msg);
    }
  </script>
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{url('/')}}/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="{{url('/')}}/bootstrap/js/popper.min.js"></script>
    <script src="{{url('/')}}/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{url('/')}}/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="{{url('/')}}/assets/js/app.js"></script>
    
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="{{url('/')}}/assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->



    <script src="{{url('/')}}/public/plugins/dropify/dropify.min.js"></script>

    <!-- <script src="plugins/tagInput/tags-input.js"></script> -->
    <script src="{{url('/')}}/public/assets/js/users/account-settings.js"></script>
    <script>
    $('#shift_type').change(function(){
      var cat_id=$(this).val();
      if(cat_id =='0'){
        // Ajax call
        $.ajax({
          url:"/view-shift-option/",
          type:"GET",
          success:function(response){
            if(typeof(response) !='object'){
              response=$.parseJSON(response)
            }
            var html_option="<option value=''>----select shift----</option>"
            if(response.status){
              var data=response.data;
              if(response.data){
                $.each(data,function(key, value){
                  html_option +="<option value='"+value.id+"'>"+value.Scode+ "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" +value.InTime+ "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" +value.outtime+"</option>"
                });
                $('.child_cat_id').html(html_option);
              }
            }
          }
        });
      }
      else{
        $.ajax({
          url:"/view-shift-rotation-option/",
          type:"GET",
          success:function(response){
            if(typeof(response) !='object'){
              response=$.parseJSON(response)
            }
            var html_option="<option value=''>----select shift rotaion----</option>"
            if(response.status){
              var data=response.data;
              if(response.data){
                $.each(data,function(key, value){
                  console.log(data);
                  html_option +="<option value='"+value.id+"'>"+value.code+ "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" +value.shift_pattern+ "</option>"
                });
                $('.child_cat_id').html(html_option);
              }
            }
          }
        });
      }
    })
    </script>
</body>
</html>
@endsection