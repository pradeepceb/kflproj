@extends('Frontend.footer')
@extends('Frontend.master')
@section('content')

<link rel="stylesheet" type="text/css" href="{{url('/public')}}/plugins/table/datatable/datatables.css">
<link rel="stylesheet" type="text/css" href="{{url('/public')}}/plugins/table/datatable/custom_dt_html5.css">
<link rel="stylesheet" type="text/css" href="{{url('/public')}}/plugins/table/datatable/dt-global_style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<style>
   div.dataTables_wrapper div.dataTables_filter input {
        width: 254px;
        height: 47px;
    }
    
    .dataTables_wrapper .dataTables_length select.form-control{
         height: 45px !important;
    }
    
   
</style>
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="account-settings-container mt-1 layout-top-spacing">
            <div class="account-content">

                <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">

                   <!-- Employee view listing table start here -->
                    <div class="row">
                        <div class="col-xl-12 pb-1 col-lg-12 col-md-12 layout-spacing">
                            <div id="general-info" class="section general-info">
                                <div class="info">
                                    <div class="row">
                                        <div class="col-md-11 text-left p-0">
                                            <h6 class="mb-0">Employee Master</h6>
                                        </div>
                                        <div class="col-md-1 mt-1 p-0 float-right">
                                            <button class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-xl" style="margin-bottom: 12px;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="feather feather-plus">
                                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                                </svg> Add 
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 mx-auto">
                                            <div style="overflow-x:auto;">


                                                <table id="zero-config" style="font-size: 8px;" class="table border-none table-hover text-center">
                                                    <thead class="py-2">
                                                        <tr class="py-2">
                                                            <th width="10%">Emp Code</th>
                                                            <th width="15%">Name </th>
                                                            <th width="15%">Father</th>
                                                            <th width="15%">Department</th>
                                                            <th width="10%">Phone no.</th>
                                                            <th width="25%">Address</th>                                                            
                                                            <th width="10%">Action</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($Employee_fetch as $ky=>$val)
                                                        <tr>
                                                            <td width="5%">{{$val->EMP_NO}}</td>
                                                            <td width="15%">{{$val->EMP_NAME}}</td>
                                                            <td width="15%">{{$val->FATHER_NAME}}</td>
                                                            @php
                                                            $Dept_view = DB::table('dept_mst_live')->where('id',$val->DEPT_NO)->first();
                                                            @endphp
                                                            <td width="15%">{{ isset($Dept_view->DEPT_NAME) ? $Dept_view->DEPT_NAME : ""}}</td>
                                                            <td width="10%">{{$val->PH_NO}}</td>
                                                            <td width="25%">{{$val->PRESENT_ADDRESS1}}</br>{{$val->PRESENT_ADDRESS2}}</td>
                                                            
                                                            <td width="5%">
                                                                {{-- <input type="hidden" id="empNunberEditId" value="{{$val->EMP_NO}}"> --}}
                                                                <a href="#" class="mr-2" data-toggle="modal" data-empnumber="{{$val->EMP_NO}}" onclick="employeeEdit(event)">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                                        </path>
                                                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                                        </path>
                                                                    </svg>
                                                                </a>
                                                                <a href="#"> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2" style="color:#c40202;">
                                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                        </path>
                                                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                                                    </svg>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Employee view listing table start here -->

                    <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"> Add New Employee Information Data</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body p-0">

                                    <form onsubmit="return form_validation()" id="general-info" class="section general-info" action="{{url('/')}}/add-employee-master" id="rgform" method="post" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <div class="col-12 py-2 ">

                                            <div class="row" style="margin-top: 25px;">
                                                <div style="margin-top:-30px;" class="col-12 text-center">
                                                    <h5 class="pb-2">Personal Data</h5>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <label class="col-md-1"> Emp<br> Code </label>
                                                <div class="col-md-4" style="margin-left: 46px;">
                                                    <input type="text" class="form-control" name="EMP_NO" id="emp_code">
                                                </div>

                                                <label class="col-md-1"> Type </label>
                                                <div class="col-md-4" style="margin-left: 46px;">
                                                    <select class="form-control" id="exampleFormControlSelect1" name="type" onchange="showfield(this.options[this.selectedIndex].value)" required="">
                                                        <option value="A">Active</option>
                                                        <option value="I">Inactive</option>

                                                    </select>
                                                </div>


                                            </div>

                                            <div class=" row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <label for="inputEmail3" class="col-md-3">Name</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" name="EMP_NAME" id="emp_name">

                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <label class="col-md-3" for="">Address 1 </label>
                                                        <div class="col-md-9">
                                                            <textarea type="text" class="form-control" name="PRESENT_ADDRESS1"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <label class="col-md-3"> City</label>
                                                        <div class="col-md-4">
                                                            <input type="text" class="form-control" name="city">

                                                        </div>
                                                        <label class="col-md-2">pin</label>
                                                        <div class="col-md-3">
                                                            <input type="text" class="form-control" name="pin">

                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <label class="col-md-3"> Date of Birth</label>
                                                        <div class="col-md-4">
                                                            <input type="date" class="form-control" name="DOB">

                                                        </div>
                                                        <label class="col-md-2">Sex(M/F)</label>
                                                        <div class="col-md-3">
                                                            <select name="SEX" id="" class="form-control">
                                                                <option value="">--select option--</option>
                                                                <option value="0">0 - Male</option>
                                                                <option value="1">1 - Female</option>
                                                                <option value="2">Others</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <label for="inputEmail3" class="col-md-3">Father/Husband</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" name="FATHER_NAME">
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <label class="col-md-3" for="">Address 2 </label>
                                                        <div class="col-md-9">
                                                            <textarea type="text" class="form-control" name="PRESENT_ADDRESS2"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <label class="col-md-3"> Phone</label>
                                                        <div class="col-md-4">
                                                            <input type="number" class="form-control" name="PH_NO">
                                                        </div>
                                                        <label class="col-md-2 pl-0">Qualification</label>
                                                        <div class="col-md-3">
                                                            <input type="text" class="form-control" name="QUALIFICATION">
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <label class="col-md-3">Reference</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" name="REFERENCE">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 text-center">
                                                    <h5 class="py-2">Official Data</h5>
                                                </div>
                                            </div>

                                            <div class=" row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <label for="inputEmail3" class="col-md-3">Designation </label>
                                                        <div class="col-md-9">
                                                            @php
                                                            $Designation_view = DB::table('desg_mst_live')->orderby('DESG_NAME')->get();
                                                            @endphp
                                                            <select name="DESG_CODE" class="form-control">
                                                                @foreach($Designation_view as $desg)
                                                                <option value="{{ $desg->id }}">{{ $desg->DESG_NAME }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <label class="col-md-3" for="">Department</label>
                                                        <div class="col-md-9">
                                                            @php
                                                            $Dept_view = DB::table('dept_mst_live')->orderby('id','DESC')->get();
                                                            @endphp
                                                            <?php
                                                            ?>
                                                            <select name="DEPT_NO" class="form-control showdep" onchange="showDepartname(this.value);">
                                                                @foreach($Dept_view as $dept)
                                                                <option value="{{ $dept->id }}">{{ $dept->DEPT_NO }} - {{ $dept->DEPT_NAME }}</option>
                                                                @endforeach
                                                            </select>
                                                            {{-- <p style="font-size:12px; color:blue;" id="departmentView" class="p-0 m-0">Editorial</p> --}}
                                                        </div>
                                                        <label for="" class="col-md-3 pr-0">Sub Department</label>
                                                        <div class="col-md-9">
                                                            @php
                                                            $Dept_view = DB::table('workplace')->orderby('workplace_name')->get();
                                                            @endphp
                                                            <select name="SUB_DPT_WORKPLACE" class="form-control subdepartment_list">
                                                                @foreach($Dept_view as $dept)
                                                                <option value="{{ $dept->id }}">{{ $dept->workplace_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label class="col-md-3"> Card No.</label>
                                                        <div class="col-md-4">
                                                            <input type="text" class="form-control" name="CARD_NO">

                                                        </div>
                                                        <label class="col-md-1 p-0">Card2</label>
                                                        <div class="col-md-4">
                                                            <input type="text" class="form-control" name="CARD_NO2">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row mt-2">
                                                        <label class="col-md-3 pr-0">Date Of Joining</label>
                                                        <div class="col-md-4">
                                                            <input type="date" class="form-control" name="DOJ">
                                                        </div>
                                                        <label class="col-md-2 pr-0">Over Time</label>
                                                        <div class="col-md-3">
                                                            <select class="form-control" id="" name="OVER_TIME">
                                                                <option value="No">No</option>
                                                                <option value="Yes">Yes</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <label class="col-md-3"> Category</label>
                                                        <div class="col-md-9">
                                                            @php
                                                            $Cat_view = DB::table('category')->orderby('category_name')->get();
                                                            @endphp
                                                            <select name="CATG" id="category" class="form-control">
                                                                <option value="">---</option>
                                                                @foreach($Cat_view as $cat)
                                                                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>


                                                        <label class="col-md-3">Group/Employee Type</label>
                                                        <div class="col-md-9">
                                                            @php
                                                            $Emp_view = DB::table('employee_type')->orderby('employee_type_name')->get();
                                                            @endphp
                                                            <select name="EMP_TYPE" id="group" class="form-control">
                                                                <option value="">---</option>
                                                                @foreach($Emp_view as $emptype)
                                                                <option value="{{ $emptype->id }}">{{ $emptype->emp_type_code }} - {{ $emptype->employee_type_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                    </div>

                                                    <div class="row mt-2">
                                                        <label class="col-md-3">Entry Required</label>
                                                        <div class="col-md-4">
                                                            <input type="text" class="form-control" name="ENTRY_REQUIRED">

                                                        </div>
                                                        <label class="col-md-2">LeftOn</label>
                                                        <div class="col-md-3">
                                                            <input type="date" class="form-control" name="LEFTON_DATE">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 text-center">
                                                    <h5 class="py-2">Shift Information</h5>
                                                </div>
                                            </div>
                                            <div class=" row">
                                                <div class="col-md-6">
                                                    <div class="row mt-2">
                                                        <label class="col-md-3" for="">Shift Type</label>
                                                        <div class="col-md-9">
                                                            <select class="form-control" id="shift_type" name="shift_type">
                                                                <option value="">--select shift type--</option>
                                                                <option value="0">0-Fixed</option>
                                                                <option value="1">1-Rotational</option>
                                                            </select>
                                                        </div>

                                                        <label class="col-md-3 mt-2">Week Off</label>
                                                        <div class="col-md-9 mt-2">
                                                            <select class="form-control" id="" name="week_off">
                                                                <option value="0">1- Sunday</option>
                                                                <option value="1">2- Monday</option>
                                                                <option value="2">3- Tuesday</option>
                                                                <option value="3">4- Wednesday</option>
                                                                <option value="4">5- Thursday</option>
                                                                <option value="5">6- Friday</option>
                                                                <option value="6">7- Saturday</option>
                                                            </select>
                                                        </div>




                                                        <div class="col-12">
                                                            <label for="">Second Off</label>
                                                            <table class="days text-center" style="overflow:hidden; height:auto;">
                                                                <thead class="days-thead m-1">

                                                                    <tr>
                                                                        <th>Sl.No</th>

                                                                        <th>Mon</th>
                                                                        <th>Tues</th>
                                                                        <th>Wed</th>
                                                                        <th>Thurs</th>
                                                                        <th>Fri</th>
                                                                        <th>Sat</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="days-tbody" style="height:auto; overflow:hidden;">
                                                                    <tr>
                                                                        <td>1</td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value="" checked></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>2</td>
                                                                        <td><input type="checkbox" id="" name="" value="" checked></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value="" checked></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>3</td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value="" checked></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>4</td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value="" checked></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>5</td>
                                                                        <td><input type="checkbox" id="" name="" value="" checked></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                    </tr>
                                                                </tbody>

                                                            </table>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row mt-2">
                                                        <label for="" class="col-md-3">Shift\Rotation</label>
                                                        <div class="col-md-9">
                                                            <select name="child_cat_id" class="form-control child_cat_id">
                                                                <option value=" ">--select shift--</option>
                                                            </select>
                                                        </div>



                                                        <label class="col-md-2 mt-2">2nd Option</label>
                                                        <div class="col-md-5 mt-2">
                                                            <select class="form-control" id="" name="second_off">
                                                                <option value="0"> 0- None</option>
                                                                <option value="1">1- All Full</option>
                                                                <option value="2">2- All Half</option>
                                                                <option value="3">3- 2nd & 4th</option>
                                                                <option value="4">4- 2nd</option>
                                                                <option value="5">5- 4th</option>
                                                                <option value="6">6- Except 1st & Last</option>
                                                                <option value="7">7- 1st & 3rd</option>
                                                                <option value="8">8- 2nd Half</option>
                                                                <option value="9">9- 1st</option>
                                                                <option value="10">10- 3rd</option>
                                                                <option value="11">11- 1st,3rd&5th</option>
                                                            </select>
                                                        </div>
                                                        <label class="col-md-2">Auto Update</label>
                                                        <div class="col-md-3">
                                                            <select class="form-control" id="" name="AUTO_UPDATE">
                                                                <option value="true">True</option>
                                                                <option value="false">False</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row" style="background-color:#f3f3f3; padding:7px 10px;margin-top:8px;">
                                                <div class="col-12">
                                                    <h5 class="py-2 text-center">Other Information</h5>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <!--<input type="checkbox" style="margin-left: 20px;" id="vehicle2" name="is_regular_employee" value="1">
                                                            <label for="vehicle1">Is Regular Employee</label><br>-->
                                                            <div>
                                                                <input type="checkbox" style="margin-left: 20px;" id="vehicle2" name="eligible_for_ph_if_present" value="1">
                                                                <label for="vehicle2">Eligible for PH If Present</label><br>
                                                                <input type="checkbox" style="margin-left: 40px;" id="vehicle3" name="conciding_with_weekoff" value="1">
                                                                <label for="vehicle3">Coinciding with Week off Applicable</label> <br>
                                                                <input type="checkbox" style="margin-left: 20px;" id="vehicle2" name="eligible_for_ch_if_not" value="1">
                                                                <label for="vehicle2">Eligible for CH if not present</label><br>
                                                                <input type="checkbox" style="margin-left: 20px;" id="vehicle3" name="eligigble_for_PH_if_not_present" value="1">
                                                                <label for="vehicle3">Eligible for PH if not present</label>
                                                            </div>
                                                            <input type="checkbox" id="vehicle2" name="entitled_for_night_shift" value="1">
                                                            <label for="vehicle2">Entitled for Night Shift</label>
                                                        </div>
                                                        <div class="col-md-6">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer p-0">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal fade" tabindex="-1" role="dialog" id="bd-example-modal-lg" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"> Edit Employee Information Data</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body p-0">

                                    <form id="general-info" class="section general-info" action="{{url('/')}}/updateEmployeeDetails" method="post" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <div class="col-12 py-2 ">
                                            <input type="hidden" class="form-control" name="editid" id="edit-id">
                                            <div class="row" style="margin-top: 25px;">
                                                <div style="margin-top:-30px;" class="col-12 text-center">
                                                    <h5 class="pb-2">Personal Data</h5>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <label class="col-md-1"> Emp<br> Code </label>
                                                <div class="col-md-4" style="margin-left: 46px;">
                                                    <input type="text" class="form-control" name="EMP_NO" id="edit-emp_code">
                                                </div>

                                                <label class="col-md-1"> Type </label>
                                                <div class="col-md-4" style="margin-left: 46px;">
                                                    <select class="form-control" id="edit-type" name="type" onchange="showfield(this.options[this.selectedIndex].value)" required="">
                                                        <option value="A">Active</option>
                                                        <option value="I">Inactive</option>
                                                    </select>
                                                </div>


                                            </div>

                                            <div class=" row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <label for="inputEmail3" class="col-md-3">Name</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" name="EMP_NAME" id="edit-emp_name">

                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <label class="col-md-3" for="">Address 1 </label>
                                                        <div class="col-md-9">
                                                            <textarea type="text" class="form-control" id="edit-PRESENT_ADDRESS1" name="PRESENT_ADDRESS1"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <label class="col-md-3"> City</label>
                                                        <div class="col-md-4">
                                                            <input type="text" class="form-control" name="city" id="edit-city">
                                                        </div>
                                                        <label class="col-md-2">pin</label>
                                                        <div class="col-md-3">
                                                            <input type="text" class="form-control" name="pin" id="edit-pin">
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <label class="col-md-3"> Date of Birth</label>
                                                        <div class="col-md-4">
                                                            <input type="date" class="form-control" id="edit-DOB" name="DOB">

                                                        </div>
                                                        <label class="col-md-2">Sex(M/F)</label>
                                                        <div class="col-md-3">
                                                            <select name="SEX" id="edit-SEX" class="form-control">
                                                                <option value="">--select option--</option>
                                                                <option value="0">0 - Male</option>
                                                                <option value="1">1 - Female</option>
                                                                <option value="2">Others</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <label for="inputEmail3" class="col-md-3">Father/Husband</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" id="edit-FATHER_NAME" name="FATHER_NAME">
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <label class="col-md-3" for="">Address 2 </label>
                                                        <div class="col-md-9">
                                                            <textarea type="text" class="form-control" id="edit-PRESENT_ADDRESS2" name="PRESENT_ADDRESS2"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <label class="col-md-3"> Phone</label>
                                                        <div class="col-md-4">
                                                            <input type="number" class="form-control" name="PH_NO" id="edit-PH_NO">
                                                        </div>
                                                        <label class="col-md-2 pl-0">Qualification</label>
                                                        <div class="col-md-3">
                                                            <input type="text" class="form-control" id="edit-QUALIFICATION" name="QUALIFICATION">
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <label class="col-md-3">Reference</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" id="edit-REFERENCE" name="REFERENCE">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 text-center">
                                                    <h5 class="py-2">Official Data</h5>
                                                </div>
                                            </div>

                                            <div class=" row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <label for="inputEmail3" class="col-md-3">Designation </label>
                                                        <div class="col-md-9">
                                                            @php
                                                            $Designation_view = DB::table('desg_mst_live')->orderby('DESG_NAME')->get();
                                                            @endphp
                                                            <select name="DESG_CODE" id="edit-DESG_CODE" class="form-control">
                                                                @foreach($Designation_view as $desg)
                                                                <option value="{{ $desg->id }}">{{ $desg->DESG_NAME }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <label class="col-md-3" for="">Department</label>
                                                        <div class="col-md-9">
                                                            @php
                                                            $Dept_view = DB::table('dept_mst_live')->orderby('id','DESC')->get();
                                                            @endphp
                                                            <?php
                                                            ?>
                                                            <select name="DEPT_NO" id="edit-DEPT_NO" class="form-control showdep" onchange="showDepartname(this.value);">
                                                                @foreach($Dept_view as $dept)
                                                                <option value="{{ $dept->id }}">{{ $dept->DEPT_NO }} - {{ $dept->DEPT_NAME }}</option>
                                                                @endforeach
                                                            </select>
                                                            {{-- <p style="font-size:12px; color:blue;" id="departmentView" class="p-0 m-0">Editorial</p> --}}
                                                        </div>
                                                        <label for="" class="col-md-3 pr-0">Sub Department</label>
                                                        <div class="col-md-9">
                                                            @php
                                                            $Dept_view = DB::table('workplace')->orderby('workplace_name')->get();
                                                            @endphp
                                                            <select name="SUB_DPT_WORKPLACE" id="edit-SUB_DPT_WORKPLACE" class="form-control subdepartment_list">
                                                                @foreach($Dept_view as $dept)
                                                                <option value="{{ $dept->id }}">{{ $dept->workplace_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label class="col-md-3"> Card No.</label>
                                                        <div class="col-md-4">
                                                            <input type="text" class="form-control" id="edit-CARD_NO" name="CARD_NO">

                                                        </div>
                                                        <label class="col-md-1 p-0">Card2</label>
                                                        <div class="col-md-4">
                                                            <input type="text" class="form-control" id="edit-CARD_NO2" name="CARD_NO2">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row mt-2">
                                                        <label class="col-md-3 pr-0">Date Of Joining</label>
                                                        <div class="col-md-4">
                                                            <input type="date" class="form-control" id="edit-DOJ" name="DOJ">
                                                        </div>
                                                        <label class="col-md-2 pr-0">Over Time</label>
                                                        <div class="col-md-3">
                                                            <select class="form-control" id="" name="OVER_TIME">
                                                                <option value="No">No</option>
                                                                <option value="Yes">Yes</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <label class="col-md-3"> Category</label>
                                                        <div class="col-md-9">
                                                            @php
                                                            $Cat_view = DB::table('category')->orderby('category_name')->get();
                                                            @endphp
                                                            <select name="CATG" id="edit-CATG" class="form-control">
                                                                <option value="">---</option>
                                                                @foreach($Cat_view as $cat)
                                                                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>


                                                        <label class="col-md-3">Group/Employee Type</label>
                                                        <div class="col-md-9">
                                                            @php
                                                            $Emp_view = DB::table('employee_type')->orderby('employee_type_name')->get();
                                                            @endphp
                                                            <select name="EMP_TYPE" id="edit-EMP_TYPE" class="form-control">
                                                                <option value="">---</option>
                                                                @foreach($Emp_view as $emptype)
                                                                <option value="{{ $emptype->id }}">{{ $emptype->emp_type_code }} - {{ $emptype->employee_type_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                    </div>

                                                    <div class="row mt-2">
                                                        <label class="col-md-3">Entry Required</label>
                                                        <div class="col-md-4">
                                                            <input type="text" class="form-control" id="edit-ENTRY_REQUIRED" name="ENTRY_REQUIRED">
                                                        </div>
                                                        <label class="col-md-2">LeftOn</label>
                                                        <div class="col-md-3">
                                                            <input type="date" class="form-control" id="edit-LEFTON_DATE" name="LEFTON_DATE">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 text-center">
                                                    <h5 class="py-2">Shift Information</h5>
                                                </div>
                                            </div>
                                            <div class=" row">
                                                <div class="col-md-6">
                                                    <div class="row mt-2">
                                                        <label class="col-md-3" for="">Shift Type</label>
                                                        <div class="col-md-9">
                                                            <select class="form-control" onchange="shifttype()" id="edit-SHIFT_TYPE" name="shift_type">
                                                                <option value="">--select shift type--</option>
                                                                <option value="0">0-Fixed</option>
                                                                <option value="1">1-Rotational</option>
                                                            </select>
                                                        </div>

                                                        <label class="col-md-3 mt-2">Week Off</label>
                                                        <div class="col-md-9 mt-2">
                                                            <select class="form-control" id="edit-week_off" name="week_off">
                                                                <option value="0">0- None</option>
                                                                <option value="1">1- Sunday</option>
                                                                <option value="2">2- Monday</option>
                                                                <option value="3">3- Tuesday</option>
                                                                <option value="4">4- Wednesday</option>
                                                                <option value="5">5- Thursday</option>
                                                                <option value="6">6- Friday</option>
                                                                <option value="7">7- Saturday</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="">Second Off</label>
                                                            <table class="days text-center" style="overflow:hidden; height:auto;">
                                                                <thead class="days-thead m-1">
                                                                    <tr>
                                                                        <th>Sl.No</th>
                                                                        <th>Mon</th>
                                                                        <th>Tues</th>
                                                                        <th>Wed</th>
                                                                        <th>Thurs</th>
                                                                        <th>Fri</th>
                                                                        <th>Sat</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="days-tbody" style="height:auto; overflow:hidden;">
                                                                    <tr>
                                                                        <td>1</td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value="" checked></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>2</td>
                                                                        <td><input type="checkbox" id="" name="" value="" checked></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value="" checked></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>3</td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value="" checked></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>4</td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value="" checked></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>5</td>
                                                                        <td><input type="checkbox" id="" name="" value="" checked></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                        <td><input type="checkbox" id="" name="" value=""></td>
                                                                    </tr>
                                                                </tbody>

                                                            </table>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row mt-2">
                                                        <label for="" class="col-md-3">Shift\Rotation</label>
                                                        <div class="col-md-9">
                                                            <select name="child_cat_id" id="edit-shift_rotation" class="form-control shiftrotation">
                                                                <option value="">--select shift--</option>
                                                            </select>
                                                        </div>



                                                        <label class="col-md-2 mt-2">2nd Option</label>
                                                        <div class="col-md-5 mt-2">
                                                            <select class="form-control" id="edit-second_off" name="second_off">
                                                                <option value="0"> 0- None</option>
                                                                <option value="1">1- All Full</option>
                                                                <option value="2">2- All Half</option>
                                                                <option value="3">3- 2nd & 4th</option>
                                                                <option value="4">4- 2nd</option>
                                                                <option value="5">5- 4th</option>
                                                                <option value="6">6- Except 1st & Last</option>
                                                                <option value="7">7- 1st & 3rd</option>
                                                                <option value="8">8- 2nd Half</option>
                                                                <option value="9">9- 1st</option>
                                                                <option value="10">10- 3rd</option>
                                                                <option value="11">11- 1st,3rd&5th</option>
                                                            </select>
                                                        </div>
                                                        <label class="col-md-2">Auto Update</label>
                                                        <div class="col-md-3">
                                                            <select class="form-control" id="edit-AUTO_UPDATE" name="AUTO_UPDATE">
                                                                <option value="true">True</option>
                                                                <option value="false">False</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row" style="background-color:#f3f3f3; padding:7px 10px;margin-top:8px;">
                                                <div class="col-12">
                                                    <h5 class="py-2 text-center">Other Information</h5>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <!--<input type="checkbox" style="margin-left: 20px;" id="edit-is_regular_employee" name="is_regular_employee" value="1">
                                                            <label for="vehicle1">Is Regular Employee</label><br>-->
                                                            <div>
                                                                <input type="checkbox" style="margin-left: 20px;" id="edit-eligible_for_ph_if_present" name="eligible_for_ph_if_present" value="1">
                                                                <label for="vehicle2">Eligible for PH If Present</label><br>
                                                                <input type="checkbox" style="margin-left: 40px;" id="edit-conciding_with_weekoff" name="conciding_with_weekoff" value="1">
                                                                <label for="vehicle3">Coinciding with Week off Applicable</label> <br>
                                                                <input type="checkbox" style="margin-left: 20px;" id="edit-eligible_for_ch_if_not" name="eligible_for_ch_if_not" value="1">
                                                                <label for="vehicle2">Eligible for CH if not present</label><br>
                                                                <input type="checkbox" style="margin-left: 20px;" id="edit-eligigble_for_PH_if_not_present" name="eligigble_for_PH_if_not_present" value="1">
                                                                <label for="vehicle3">Eligible for PH if not present</label>
                                                            </div>
                                                            <input type="checkbox" id="edit-entitled_for_night_shift" name="entitled_for_night_shift" value="1">
                                                            <label for="vehicle2">Entitled for Night Shift</label>
                                                        </div>
                                                        <div class="col-md-6">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="modal-footer p-0">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>

                                </form>

                            </div>
                        </div>
                    </div>

                    <!-- Add / Edit modal code start here -->
                    <style type="text/css">
                        table.table.border-none.table-hover.text-center tbody {
                            height: 450px;
                            overflow-y: scroll;
                            display: block;
                            overflow-x: hidden;

                        }



                        table.table.border-none.table-hover.text-center thead,
                        table.table.border-none.table-hover.text-center tbody tr {
                            display: table;
                            width: 100%;
                            table-layout: fixed;
                        }

                        table.table.border-none.table-hover.text-center table th,
                        td {}

                        table.table.border-none.table-hover.text-center thead {
                            width: calc(100% - 1em)
                        }

                        table.table.border-none.table-hover.text-center table {
                            border: 0px !important;
                        }

                        table.table.border-none.table-hover.text-center .modal-body label {
                            font-size: 12px;
                        }

                        @media (min-width: 992px) {

                            .modal-lg,
                            .modal-xl {
                                max-width: 1050px !important;
                            }

                            .modal-dialog {
                                margin-top: 0rem !important;
                            }
                        }

                        .days-thead {
                            font-size: 11px;
                            color: blue;
                            background-color: #f8f8f8;
                        }

                        .days {
                            border: 1px solid #ebebeb !important;
                            /* border-radius:5px; */
                        }

                        .popup,
                        .popup1 {
                            height: 25px;
                            border: none;
                            background-color: #94bdff;
                            border-radius: 5px;
                            box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
                        }

                        .popupbox {
                            position: relative;
                        }

                        .popuptext {
                            display: none;
                            width: 180px;
                            background-color: #fff;
                            color: #555;
                            border-radius: 6px;
                            height: 170px;
                            overflow-y: auto;
                            padding: 8px 10px;
                            box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
                            position: absolute;
                            z-index: 1;
                            top: 30%;
                            left: 50%;
                        }

                        .popuptext.open {
                            display: block;
                        }
                    </style>

                    <script>
                        var menuClass = true;
                        $(".popupbox .popup").click(function() {
                            $(".popuptext").removeClass('open');
                            $(this).parents(".popupbox").find(".popuptext").toggleClass('open');
                            menuClass = false;
                        });

                        $(".popuptext").click(function() {
                            menuClass = false;
                        });

                        $("html").click(function() {
                            if (menuClass) {
                                $(".popuptext").removeClass('open');
                            }
                            menuClass = true;
                        });

                        function employeeEdit(event) {
                            var empnunber = event.currentTarget.dataset.empnumber;
                            $.ajax({
                                type: "POST",
                                url: baseUrl + '/employee_edit_master',
                                dataType: "json",
                                data: {
                                    '_token': $('input[name=_token]').val(),
                                    'search_emp': empnunber
                                },
                                success: function(response) {
                                    console.log(response.EmployeeAllInfo);
                                    if (typeof(response) != 'object') {
                                        response = $.parseJSON(response)
                                    }
                                    if (response.status == true) {
                                        $('#bd-example-modal-lg').modal('show');
                                        $('#edit-id').val(response.EmployeeAllInfo.id);
                                        $('#edit-emp_code').val(response.EmployeeAllInfo.EMP_NO);
                                        $('#edit-type').val(response.EmployeeAllInfo.ACTIVE_TYPE).attr("selected", "selected");
                                        $('#edit-emp_name').val(response.EmployeeAllInfo.EMP_NAME);
                                        $('#edit-PRESENT_ADDRESS1').val(response.EmployeeAllInfo.PRESENT_ADDRESS1);
                                        $('#edit-city').val(response.EmployeeAllInfo.CITY);
                                        $('#edit-pin').val(response.EmployeeAllInfo.PIN);
                                        $('#edit-DOB').val(response.EmployeeAllInfo.DOB);
                                        $('#edit-SEX').val(response.EmployeeAllInfo.SEX).attr("selected", "selected");
                                        $('#edit-FATHER_NAME').val(response.EmployeeAllInfo.FATHER_NAME);
                                        $('#edit-PRESENT_ADDRESS2').val(response.EmployeeAllInfo.PRESENT_ADDRESS2);
                                        $('#edit-PH_NO').val(response.EmployeeAllInfo.PH_NO);
                                        $('#edit-QUALIFICATION').val(response.EmployeeAllInfo.qualification);
                                        $('#edit-REFERENCE').val(response.EmployeeAllInfo.reference);
                                        $('#edit-DESG_CODE').val(response.EmployeeAllInfo.DESG_CODE).attr("selected", "selected");
                                        $('#edit-SUB_DPT_WORKPLACE').val(response.EmployeeAllInfo.sub_dpt_workplace).attr("selected", "selected");
                                        $('#edit-CARD_NO').val(response.EmployeeAllInfo.card_no);
                                        $('#edit-CARD_NO2').val(response.EmployeeAllInfo.card_no2);
                                        $('#edit-DOJ').val(response.EmployeeAllInfo.DOJ);
                                        $('#edit-CATG').val(response.EmployeeAllInfo.CATG).attr("selected", "selected");
                                        $('#edit-EMP_TYPE').val(response.EmployeeAllInfo.EMP_TYPE).attr("selected", "selected");
                                        $('#edit-ENTRY_REQUIRED').val(response.EmployeeAllInfo.ENTRY_REQUIRED);
                                        $('#edit-LEFTON_DATE').val(response.EmployeeAllInfo.LEFTON_DATE);
                                        $('#edit-LEFTON_DATE').val(response.EmployeeAllInfo.LEFTON_DATE);
                                        $('#edit-SHIFT_TYPE').val(response.EmployeeAllInfo.shift_type).attr("selected", "selected");
                                        shifttype(response.EmployeeAllInfo.shift_rotaion);
                                        $('#edit-week_off').val(response.EmployeeAllInfo.week_off).attr("selected", "selected");
                                        $('#edit-second_off').val(response.EmployeeAllInfo.week_off).attr("selected", "selected");
                                        $('#edit-AUTO_UPDATE').val(response.EmployeeAllInfo.AUTO_UPDATE).attr("selected", "selected");

                                        if(response.EmployeeAllInfo.is_regular_employee == 1) {
                                            $('#edit-is_regular_employee').prop('checked', true);
                                        }
                                        if (response.EmployeeAllInfo.eligible_for_ph_if_present == 1) {
                                            $('#edit-eligible_for_ph_if_present').prop('checked', true);
                                        }
                                        if (response.EmployeeAllInfo.conciding_with_weekoff == 1) {
                                            $('#edit-conciding_with_weekoff').prop('checked', true);
                                        }
                                        if (response.EmployeeAllInfo.eligible_for_ch_if_not == 1) {
                                            $('#edit-eligible_for_ch_if_not').prop('checked', true);
                                        }
                                        if (response.EmployeeAllInfo.eligigble_for_PH_if_not_present == 1) {
                                            $('#edit-eligigble_for_PH_if_not_present').prop('checked', true);
                                        }
                                        if (response.EmployeeAllInfo.entitled_for_night_shift == 1) {
                                            $('#edit-entitled_for_night_shift').prop('checked', true);
                                        }                            
                                    }
                                }
                            });
                        }
                    </script>
                    <script type="text/javascript">
                        function isNumberKey(evt) {
                            var charCode = (evt.which) ? evt.which : event.keyCode
                            if (charCode > 31 && (charCode < 48 || charCode > 57))
                                return false;
                            return true;
                        }

                        function check_age(d, a, i) {
                            let dob = $("#" + d).val();
                            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                            $.ajax({
                                url: '{{url(' / agecheck ')}}',
                                type: "POST",
                                data: {
                                    '_token': CSRF_TOKEN,
                                    'dob': dob,
                                },
                                success: function(data, textStatus, jQxhr) {
                                    console.clear();
                                    // console.log(data); return;
                                    let ex_data = data.split("_");
                                    $("#" + a).val("").val(ex_data[0]);
                                }
                            })
                        }

                        // $("#general-info").on('submit', function(e){
                        // e.preventDefault();
                        //     $.ajax({
                        //         type: 'POST',
                        //         url: '{{url("/add-employee-master")}}',
                        //         data: new FormData(this),
                        //         dataType: 'json',
                        //         contentType: false,
                        //         cache: false,
                        //         processData:false,
                        //         beforeSend: function(){
                        //             $('#submit-btn').attr("disabled","disabled");
                        //             $('#general-info').css("opacity",".5");
                        //         },
                        //         success: function(response){ 
                        //             console.log();
                        //             console.log(response);
                        //         }
                        //     });
                        // });



                        $('#dtpFrDate').datepicker({
                            dateFormat: 'dd-mm-yy'
                        });
                        $('#dtpFrDate1').datepicker({
                            dateFormat: 'dd-mm-yy'
                        });
                        $('#dtpFrDate2').datepicker({
                            dateFormat: 'dd-mm-yy'
                        });
                        $('#dtpFrDate3').datepicker({
                            dateFormat: 'dd-mm-yy'
                        });
                        $('#dtpFrDate4').datepicker({
                            dateFormat: 'dd-mm-yy'
                        });
                        $('#r_dob').datepicker({
                            dateFormat: 'dd-mm-yy'
                        });
                        $('#current_basic1').datepicker({
                            dateFormat: 'dd-mm-yy'
                        });
                        $('#spouseDOB').datepicker({
                            dateFormat: 'dd-mm-yy'
                        });
                        $('#father_dob').datepicker({
                            dateFormat: 'dd-mm-yy'
                        });
                        $('#mother_dob').datepicker({
                            dateFormat: 'dd-mm-yy'
                        });
                        $('#depent_date').datepicker({
                            dateFormat: 'dd-mm-yy'
                        });
                        $('#f_date').datepicker({
                            dateFormat: 'dd-mm-yy'
                        });
                        $('#t_date').datepicker({
                            dateFormat: 'dd-mm-yy'
                        });
                        $('#mother_dob').datepicker({
                            dateFormat: 'dd-mm-yy'
                        });
                        $('#depent_date').datepicker({
                            dateFormat: 'dd-mm-yy'
                        });
                        $('#f_date').datepicker({
                            dateFormat: 'dd-mm-yy'
                        });
                    </script>


                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
                    <script>
                        var p = 0;

                        function portionDropdown(id) {
                            var portion_id = $('#portionDropdownid' + id).val();
                            console.log(portion_id);
                            if (id >= p) {
                                $('#selectdesignation').val(portion_id);
                                p = id;
                            }
                        }

                        var dept_select = "";

                        function nominee_select(dependent_type, dept_selector) {
                            if (dept_select == "" && dependent_type == "Nominee") {
                                $("#one" + dept_selector + " option[value='Nominee']").attr('selected', true);
                                dept_select = "Nominee";
                            } else if (dept_select != "" && dependent_type == "Nominee") {
                                alert("Nominee has already selected");
                                $("#one" + dept_selector + " option[value='Dependent']").attr('selected', true);
                                $("#one" + dept_selector).prop('selectedIndex', 0);
                            } else if (dept_select != "" && $("#one" + dept_selector + " :selected").text() == "Nominee") {
                                $("#one" + dept_selector + " option[value='Dependent']").attr('selected', true);
                                dept_select = "";
                            }


                            //alert(dependent_type);
                            // if( $("#one"+id).val() == "nominee"){
                            //     $("#one"+id).val('Nominee');
                            //     $(".nominee").html("Dependent");
                            //}


                        }
                        $(document).on('change', '#packageid', function(e) {
                            e.preventDefault();
                            var pkid = $(this).val();
                            //alert(pkid);
                            $.ajax({
                                type: 'POST',
                                url: "{{url('/getPackage')}}",
                                dataType: "json",
                                data: {
                                    '_token': $('input[name=_token]').val(),
                                    'selectedid': pkid
                                },
                                success: function(data) {
                                    if (data != "") {
                                        $('#catch_value').val(data[0].pay_scale);
                                        $('#current_allowance').val(data[0].special_allowance);
                                        $('#initial_allowance').val(data[0].special_allowance);
                                        $('#initial_other').val(data[0].other_special_allowance);
                                        $('#cuurent_other').val(data[0].other_special_allowance);
                                    } else {
                                        $('#catch_value').val("");
                                        $('#current_allowance').val("");
                                        $('#initial_allowance').val("");
                                        $('#initial_other').val("");
                                        $('#cuurent_other').val("");
                                    }

                                }
                            });
                        });



                        function probation(id) {
                            var pkid = $('#probationid' + id).val();
                            //alert(pkid);
                            $('#probationid' + id).val(pkid);
                            $.ajax({
                                type: 'POST',
                                url: "{{url('/getProbation')}}",
                                dataType: "json",
                                data: {
                                    '_token': $('input[name=_token]').val(),
                                    'selectedid': pkid
                                },
                                success: function(data) {
                                    // console.log(data);
                                    $('#promotion_catch_topaygrade_value' + id).val(data[0].pay_scale);
                                    $('#probation_current_allowance' + id).val(data[0].special_allowance);
                                    $('#probation_tocurrentother_allowance' + id).val(data[0].other_special_allowance);
                                }

                            });
                            // alert(id);
                        }

                        function promotion(id) {
                            var pkid = $('#promotionid' + id).val();
                            // alert(pkid);
                            $('#promotionid' + id).val(pkid);
                            $.ajax({
                                type: 'POST',
                                url: "{{url('/getPromotion')}}",
                                dataType: "json",
                                data: {
                                    '_token': $('input[name=_token]').val(),
                                    'selectedid': pkid
                                },
                                success: function(data) {
                                    // console.log(data);
                                    $('#catch_paygrade_value' + id).val(data[0].pay_scale);
                                    $('#promtion_current_allowance' + id).val(data[0].special_allowance);
                                    $('#promtion_currentother_allowance' + id).val(data[0].other_special_allowance);
                                }

                            });
                            // alert(id);
                        }

                        function topromotion(id) {
                            var pkid = $('#promotiontoid' + id).val();
                            $.ajax({
                                type: 'POST',
                                url: "{{url('/gettoPromotion')}}",
                                dataType: "json",
                                data: {
                                    '_token': $('input[name=_token]').val(),
                                    'selectedid': pkid
                                },
                                success: function(data) {
                                    // console.log(data);
                                    $('#catch_topaygrade_value' + id).val(data[0].pay_scale);
                                    $('#promtion_tocurrent_allowance' + id).val(data[0].special_allowance);
                                    $('#promtion_tocurrentother_allowance' + id).val(data[0].other_special_allowance);
                                }

                            });
                        }



                        $(function() {
                            $("#ddlModels").change(function() {
                                if ($(this).val() == 'M') {
                                    $("#spouseName").prop("disabled", false);
                                    $("#spouseDOB").prop("disabled", false);
                                } else {
                                    $("#spouseName").prop("disabled", true);
                                    $("#spouseDOB").prop("disabled", true);
                                }
                            });
                        });

                        function showfield(name) {
                            //   alert(name);
                            if (name != 'A') {
                                $(".r_class").show();
                                $("#reason,#r_dob,#r_txtReason").prop("disabled", false);
                            } else {
                                $(".r_class").hide();
                                $("#reason,#r_dob,#r_txtReason").prop("disabled", true);
                            }

                        }
                    </script>
                    <script type="text/javascript">
                        let i = 5;
                        $("#add_newprobation").click(function() {
                            i++;
                            $("#probationtable").append(`<tr>
    <td>
        <input type="number" class="form-control td1" onkeypress="return isNumberKey(event)" name="prob_slno[]"  >
      </td>
<td><input type="text" class="form-control width" name="prob_order[]"></td>
<td><input type="date" class="form-control"   name="prob_order_date[]"></td>
<td><input type="date" class="form-control"   name="prob_start[]"></td>
<td><input type="date" class="form-control"    name="prob end[]"></td>
<td>
<select class="form-control "  id="probationid${i}" name="pay_grade1[]" style="width: 202px;">
   <option value="">--Select--</option>
       @foreach($pay_grade_view as $ky=>$val)
        <option value="{{$val->id}}">{{$val->pay_grade_desc}}
        </option>
       @endforeach
</select></td>
<td><input type="number" class="form-control width2" name="initial[]" id="promotion_catch_topaygrade_value${i}" style="width: 219px;"></td>
<td><input type="number"  class="form-control width2" name="special_allowance[]"id="probation_current_allowance${i}"  ></td>
<td><input type="number" class="form-control width2" name="other_allownace[]"id="probation_tocurrentother_allowance${i}"  ></td>
<td><textarea rows="3" cols="40" class="form-control width" maxlength="150" name="remark_prob[]"></textarea></td>
<td><input type="file" accept="image/png, image/gif, image/jpeg" name="prob_upload[]"></td>
<td><button type="button" class="deletebtn" title="Remove row">X</button></td></td>
</tr>`);

                        });
                    </script>
                    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
                    <script type="text/javascript">
                        let l = 3356356;
                        $("#add_new").click(function() {
                            l++;
                            $("#e-body").append(`<tr>
    <td><input type="number" onkeypress="return isNumberKey(event)" class="form-control td1" name="depend_snno[]" id="depend_snno${l}"  ></td>    
<td class="td2"><input type="text" class="form-control width" name="name[]" placeholder=""  ></td>
<td><select class="form-control" name="dependent_type[] "style="width: 124px" id="one${l}" onchange="nominee_select(this.value,${l})" >
    <option value="Dependent">Dependent</option>
    <option value="Nominee" >Nominee</option></select></td>
<td><input type="date" class="form-control" name="dob1[]" id="dob_${l}" onchange="check_age('dob_${l}','age_${l}','${l}')" placeholder="enter DOB"></td>
<td><input type="number" onkeypress="return /\d/.test(String.fromCharCode(event.keyCode || event.which))" class="form-control  td1" id="age_${l}"  readonly name="age[]" ></td>
<td class="td2"><input type="text" class="form-control width" name="relation[]" placeholder="enter your relation"></td>
<td  class="td2"><input type="number"  class="form-control width " name="num[]" placeholder="enter adhara" style="width: 206px;"  ></td>
<td><textarea rows="3" cols="40" class="form-control"  name="dependent_addr[]" style="width:200px;"></textarea></td>
<td><input type="file" accept="image/png, image/gif, image/jpeg" class="" placeholder="67%" name="dependent_file[]" multiple></td>

<td>
   <button type="button" class="deletebtn" title="Remove row">X</button>
</td>
</tr>`);
                        });
                        $("#add_newexperience").click(function() {
                            $("#tablexperience").each(function() {
                                var tds = '<tr>';
                                jQuery.each($('tr:last td', this), function() {
                                    tds += '<td>' + $(this).html() + '</td>';
                                });
                                tds += '</tr>';
                                if ($('tbody', this).length > 0) {
                                    $('tbody', this).append(tds);
                                } else {
                                    $(this).append(tds);
                                }
                            });
                        });
                        var j = 4;
                        $("#add_newtransferno").click(function() {
                            j++;
                            $("#table_transfer").append(`<tr>
        <td>
        <input type="number" class="form-control td1" onkeypress="return isNumberKey(event)" name="transfer_snno[]" >
      </td>

    <td><input type="text" class="form-control width" width="130px" name="trans_order[]"></td>
    <td><input type="date"  class="form-control"   width="130px" name="transfer_ord_date[]"></td>
    <td> <select class="form-control width" name="order_type[]" >
        <option value="Transfer">Transfer</option>
        <option value="Deputation">Deputation</option>
    </select></td>

<td><input type="date"  class="form-control"   name="from_date[]"></td>
<td><input type="date" class="form-control" name="to_date[]" ></td>
<td> <select class="form-control width"  name="f_dept[]">
<option value="">select</option>
     @foreach($Department_fetch as $ky=>$val)
    <option value="{{$val->dept_no}}">{{$val->dept_name}}</option>
        @endforeach
  </select>
</td>
<td><select class="form-control width" name="t_dept[]" onchange="transfer(${j})"  id="transferid${j}">
<option value="">select</option>
     @foreach($Department_fetch as $ky=>$val)

    <option value="{{$val->dept_no}}">{{$val->dept_name}}</option>
        @endforeach
  </select></td>
<td><select class="form-control width" name="from_work[]">
<option value="">select</option>
@foreach($Workplace_fetch as $ky=>$val)

     <option value="{{$val->id}}">{{$val->workplace_name}}</option>
 @endforeach
</select></td>
<td><select class="form-control width" name="to_work[]"  onchange="transferWork(${j})"  id="transferWorkid${j}">
<option value="">select</option>
@foreach($Workplace_fetch as $ky=>$val)
     <option value="{{$val->id}}">{{$val->workplace_name}}</option>
 @endforeach
</select></td>

<td> <select class="form-control width"   name="ord_rea[]">
        <option value="">select</option>
        <option>Reward</option>
        <option>Routine</option>
        <option>Displinary</option>
        <option>Other</option>
    </select></td>
<td><textarea rows="3" cols="40" class="form-control width" name="reamrks[]"></textarea></td>
<td><input type="file" accept="image/png, image/gif, image/jpeg" name="trans_file[]" ></td>
<td><button type="button" class="deletebtn" title="Remove row">X</button>   </td>  
                </tr>`);
                            j++;

                        });
                        var v = 0;

                        function transfer(id) {
                            var transfer_id = $('#transferid' + id).val();
                            if (id >= v) {
                                $('#selectdepartment').val(transfer_id);
                                v = id;
                            }
                        }
                        var w = 0;

                        function transferWork(id) {
                            var work_id = $('#transferWorkid' + id).val();
                            console.log(work_id);
                            if (id >= w) {
                                $('#selectWorkplace').val(work_id);
                                w = id;
                            }
                        }

                        var k = 4;
                        $("#add_newpromotion").click(function() {
                            k++;
                            //alert(k);
                            $("#promo_tbl").append(`<tr>
    <td>
        <input type="number" class="form-control td1" onkeypress="return isNumberKey(event)" name="promo_slno[]"  >
      </td>
<td><input type="text" class="form-control width" name="promo_order_no[]"></td>
<td><input type="date" class="form-control" name="promo_date[]"></td>
<td><input type="date" class="form-control" placeholder="13/03/2008" name="effect_date[]"></td>
<td>
<select class="form-control " onchange="promotion(${k})"  id="promotionid${k}" name="from_grade[]" style="width: 202px;">
   <option value="">--Select--</option>
       @foreach($pay_grade_view as $ky=>$val)
        <option value="{{$val->id}}">{{$val->pay_grade_desc}}
        </option>
       @endforeach
</select>
</td>
<td>
    <select class="form-control width"   name="from_design[]">
<option value="">--Select--</option>
 @foreach($Designation as $ky=>$val)
         <option value="{{$val->desg_code}}">{{$val->desg_name}}</option>
   @endforeach
</select>  
    </td>

<td><input type="text" class="form-control width" name="from_basic[]" id='catch_paygrade_value${k}' style="    width: 202px;" ></td>
<td><input type="number"   class="form-control width3" name="from_special[]" id="promtion_current_allowance${k}" ></td>
<td><input type="number"  class="form-control width3" name="from_other_special[]"  id="promtion_currentother_allowance${k}" ></td>
<td> <select class="form-control "  onchange="topromotion(${k})" id="promotiontoid${k}" name="to_grade[]" style="width: 202px;">
   <option value="">--Select--</option>
       @foreach($pay_grade_view as $ky=>$val)
        <option value="{{$val->id}}">{{$val->pay_grade_desc}}
        </option>
       @endforeach
</select>
</td>
<td>
    <select class="form-control width"   name="to_portion[]" onchange="portionDropdown(${k})"  id="portionDropdownid${k}">
<option value="">--Select--</option>
                                    @foreach($Designation as $ky=>$val)
                                              <option value="{{$val->desg_code}}">{{$val->desg_name}}</option>
                                           @endforeach
</select>   
    </td>
<td><input type="text" class="form-control width" name="to_basic[]" id='catch_topaygrade_value${k}' ></td>
<td><input type="number"   class="form-control width3" name="total_allow[]" id="promtion_tocurrent_allowance${k}" ></td>
<td><input type="number"   class="form-control width3" name="to_other_allowance[]" id="promtion_tocurrentother_allowance${k}" ></td>
<td><textarea rows="3" cols="40" class="form-control width" maxlength="150" name="remark[]"></textarea></td>
<td><input type="file" accept="image/png, image/gif, image/jpeg" name="upload_promo[]"></td>
<td><button type="button" class="deletebtn" title="Remove row">X</button></td>
</tr>`);
                        });
                        // $("#add_newprobation").click(function () { 

                        // $("#probationtable").each(function () {

                        //     var tds = '<tr>';
                        //     jQuery.each($('tr:last td', this), function () {
                        //         tds += '<td>' + $(this).html() + '</td>';
                        //     });
                        //     tds += '</tr>';
                        //     if ($('tbody', this).length > 0) {
                        //         $('tbody', this).append(tds);
                        //     } else {
                        //         $(this).append(tds);
                        //     }
                        // });
                        // });
                        $("#add_newqualification").click(function() {
                            $("#new_qualification").each(function() {

                                var tds = '<tr>';
                                jQuery.each($('tr:last td', this), function() {
                                    tds += '<td>' + $(this).html() + '</td>';
                                });
                                tds += '</tr>';
                                if ($('tbody', this).length > 0) {
                                    $('tbody', this).append(tds);
                                } else {
                                    $(this).append(tds);
                                }
                            });
                        });
                        $("#add_newtechnicalqualification").click(function() {
                            $("#new_technicalqualification").each(function() {

                                var tds = '<tr>';
                                jQuery.each($('tr:last td', this), function() {
                                    tds += '<td>' + $(this).html() + '</td>';
                                });
                                tds += '</tr>';
                                if ($('tbody', this).length > 0) {
                                    $('tbody', this).append(tds);
                                } else {
                                    $(this).append(tds);
                                }
                            });
                        });


                        $("#add_new1").click(function() {

                            $("#maintable1").each(function() {

                                var tds = '<tr>';
                                jQuery.each($('tr:last td', this), function() {
                                    tds += '<td>' + $(this).html() + '</td>';
                                });
                                tds += '</tr>';
                                if ($('tbody', this).length > 0) {
                                    $('tbody', this).append(tds);
                                } else {
                                    $(this).append(tds);
                                }
                            });
                        });
                        $("#add_newcontract").click(function() {
                            $("#tablecontract").each(function() {

                                var tds = '<tr>';
                                jQuery.each($('tr:last td', this), function() {
                                    tds += '<td>' + $(this).html() + '</td>';
                                });
                                tds += '</tr>';
                                if ($('tbody', this).length > 0) {
                                    $('tbody', this).append(tds);
                                } else {
                                    $(this).append(tds);
                                }
                            });
                        });
                        $("#add_new4").click(function() {
                            $("#tablerevocation").each(function() {

                                var tds = '<tr>';
                                jQuery.each($('tr:last td', this), function() {
                                    tds += '<td>' + $(this).html() + '</td>';
                                });
                                tds += '</tr>';
                                if ($('tbody', this).length > 0) {
                                    $('tbody', this).append(tds);
                                } else {
                                    $(this).append(tds);
                                }
                            });
                        });
                        $("#add_new5").click(function() {
                            $("#tableappriciation").each(function() {

                                var tds = '<tr>';
                                jQuery.each($('tr:last td', this), function() {
                                    tds += '<td>' + $(this).html() + '</td>';
                                });
                                tds += '</tr>';
                                if ($('tbody', this).length > 0) {
                                    $('tbody', this).append(tds);
                                } else {
                                    $(this).append(tds);
                                }
                            });
                        });
                        $("#add_new6").click(function() {
                            $("#tablereward").each(function() {

                                var tds = '<tr>';
                                jQuery.each($('tr:last td', this), function() {
                                    tds += '<td>' + $(this).html() + '</td>';
                                });
                                tds += '</tr>';
                                if ($('tbody', this).length > 0) {
                                    $('tbody', this).append(tds);
                                } else {
                                    $(this).append(tds);
                                }
                            });
                        });
                        $("#add_new7").click(function() {
                            $("#tableintiation").each(function() {

                                var tds = '<tr>';
                                jQuery.each($('tr:last td', this), function() {
                                    tds += '<td>' + $(this).html() + '</td>';
                                });
                                tds += '</tr>';
                                if ($('tbody', this).length > 0) {
                                    $('tbody', this).append(tds);
                                } else {
                                    $(this).append(tds);
                                }
                            });
                        });
                        $("#add_new8").click(function() {
                            $("#tableachievemnt").each(function() {

                                var tds = '<tr>';
                                jQuery.each($('tr:last td', this), function() {
                                    tds += '<td>' + $(this).html() + '</td>';
                                });
                                tds += '</tr>';
                                if ($('tbody', this).length > 0) {
                                    $('tbody', this).append(tds);
                                } else {
                                    $(this).append(tds);
                                }
                            });
                        });
                    </script>

                    <script>
                        $(document).ready(function() {
                            $("#myInput").on("keyup", function() {
                                var value = $(this).val().toLowerCase();
                                $("#myTable tr").filter(function() {
                                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                                });
                            });
                        });

                        var msg = '{{Session::get('alert ')}}';
                        var exist = '{{Session::has('alert ')}}';
                        if (exist) {
                            alert(msg);
                        }
                    </script>

                    <script type="text/javascript">
                        document.getElementById("one").onchange = function() {
                            document.getElementById("two").setAttribute("disabled", "disabled");
                            if (this.value == 'Nominee')
                                document.getElementById("two").removeAttribute("disabled");
                        };
                    </script>
                    <script>
                        $(document).on('click', 'button.deletebtn', function() {
                            let check = $(this).closest('table').attr('id');
                            let rowCount = $(`#${check} tbody tr`).length;
                            if (rowCount == 1) {} else {
                                $(this).closest('tr').remove();
                            }
                            return false;
                        });
                    </script>

                    <script type="text/javascript">
                        $('#input-payment-egn').keyup(function(e) {
                            if ($(this).val().length === 10) {
                                e.preventDefault();
                                $('#wrong-egn').slideUp();
                            } else {
                                $('#wrong-egn').slideDown();
                            }
                        });
                        $('#input-payment-egn1').keyup(function(e) {
                            if ($(this).val().length === 10) {
                                e.preventDefault();
                                $('#wrong-egn1').slideUp();
                            } else {
                                $('#wrong-egn1').slideDown();
                            }
                        });
                        $('#input-payment-egn2').keyup(function(e) {
                            if ($(this).val().length === 12) {
                                e.preventDefault();
                                $('#wrong-egn2').slideUp();
                            } else {
                                $('#wrong-egn2').slideDown();
                            }
                        });
                        $('#input-payment-egn3').keyup(function(e) {
                            if ($(this).val().length === 12) {
                                e.preventDefault();
                                $('#wrong-egn3').slideUp();
                            } else {
                                $('#wrong-egn3').slideDown();
                            }
                        });
                        // function fetch_payscale(pay_scale) {
                        //   //alert(pay_scale);

                        //   var thisvalue = $("select#pay_grade option:selected").text();
                        //   $('#catch_value').val(pay_scale);
                        //   $('#pay_grade_code_hdn').val(thisvalue);
                        //    $('#initial_allowance').val(thisvalue);



                        //   // $('#catch_value').val(pay_scale);
                        //   //$('#payGrade_id_hdn').val();
                        // }
                        $(document).ready(function() {

                            // Denotes total number of rows
                            var rowIdx = 0;

                            // jQuery button click event to add a row
                            $('#addBtn1').on('click', function() {
                                // Adding a row inside the tbody.


                                $('#e-body1').append(`<tr id="R${rowIdx++}">
             <p>Row ${rowIdx}</p>
             <td>
            <input type="number" class="form-control td1" onkeypress="return isNumberKey(event)" name="cont_slno[]"  >
            </td>
            <td><input type="text" class="form-control width" name="cont_order[]"></td>
            <td><input type="date" class="form-control"   name="cont_order_date[]"></td>
            <td><input type="date" class="form-control"   name="cont_start_date[]"></td>
            <td><input type="date" class="form-control"   name="cont_end_date[]"></td>
            <td><input type="number"   class="form-control width2" name="con_pay[]"></td>
            <td><input type="text" class="form-control width2" name="special[]"></td>
            <td><input type="text" class="form-control width2" name="other[]"></td>
            <td><textarea rows="3" cols="40" class="form-control width" maxlength="150" name="remarks[]"></textarea></td>
            <td><input type="file" accept="image/png, image/gif, image/jpeg" name="cont_file[]"></td>
            <td><button type="button" class="deletebtn" title="Remove row">X</button></td>
</tr>`);
                            });

                            // jQuery button click event to remove a row.
                            $('#e-body').on('click', '.remove', function() {

                                // Getting all the rows next to the row
                                // containing the clicked button
                                var child = $(this).closest('tr').nextAll();

                                // Iterating across all the rows 
                                // obtained to change the index
                                child.each(function() {

                                    // Getting <tr> id.
                                    var id = $(this).attr('id');

                                    // Getting the <p> inside the .row-index class.
                                    var idx = $(this).children('.row-index').children('p');

                                    // Gets the row number from <tr> id.
                                    var dig = parseInt(id.substring(1));

                                    // Modifying row index.
                                    idx.html(`Row ${dig - 1}`);

                                    // Modifying row id.
                                    $(this).attr('id', `R${dig - 1}`);
                                });


                            });
                        });
                    </script>

                    <script type="text/javascript">
                        function form_validation() {
                            var emp_name = $('#emp_name').val();
                            var emp_code = $('#emp_code').val();
                            var selectdepartment = $('#selectdepartment').val();
                            var emp_type = $('#emp_type').val();
                            var selectdesignation = $('#selectdesignation').val();
                            var category = $('#category').val();
                            var selectWorkplace = $('#selectWorkplace').val();
                            var DOB = $('#DOB').val();
                            var email = $('#email').val();
                            var DOJ = $('#DOJ').val();
                            // var vpf_val = $('#vperc_textbox').val();
                            // var esi_val = $('#esiacc').val();
                            // var uan_val = $('#uano').val();
                            if (emp_name == "") {
                                alert("Please enter employee name");
                                $('#emp_name').focus();
                                return false;
                            }
                            if (emp_code == "") {
                                alert("Please enter employee code");
                                $('#emp_code').focus();
                                return false;
                            }
                            if (selectdepartment == "") {
                                alert("Please select department");
                                $('#selectdepartment').focus();
                                return false;
                            }
                            if (emp_type == "") {
                                alert("Please select employee type");
                                $('#emp_type').focus();
                                return false;
                            }
                            if (selectdesignation == "") {
                                alert("Please select desognation");
                                $('#selectdesignation').focus();
                                return false;
                            }
                            if (category == "") {
                                alert("Please select category");
                                $('#category').focus();
                                return false;
                            }
                            if (selectWorkplace == "") {
                                alert("Please select workplace");
                                $('#selectWorkplace').focus();
                                return false;
                            }
                            if (DOB == "") {
                                alert("Please enter date of birth");
                                $('#DOB').focus();
                                return false;
                            }
                            if (DOJ == "") {
                                alert("Please enter date of join");
                                $('#DOJ').focus();
                                return false;
                            }
                            // if(isNaN(vpf_val))
                            // {
                            //     alert("Please enter VPF as number");
                            //     return false; 
                            // }
                            if (!esi_val == "") {
                                if (isNaN(esi_val)) {
                                    alert("Please enter ESI as number");
                                    return false;
                                } else if (esi_val.length < 10) {
                                    alert("ESI no should be 10 digit");
                                    $('#esiacc').focus();
                                    return false;
                                } else if (esi_val.length > 10) {
                                    alert("ESI no should be 10 digit");
                                    $('#esiacc').focus();
                                    return false;
                                }
                            }
                            if (!uan_val == "") {
                                if (isNaN(uan_val)) {
                                    alert("Please enter UAN as number");
                                    return false;
                                } else if (uan_val.length < 12) {
                                    alert("UAN should be 12 digit");
                                    $('#uano').focus();
                                    return false;
                                } else if (uan_val.length > 12) {
                                    alert("UAN should be 12 digit");
                                    $('#uano').focus();
                                    return false;
                                }
                            }
                            if (email == "") {
                                alert("Please enter email id");
                                return false;
                            }
                        }
                    </script>

                    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
                    <script src="{{url('/public')}}/assets/js/libs/jquery-3.1.1.min.js"></script>
                    <script src="{{url('/public')}}/bootstrap/js/popper.min.js"></script>
                    <script src="{{url('/public')}}/bootstrap/js/bootstrap.min.js"></script>
                    <script src="{{url('/public')}}/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
                    <script src="{{url('/public')}}/assets/js/app.js"></script>

                    <script>
                        $(document).ready(function() {
                            App.init();
                        });
                    </script>
                    <script src="{{url('/')}}/public/assets/js/custom.js"></script>
                    <!-- END GLOBAL MANDATORY SCRIPTS -->
                    <script src="{{url('/')}}/public/plugins/table/datatable/button-ext/dataTables.buttons.min.js"></script>
                    <script src="{{url('/')}}/public/plugins/table/datatable/button-ext/jszip.min.js"></script>
                    <script src="{{url('/')}}/public/plugins/table/datatable/button-ext/buttons.html5.min.js"></script>
                    <script src="{{url('/')}}/public/plugins/table/datatable/button-ext/buttons.print.min.js"></script>
                    <script>
                        $('#html5-extension').DataTable({
                            dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
                            buttons: {
                                buttons: [{
                                        extend: 'copy',
                                        className: 'btn'
                                    },
                                    {
                                        extend: 'csv',
                                        className: 'btn'
                                    },
                                    {
                                        extend: 'excel',
                                        className: 'btn'
                                    },
                                    {
                                        extend: 'print',
                                        className: 'btn'
                                    }
                                ]
                            },
                            "oLanguage": {
                                "oPaginate": {
                                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                                },
                                "sInfo": "Showing page _PAGE_ of _PAGES_",
                                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                                "sSearchPlaceholder": "Search...",
                                "sLengthMenu": "Results :  _MENU_",
                            },
                            "stripeClasses": [],
                            "lengthMenu": [7, 10, 20, 50],
                            "pageLength": 7
                        });
                    </script>

                    <!-- BEGIN PAGE LEVEL SCRIPTS -->
                    <script src="public/plugins/table/datatable/datatables.js"></script>
                    <script>
                        $('#zero-config').DataTable({
                            "oLanguage": {
                                "oPaginate": {
                                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                                },
                                "sInfo": "Showing page _PAGE_ of _PAGES_",
                                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                                "sSearchPlaceholder": "Search...",
                                "sLengthMenu": "Results :  _MENU_",
                            },
                            "stripeClasses": [],
                            "lengthMenu": [10, 20, 50,100],
                            "pageLength": 10
                        });
                    </script>
                    <!-- END PAGE LEVEL SCRIPTS -->
                    <!--  BEGIN CUSTOM SCRIPTS FILE  -->

                    <script src="{{ url('/public') }}/assets/js/custom.js"></script>
                    <script src="{{url('/public')}}/plugins/dropify/dropify.min.js"></script>
                    <script src="{{url('/public')}}/plugins/blockui/jquery.blockUI.min.js"></script>
                    <!-- <script src="plugins/tagInput/tags-input.js"></script> -->
                    <script src="{{url('/public')}}/assets/js/users/account-settings.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous"></script>
                    </body>

                    </html>
                    <script>
                        var msg = '{{Session::get('alert ')}}';
                        var exist = '{{Session::has('alert ')}}';
                        var baseUrl = "{{ url('/') }}";
                        if (exist) {
                            alert(msg);
                        }

                        $('.showdep').on('change', (event) => {
                            var getDep = $('.showdep :selected').text();
                            $('#departmentView').text(getDep);
                        });

                        $('#shift_type').change(function() {
                            var cat_id = $(this).val();
                            if (cat_id == 0) {
                                $.ajax({
                                    url: baseUrl + '/view-shift-option/',
                                    type: "GET",
                                    success: function(response) {
                                        if (typeof(response) != 'object') {
                                            response = $.parseJSON(response)
                                        }
                                        var html_option = "<option value=''>----select shift----</option>"
                                        if (response.status) {
                                            var data = response.data;
                                            if (response.data) {
                                                $.each(data, function(key, value) {
                                                    html_option += "<option value='" + value.id + "'>" + value.Scode + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + value.InTime + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + value.outtime + "</option>"
                                                });
                                                $('.child_cat_id').html(html_option);
                                            }
                                        }
                                    }
                                });
                            } else {
                                $.ajax({
                                    url: baseUrl + '/view-shift-rotation-option/',
                                    type: "GET",
                                    success: function(response) {
                                        if (typeof(response) != 'object') {
                                            response = $.parseJSON(response)
                                        }
                                        var html_option = "<option value=''>----select shift rotaion----</option>"
                                        if (response.status) {
                                            var data = response.data;
                                            if (response.data) {
                                                $.each(data, function(key, value) {
                                                    console.log(data);
                                                    html_option += "<option value='" + value.id + "'>" + value.shift_pattern + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + value.monthly + "</option>"
                                                });
                                                $('.child_cat_id').html(html_option);
                                            }
                                        }
                                    }
                                });
                            }
                        });

                        function shifttype(shiftrotaion) {
                            var cat_id = $("#edit-SHIFT_TYPE").val();
                            if (cat_id == 0) {
                                $.ajax({
                                    url: baseUrl + '/view-shift-option/',
                                    type: "GET",
                                    success: function(response) {
                                        if (typeof(response) != 'object') {
                                            response = $.parseJSON(response)
                                        }
                                        var html_option = "<option value=''>----select shift----</option>"
                                        if (response.status) {
                                            var data = response.data;
                                            if (response.data) {
                                                $.each(data, function(key, value) {
                                                    var selected = (value.id == shiftrotaion) ? 'selected' : '';
                                                    html_option += "<option value='" + value.id + "' " + selected + ">" + value.Scode + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + value.InTime + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + value.outtime + "</option>"
                                                });
                                                $('.shiftrotation').html(html_option);
                                            }
                                        }
                                    }
                                });
                            } else {
                                $.ajax({
                                    url: baseUrl + '/view-shift-rotation-option/',
                                    type: "GET",
                                    success: function(response) {
                                        if (typeof(response) != 'object') {
                                            response = $.parseJSON(response)
                                        }
                                        var html_option = "<option value=''>----select shift rotaion----</option>"
                                        if (response.status) {
                                            var data = response.data;
                                            if (response.data) {
                                                $.each(data, function(key, value) {
                                                    var selected = (value.id == shiftrotaion) ? 'selected' : '';
                                                    html_option += "<option value='" + value.id + "' " + selected + ">" + value.shift_pattern + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + value.monthly + "</option>"
                                                });
                                                $('.shiftrotation').html(html_option);
                                            }
                                        }
                                    }
                                });
                            }
                            $('#edit-shift_rotation').val(shiftrotaion).attr("selected", "selected");
                        };
                    </script>
                    @endsection