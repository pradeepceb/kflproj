<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Board;
use App\Workplace;
use App\Department_master;
use App\Designation;
use App\Pay_grade_master;
use App\Bank;
use App\Emp_mst_live;
use App\emp_official;
use App\Category;
use App\Employee_type;
use App\LeaveCode;
use App\OptionView;
use App\HolidayEntry;
use App\HolidayDeclaration;
use App\Nominee;
use App\Dependent;
use App\Qualification;
use App\Experience;
use App\Shift;
use App\ShiftRotation;
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
use App\MonthlyShiftGenerate;
use App\ZKLibrary;
use App\Attendance;
use Carbon\Carbon;
use Response;
use DB;
use Cache;
use File;
use Auth;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }
  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    Cache::flush();
    return view('home');
  }
  /*Department Master detail(master page)*/
  public function Department_Master_view(Request $request)
  {
    $Department_view = DB::table('dept_mst_live')
      ->orderby('id', 'desc')
      ->paginate(18);
    return view('Frontend.department-master', ['Department_view' => $Department_view]);
  }

  public function Add_Department(Request $request)
  {
    $Add_Department1 = new Department_master();
    $Add_Department_deptno = $request->dept_no;
    $Add_Department = $request->dept_name;
    $add_dept_zero = "0{$Add_Department_deptno}";
    $Add_Department1->dept_no = $add_dept_zero;
    $Add_Department1->dept_name = $Add_Department;
    $isExist = Department_master::select("*")
      ->where("dept_name", $Add_Department)
      ->exists();
    if ($isExist) {
      return redirect()->back()->with('alert', 'the department is already exsits');
    } else {
      $Add_Department1->save();
    }
    return redirect('/department-master');
  }

  public function Update_Department_Data(Request $request)
  {
    $dept_id   = $request->dept_id;
    $dept_no   = $request->dept_no;
    $dept_name = $request->dept_name;
    $dept_fetch = array(
      'dept_no'   => $dept_no,
      'dept_name' => $dept_name
    );
    $update_Data = DB::table('dept_mst_live')
      ->where('id', $dept_id)
      ->update($dept_fetch);
    return redirect('/department-master');
  }
  public function Delete_Department_data($id)
  {
    $Department_data_all = Department_master::find($id);
    $Department_data_all->delete();
    return redirect('/department-master');
  }
  /*Designation detail(master page)*/
  public function Designation_Master_view(Request $request)
  {
    $Designation_view = DB::table('desg_mst_live')->orderby('id', 'desc')->paginate(18);
    return view('Frontend.designation-master', ["Designation_view" => $Designation_view]);
  }

  public function Add_Designation_Master(Request $request)
  {
    $Add_Designation = new Designation();
    $Add_Designation_code = $request->desg_code;
    $Add_Designation_name = $request->desg_name;
    $Add_Designation->DESG_CODE =  $Add_Designation_code;
    $Add_Designation->DESG_NAME = $Add_Designation_name;
    $isExist = Designation::select("*")->where("desg_name", $Add_Designation_name)->exists();
    if ($isExist) {
      return redirect()->back()->with('alert', 'the designation is already exsits');
    } else {
      $Add_Designation->save();
    }
    return redirect('/designation-master');
  }
  public function Update_Designation_data(Request $request)
  {
    $desg_id    = $request->desg_id;
    $desg_code  = $request->desg_code;
    $desg_name  = $request->desg_name;
    $desg_fetch = array(
      'DESG_CODE' => $desg_code,
      'DESG_NAME' => $desg_name
    );
    $update_Data = DB::table('desg_mst_live')->where('id',  $desg_id)
      ->update($desg_fetch);
    return redirect('/designation-master');
  }

  public function Delete_Designation_data($id)
  {
    $Designation_data_all = Designation::find($id);
    $Designation_data_all->delete();
    return redirect('/designation-master');
  }

  /*Shift Master detail(master page)*/
  public function Shift_Master_view(Request $request)
  {
    $Shift_view = Shift::orderBy('id', 'DESC')->paginate(18);
    return view('Frontend.shift-master', ['Shift_view' => $Shift_view]);
  }
  public function Add_Shift(Request $request)
  {
    $shiftCode = Shift::where('Scode', $request->Scode)->exists();
    $shift = Shift::where('Scode', $request->Scode)->where('InTime', $request->InTime)->exists();

    if($shiftCode) {
      return redirect()->back()->with('alert', 'Shift code already exists');
    } else {
      if($shift){
        return redirect()->back()->with('alert', 'Shift already exists');
      } else {        
        $mdata['Scode']   = $request->Scode;
        $mdata['InTime']  = $request->InTime;
        $mdata['outtime'] = $request->outtime;
        $mdata['Rstin']   = $request->RstOut;
        $mdata['RstOut']  = $request->Rstin;
        $mdata['Rsthrs']  = $request->Rsthrs;
        $mdata['Wrkhrs']  = $request->Wrkhrs;
        $mdata['HdStart'] = $request->HdStart;
        $mdata['HdEnd']   = $request->HdEnd;

        $status = Shift::create($mdata);

        if ($status) {
          return redirect()->back()->with('alert', 'New Shift added successfully');
          return redirect('/shift-master');
        } else {
          return redirect()->back()->with('alert', 'There is some issue. Please check.');
        }
      }
    }
    
  }
  public function Update_Shift_Data(Request $request)
  {
    $id = $request->shift_id;
    $shift = Shift::findOrFail($id);

    $mdata['Scode']   = $request->Scode;
    $mdata['InTime']  = $request->InTime;
    $mdata['outtime'] = $request->outtime;
    $mdata['Rstin']   = $request->RstOut;
    $mdata['RstOut']  = $request->Rstin;
    $mdata['Rsthrs']  = $request->Rsthrs;
    $mdata['Wrkhrs']  = $request->Wrkhrs;
    $mdata['HdStart'] = $request->HdStart;
    $mdata['HdEnd']   = $request->HdEnd;

    $status = $shift->fill($mdata)->save();
    if ($status) {
      return redirect()->back()->with('alert', 'Shift details updated successfully');
      return redirect('/shift-master');
    } else {
      return redirect()->back()->with('alert', 'There is some issue. Please check.');
    }
  }
  public function Delete_Shift_data($id)
  {
    $Shift_data_all = Shift::find($id);
    $Shift_data_all->delete();
    return redirect('/shift-master');
  }
  /*Shift Master details end here*/

  /*Shift Rotation Master detail start here */
  public function Shift_Rotation_Master_view(Request $request)
  {

    $Shift_view = Shift::orderBy('id', 'DESC')->paginate(18);
    $Shift_Rotaion_view = ShiftRotation::orderBy('id', 'DESC')->paginate(18);

    return view('Frontend.shift-rotation-master', ['Shift_Rotaion_view' => $Shift_Rotaion_view, 'Shift_view' => $Shift_view]);
  }
  public function Add_Shift_Rotation(Request $request)
  {
    $data = $request->all();
    $data['shift_pattern'] = implode(',', $data['shift_pattern']);

    $status = ShiftRotation::create($data);
    if ($status) {
      return response()->json([
        'status' => "success",
        'message' => 'New Shift Rotation Added Successfully',
      ]);
    } else {
      return response()->json([
        'status' => "failed",
        'message' => 'There is some issue. Please check.',
      ]);
    }
  }
  public function Update_Shift_Rotation_Data(Request $request)
  {
    $id                     = $request->shift_rotation_id;
    $shift                  = ShiftRotation::findOrFail($id);
    $mdata['code']          = $request->input('code');
    $mdata['shift_pattern'] = implode(',', $request['shift_pattern']);
    $mdata['monthly']       = $request->input('monthly');
    $mdata['skip_pattern']  = $request->input('skip_pattern');

    $status = DB::table('tms_shift_rotation')->where('id',  $id)->update($mdata);

    if ($status) {
      return response()->json([
        'status' => "success",
        'message' => 'Shift Rotaion Updated Successfully',
      ]);
    } else {
      return response()->json([
        'status' => "failed",
        'message' => 'There is some issue. Please check.',
      ]);
    }
  }
  /*Shift Rotation Master details end here*/

  public function View_Shift_Rotation_data($id)
  {
    $Shift_rotaion_data_all = ShiftRotation::find($id);
    return view('Frontend.shift-rotation-master', ['Shift_rotaion_data_all' => $Shift_rotaion_data_all]);
  }

  public function Option_view()
  {
    $OptionView = OptionView::find(1);
    return view('Frontend.option-view', ['OptionView' => $OptionView]);
  }

  public function Option_data_Update(Request $request)
  {
    $data = $request->all();
    $OptionView = OptionView::first();
    $OptionView['noof_machine_connected']      = $request->input('noof_machine_connected');
    $OptionView['length_of_cardno']            = $request->input('length_of_cardno');
    $OptionView['maxout_time_search']          = $request->input('maxout_time_search');
    $OptionView['time_gap_for_shift_change']   = $request->input('time_gap_for_shift_change');
    $OptionView['filter_for_duplicate_punches'] = $request->input('filter_for_duplicate_punches');
    $OptionView['night_processing_required']   = $request->input('night_processing_required');
    $OptionView['using_permission_card']       = $request->input('using_permission_card');
    $OptionView['min_work_hr_half_present']    = $request->input('min_work_hr_half_present');
    $OptionView['min_over_time_hr']            = $request->input('min_over_time_hr');
    $OptionView['max_short_leave_hr']          = $request->input('max_short_leave_hr');
    $OptionView['min_short_leave_hr']          = $request->input('min_short_leave_hr');
    $OptionView['single_punch']                = $request->input('single_punch');
    $OptionView['over_time_calculation']       = $request->input('over_time_calculation');
    $OptionView['over_time_round_off']         = $request->input('over_time_round_off');
    $OptionView['minimum_work_hr_full_present'] = $request->input('minimum_work_hr_full_present');
    $OptionView['late_nos']                    = $request->input('late_nos');
    $OptionView['month_start']                 = $request->input('month_start');
    $OptionView['min_hr_double_duty']          = $request->input('min_hr_double_duty');
    $OptionView['deduction']                   = $request->input('deduction');
    $OptionView['dos_print']                   = $request->input('dos_print');

    $status = $OptionView->save();
    if ($status) {
      return redirect('/option-view');
    }
  }

  /*Shift Rotation Master detail start here */
  public function Shift_Rotation_Master_Edit($id)
  {
    $shift = ShiftRotation::findOrFail($id);
    return view('Frontend.shift-rotation-master-edit', ['shift_rotation_data' => $shift]);
  }

  public function Shift_Rotation_Calendar_view(Request $request)
  {
    $Shift_view = Shift::orderBy('id', 'DESC')->paginate(18);
    $Shift_Rotaion_view = ShiftRotation::orderBy('id', 'DESC')->paginate(18);
    return view('Frontend.shift_rotation_calendar_view', ['Shift_Rotaion_view' => $Shift_Rotaion_view, 'Shift_view' => $Shift_view]);
  }

  public function Delete_Shift_Rotation_data($id)
  {
    $shift_rotation_data = ShiftRotation::find($id);
    $shift_rotation_data->delete();
    return redirect('/shift-rotation-master');
  }

  public function View_Shift_Option()
  {
    $Shift_view = Shift::orderBy('id', 'ASC')->get();
    if (count($Shift_view) <= 0) {
      return response()->json(['status' => false, 'msg' => '', 'data' => null]);
    } else {
      return response()->json(['status' => true, 'msg' => '', 'data' => $Shift_view]);
    }
  }
  public function View_Shift_Rotation_Option()
  {
    $Shift_Rotation_view = ShiftRotation::orderBy('id', 'ASC')->get();
    if (count($Shift_Rotation_view) <= 0) {
      return response()->json(['status' => false, 'msg' => '', 'data' => null]);
    } else {
      return response()->json(['status' => true, 'msg' => '', 'data' => $Shift_Rotation_view]);
    }
  }

  /*Leave Code Master detail(master page)*/
  public function Leave_Master_Code(Request $request)
  {
    $Leave_code_view = LeaveCode::orderby('id', 'desc')->paginate(18);
    return view('Frontend.leave-code', ['Leave_Code_view' => $Leave_code_view]);
  }

  public function Add_LeaveCode(Request $request)
  {
    $data = $request->all();
    $isExist = LeaveCode::select("*")
      ->where("leave_code", $request->leave_code)
      ->exists();

    if ($isExist) {
      return redirect()->back()->with('alert', 'the leave code is already exsits');
    } else {
      $status = LeaveCode::create($data);
    }
    return redirect('/leave-codes');
  }

  public function Update_Leave_Code(Request $request)
  {
    $leave_id = $request->leave_id;
    $findid = LeaveCode::find($leave_id);

    $data['leave_code']           = $request->leave_code;
    $data['type_of_leave']        = $request->type_of_leave;
    $data['paid']                 = $request->paid;
    $data['balanace_maintained']  = $request->balanace_maintained;
    $data['encashment_available'] = $request->encashment_available;
    $data['running_working']      = $request->running_working;
    $data['balance_carry_forward'] = $request->balance_carry_forward;

    if ($findid) {
      $status = $findid->fill($data)->update();
    }
    return redirect('/leave-codes');
  }
  public function Delete_Leave_code($id)
  {
    $Leave_Code_all = LeaveCode::find($id);
    $Leave_Code_all->delete();
    return redirect('/leave-codes');
  }
  /*Leave Code detail(master page)*/


  /*Holiday Entry Master detail(master page)*/
  public function Holiday_Entry(Request $request)
  {
    $Holiday_entry_view = HolidayEntry::orderby('id', 'desc')->paginate(18);
    return view('Frontend.holiday_entry', ['Holiday_Entry_view' => $Holiday_entry_view]);
  }

  public function Add_Holiday_Entry(Request $request)
  {
    $data = $request->all();
    $isExist = HolidayEntry::select("*")
      ->where("date", $request->date)
      ->exists();
    if ($isExist) {
      return redirect()->back()->with('alert', 'this date is already exsits');
    } else {
      $status = HolidayEntry::create($data);
    }
    return redirect('/holiday-entry');
  }

  public function Update_Holiday_Entry(Request $request)
  {
    $holiday_id = $request->holiday_id;
    $findid = HolidayEntry::find($holiday_id);

    $data['date']        = $request->date;
    $data['category']    = $request->category;
    $data['type']        = $request->type;
    $data['description'] = $request->description;

    if ($findid) {
      $status = $findid->fill($data)->update();
    }
    return redirect('/holiday-entry');
  }
  public function Delete_holiday_entry($id)
  {
    $Leave_Code_all = HolidayEntry::find($id);
    $Leave_Code_all->delete();
    return redirect('/holiday-entry');
  }
  /*Holiday Entry detail(master page)*/


  /*Holiday Declaration Master detail(master page)*/
  public function Holiday_Declaration(Request $request)
  {
    $Holiday_declarations = HolidayDeclaration::orderby('id', 'desc')->paginate(18);
    return view('Frontend.holiday_declaration', ['Holiday_declarations' => $Holiday_declarations]);
  }

  public function add_holiday_declaration(Request $request)
  {
    $data = $request->all();
    $isExist = HolidayDeclaration::select("*")
      ->where("declared_on", $request->date)
      ->exists();
    if ($isExist) {
      return redirect()->back()->with('alert', 'this date is already exsits');
    } else {
      $status = HolidayDeclaration::create($data);
    }
    return redirect('/holiday-declaration');
  }

  public function edit_holiday_declaration(Request $request)
  {
    $holiday_id = $request->holiday_id;
    $findid = HolidayDeclaration::find($holiday_id);

    $data['declared_on']        = $request->declared_on;
    $data['compensatory_on']    = $request->compensatory_on;
    $data['declared_as']        = $request->declared_as;

    if ($findid) {
      $status = $findid->fill($data)->update();
    }
    return redirect('/holiday-declaration');
  }

  public function delete_holiday_declaration($id)
  {
    $Leave_Code_all = HolidayDeclaration::find($id);
    $Leave_Code_all->delete();
    return redirect('/holiday-declaration');
  }
  /*Holiday Declaration detail(master page)*/

  /*monthly shift generate(transaction page)*/
  public function monthlyShiftGenerate()
  {
    return view('Frontend.monthly_shift_generate');
  }
  public function monthlyShiftGeneratePost(Request $request)
  {
    $month        = $request->month;
    $year         = $request->year;

    $employeeIds = Emp_mst_live::select('EMP_NO', 'shift_type', 'shift_rotaion', 'week_off')->get();
    foreach ($employeeIds as $employeeId) {
      if ($employeeId->shift_rotaion != NULL) {
        $shiftData = [
          'empcode' => $employeeId->EMP_NO,
          'month' => $month,
          'year' => $year,
        ];

        if ($employeeId->shift_type == 0) {
          $shift = Shift::where('id', $employeeId->shift_rotaion)->first();
          $firstDay = strtotime("$year-$month-01");
          $numDays = date('t', $firstDay);
          for ($day = 1; $day <= $numDays; $day++) {
            $dateString = sprintf("%04d-%02d-%02d", $year, $month, $day); 
            $weekoff = date('w', strtotime($dateString)); 
            if ($weekoff == $employeeId->week_off) {
              $shiftData['d' . $day] = 'WW/' . $shift->Scode;
            } else {
              $shiftData['d' . $day] = $shift->Scode;
            }
          }
        } else {
          $shiftRotation = ShiftRotation::where('id', $employeeId->shift_rotaion)->first();
          $firstDay = strtotime("$year-$month-01");
          $numDays = date('t', $firstDay);

          if ($shiftRotation->monthly == "TRUE") {
            $shift_patterns = explode(",", $shiftRotation->shift_pattern);
            $skip_patterns = explode(",", $shiftRotation->skip_pattern);

            foreach ($skip_patterns as $key => $value) {
              if ($key == 0) {
                for ($day = $value; $day <= $skip_patterns[$key+1] - 1; $day++) {
                  $dateString = sprintf("%04d-%02d-%02d", $year, $month, $day); 
                  $weekoff = date('w', strtotime($dateString)); 
                  if ($weekoff == $employeeId->week_off) {
                    $shiftData['d' . $day] = 'WW/' . $shift_patterns[$key];
                  } else {
                    $shiftData['d' . $day] = $shift_patterns[$key];
                  }
                }
              } elseif ($key != count($skip_patterns)-1 ){
                for ($day = $value; $day <= $skip_patterns[$key+1] - 1; $day++) {
                  $dateString = sprintf("%04d-%02d-%02d", $year, $month, $day); 
                  $weekoff = date('w', strtotime($dateString)); 
                  if ($weekoff == $employeeId->week_off) {
                    $shiftData['d' . $day] = 'WW/' . $shift_patterns[$key];
                  } else {
                    $shiftData['d' . $day] = $shift_patterns[$key];
                  }
                }
              }else {
                for ($day = $value; $day <= $numDays; $day++) {
                  $dateString = sprintf("%04d-%02d-%02d", $year, $month, $day); 
                  $weekoff = date('w', strtotime($dateString)); 
                  if ($weekoff == $employeeId->week_off) {
                    $shiftData['d' . $day] = 'WW/' . $shift_patterns[$key];
                  } else {
                    $shiftData['d' . $day] = $shift_patterns[$key];
                  }
                }
              }
            }
          } else {
            if ($month == 1){
              $empData = MonthlyShiftGenerate::where(['empcode' => $employeeId->EMP_NO, 'month' => 12, 'year' => $year - 1])->get();
              $shift_patterns = explode(",", $shiftRotation->shift_pattern);
              $skip_patterns = $shiftRotation->skip_pattern;

              if (count($empData) > 0) { 
                $monthfalse = explode(",", $empData[0]['month_false']);              
                $patterncount = $monthfalse[1];
                $shiftPatternCount = count($shift_patterns);
                $skipPatternsCount = $monthfalse[0];
                $shiftCount = $monthfalse[1];
              } else {             
                $patterncount = 1;
                $shiftPatternCount = count($shift_patterns);
                $skipPatternsCount = 1;
                $shiftCount = 1;
              }
            } else {
              $empData = MonthlyShiftGenerate::where(['empcode' => $employeeId->EMP_NO, 'month' => $month - 1, 'year' => $year])->get();
              $shift_patterns = explode(",", $shiftRotation->shift_pattern);
              $skip_patterns = $shiftRotation->skip_pattern;
              if (count($empData) > 0) {                
                $monthfalse = explode(",", $empData[0]['month_false']);              
                $patterncount = $monthfalse[1];
                $shiftPatternCount = count($shift_patterns);
                $skipPatternsCount = $monthfalse[0];
                $shiftCount = $monthfalse[1];
              } else {
                $patterncount = 1;
                $shiftPatternCount = count($shift_patterns);
                $skipPatternsCount = 1;
                $shiftCount = 1;
              }
            }
            
            if ($skip_patterns == 1) {                                
              for ($day = 1; $day <= $numDays; $day++) {
                if ($patterncount == $shiftPatternCount) {
                  $dateString = sprintf("%04d-%02d-%02d", $year, $month, $day); 
                  $weekoff = date('w', strtotime($dateString)); 
                  if ($weekoff == $employeeId->week_off) {
                    $shiftData['d' . $day] = 'WW/' . $shift_patterns[$patterncount - 1];
                  } else {
                    $shiftData['d' . $day] = $shift_patterns[$patterncount - 1];
                  }
                  $patterncount = 1;
                } else {
                  $dateString = sprintf("%04d-%02d-%02d", $year, $month, $day); 
                  $weekoff = date('w', strtotime($dateString)); 
                  if ($weekoff == $employeeId->week_off) {
                    $shiftData['d' . $day] = 'WW/' . $shift_patterns[$patterncount - 1];
                  } else {
                    $shiftData['d' . $day] = $shift_patterns[$patterncount - 1];
                  }
                  $patterncount++;
                }
              }
              $shiftData['month_false'] = $patterncount . "," . $patterncount;                       
            } else {
              for ($day = 1; $day <= $numDays; $day++) {
                if ($skip_patterns == $skipPatternsCount) {
                  if($shiftPatternCount == $shiftCount){
                    $dateString = sprintf("%04d-%02d-%02d", $year, $month, $day); 
                    $weekoff = date('w', strtotime($dateString)); 
                    if ($weekoff == $employeeId->week_off) {
                      $shiftData['d' . $day] = 'WW/' . $shift_patterns[$shiftCount - 1];
                    } else {
                      $shiftData['d' . $day] = $shift_patterns[$shiftCount - 1];
                    }
                    $shiftCount = 1;
                  } else {
                    $dateString = sprintf("%04d-%02d-%02d", $year, $month, $day); 
                    $weekoff = date('w', strtotime($dateString)); 
                    if ($weekoff == $employeeId->week_off) {
                      $shiftData['d' . $day] = 'WW/' . $shift_patterns[$shiftCount - 1];
                    } else {
                      $shiftData['d' . $day] = $shift_patterns[$shiftCount - 1];
                    }
                    $shiftCount++;
                  }
                  $skipPatternsCount = 0;
                } else {
                  $dateString = sprintf("%04d-%02d-%02d", $year, $month, $day); 
                  $weekoff = date('w', strtotime($dateString)); 
                  if ($weekoff == $employeeId->week_off) {
                    $shiftData['d' . $day] = 'WW/' . $shift_patterns[$shiftCount - 1];
                  } else {
                    $shiftData['d' . $day] = $shift_patterns[$shiftCount - 1];
                  }
                }
                $skipPatternsCount++;
              }
              $shiftData['month_false'] = $skipPatternsCount . "," . $patterncount; 
            }
          }
        }
        MonthlyShiftGenerate::create($shiftData);
      }
    }
    return redirect()->back()->with('alert', 'Monthly shift generated successfully');
  }
  /*monthly shift generate(transaction page)*/

  public function monthlyShiftChange()
  {
    $month = date('m');
    $year = date('Y');
    $MonthlyShiftGenerates = MonthlyShiftGenerate::where(['month' => $month, 'year' => $year])->orderby('id', 'desc')->paginate(18);
    return view('Frontend.monthly_shift_change', ["MonthlyShiftGenerates" => $MonthlyShiftGenerates, "month" => $month, "year" => $year]);
  }

  public function monthlyShiftChangeEdit(Request $request) {
    $editShiftGenerates = MonthlyShiftGenerate::where(['month' => $request->month, 'year' => $request->year, 'empcode' => $request->empCode])->first();
    $date = date('d', strtotime($request->date));
    if ($editShiftGenerates){
      $shiftDate = "d" . (int)$date;
      $editShiftGenerates->$shiftDate = $request->shift;
      if ($editShiftGenerates->save()){
        return response()->json([
          "status" => true,
          "msg" => "Shift updated successfully"
        ]);
      } else {
        return response()->json([
          "status" => false,
          "msg" => "Shift not updated"
        ]);
      }
    } else {
      return response()->json([
        "status" => false,
        "msg" => "Something went wrong"
      ]);
    }
  }

  public function monthlyShiftChangeSearch(Request $request)
  {
    $month = date('m', strtotime($request->month_year));
    $year = date('Y', strtotime($request->month_year));
    $MonthlyShiftGenerates = MonthlyShiftGenerate::where(['month' => $month, 'year' => $year])->orderby('id', 'desc')->paginate(18);
    if ($MonthlyShiftGenerates) {
      return view('Frontend.monthly_shift_change', ["MonthlyShiftGenerates" => $MonthlyShiftGenerates, "month" => $month, "year" => $year]);
    } else {
      return redirect()->back()->with('alert', 'No data found');
    }
  }

  /*Board/university detail(master page)*/

  public function Board_view(Request $request)
  {
    $Board_view = DB::table('board')->paginate(10);

    return view('Frontend.board-university', ["Board_view" => $Board_view]);
  }

  public function AddBoard(Request $request)
  {
    $AddBoard = new Board();
    $AddBoardName = $request->board_name;
    $AddBoard->board_name =  $AddBoardName;
    $isExist = Board::select("*")
      ->where("board_name", $AddBoardName)
      ->exists();
    if ($isExist) {
      return redirect()->back()->with('alert', 'the Board/University is already exsits');
    } else {
      $AddBoard->save();
    }

    return redirect('/board-university');
  }

  public function Update_Board_data(Request $request)
  {

    $board_id = $request->board_id;
    $board_name = $request->board_name;
    $board_fetch = array(
      'board_name' => $board_name,
    );

    $update_Data = DB::table('board')
      ->where('id',  $board_id)
      ->update($board_fetch);
    return redirect('/board-university');
  }

  public function Delete_Board_data($id)
  {
    $Board_data_all = Board::find($id);
    $Board_data_all->delete();
    return redirect('/board-university');
  }

  /*Workplace detail(master page)*/

  public function Work_place_view(Request $request)
  {
    $workplace_master_view = DB::table('workplace')->orderby('id', 'desc')->paginate(18);
    return view('Frontend.workplace', ["workplace_master_view" => $workplace_master_view]);
  }

  public function AddWorkplace(Request $request)
  {
    $Workplace = new Workplace();
    $Workplace_name  = $request->workplace_name;
    $Workplace->workplace_name =  $Workplace_name;
    $isExist = Workplace::select("*")
      ->where("workplace_name", $Workplace_name)
      ->exists();
    if ($isExist) {
      return redirect()->back()->with('alert', 'the sub department is already exsits');
    } else {
      $Workplace->save();
    }


    return redirect('/sub-departments');
  }

  public function Update_WorkPlace_data(Request $request)
  {

    $work_id = $request->work_id;
    $workplace_name = $request->workplace_name;
    $workplace_fetch = array(
      'workplace_name' => $workplace_name,
    );

    $update_Data = DB::table('workplace')
      ->where('id',  $work_id)
      ->update($workplace_fetch);
    return redirect('/sub-departments');
  }
  public function Delete_WorkPlace_data($id)
  {
    $workplace_data_all = Workplace::find($id);
    $workplace_data_all->delete();
    return redirect('/sub-departments');
  }


  public function employee_list(Request $request)
  {
    $Employee_fetch = Emp_mst_live::Employee_Master_view();
    $pre_employee = Emp_mst_live::orderBy('id', 'DESC')->first();
    $next_employee = Emp_mst_live::orderBy('id', 'ASC')->first();
    $Employee_fetch = Emp_mst_live::Employee_Master_view();
    return view('Frontend.employee-list', ['Employee_fetch' => $Employee_fetch, "pre_employee" => $pre_employee, "next_employee" => $next_employee, "Employee_fetch" => $Employee_fetch]);
  }

  /*Paygrade detail(master page)*/
  public function Paygrade_view(Request $request)
  {
    $Paygrade_view = DB::table('pay_grade_mst')->orderby('id', 'desc')->paginate(10);
    return view('Frontend.pay-grade-master', ["Paygrade_view" => $Paygrade_view]);
  }
  public function AddPaygrade(Request $request)
  {
    $Paygrade = new Pay_grade_master();
    $grade_code  = $request->grade_code;
    $pay_grade_desc  = $request->pay_grade_desc;
    $pay_scale  = $request->pay_scale;
    $special_allowance  = $request->special_allowance;
    $other_special_allowance  = $request->other_special_allowance;
    $Paygrade->pay_grade_code =  $grade_code;
    $Paygrade->pay_grade_desc =  $pay_grade_desc;
    $Paygrade->pay_scale =  $pay_scale;
    $Paygrade->special_allowance =  $special_allowance;
    $Paygrade->other_special_allowance =  $other_special_allowance;
    $Paygrade->save();
    return redirect('/pay-grade-master');
  }
  public function Update_Paygrade_Data(Request $request)
  {
    $Paygrade_id = $request->scale_id;
    $gradecode = $request->grade_code;
    $description = $request->description;
    $payscale_detail = $request->pay_scale;
    $special_allowance  = $request->special_allowance;
    $other_special_allowance  = $request->other_special_allowance;
    $Paygrade_fetch = array(
      'pay_grade_code' => $gradecode,
      'pay_grade_desc' => $description,
      'pay_scale' => $payscale_detail,
      'special_allowance' =>  $special_allowance,
      'other_special_allowance' => $other_special_allowance
    );

    $update_Data = DB::table('pay_grade_mst')
      ->where('id',  $Paygrade_id)
      ->update($Paygrade_fetch);
    return redirect('/pay-grade-master');
  }
  public function Delete_Paygrade_data($id)
  {
    $Paygrade_data_all = Pay_grade_master::find($id);
    $Paygrade_data_all->delete();
    return redirect('/pay-grade-master');
  }
  public function fetch_paygrade_details($id)
  {
    $res = Pay_grade_master::find($id);
    echo "<pre>";
    print_r($res);
    echo "</pre>";
    exit();
    return $res;
  }

  /*Bank detail(master page)*/

  public function Bank_view(Request $request)
  {
    $Bank_view = DB::table('bank_mst')
      ->orderby('id', 'desc')
      ->paginate(10);
    return view('Frontend.bank', ["Bank_view" => $Bank_view]);
  }
  public function AddBank(Request $request)
  {
    $Bank = new Bank();
    $bank_code  = $request->bank_code;
    $bank_name = $request->bank_name;
    $ifsc_code  = $request->ifsc_code;
    $bank_address  = $request->address;
    $Bank->bank_code =  $bank_code;
    $Bank->bank_name =  $bank_name;
    $Bank->ifsc_code =  $ifsc_code;
    $Bank->addrerss =  $bank_address;
    $Bank->save();
    return redirect('/bank');
  }
  public function Update_Bank_Data(Request $request)
  {
    $Bank_id = $request->bank_id;
    $Bankcode = $request->bank_code;
    $Bankname = $request->bank_name;
    $Bank_ifsc = $request->bank_ifsc;
    $Bank_address = $request->address;
    $Bank_fetch = array(
      'bank_code' => $Bankcode,
      'bank_name' => $Bankname,
      'ifsc_code' => $Bank_ifsc,
      'addrerss' => $Bank_address,
    );

    $update_Data = DB::table('bank_mst')
      ->where('id',  $Bank_id)
      ->update($Bank_fetch);
    return redirect('/bank');
  }
  public function Delete_Bank_data($id)
  {
    $Bank_data_all = Bank::find($id);
    $Bank_data_all->delete();
    return redirect('/bank');
  }

  /*Employee Master Page*/

  public function Employee_view(Request $request)
  {
    //$Employee_master_fetch = Emp_mst_live::Employee_Master_view();
    $Board_view = Board::Board_view();
    $Bank_view = Bank::all();
    $Employee_fetch = Emp_mst_live::Employee_Master_view();
    $Department_fetch = Department_master::all();
    $qualification_level_mst = Qual_lvl::all();
    $Designation_fetch = Designation::all();
    $Workplace_fetch = Workplace::all();
    $Category_fetch = Category::all();
    $pay_grade_view = Pay_grade_master::Pay_grade_Master_view();
    $Employee_type_fetch = Employee_type::all();
    $Board_University_fetch = Board::all();
    $antecendent_fetch = Antecedent::all();
    $qualification_view = Qualification::Qualification_view();
    $pre_employee = Emp_mst_live::orderBy('id', 'DESC')->first();
    $next_employee = Emp_mst_live::orderBy('id', 'ASC')->first();
    return view('Frontend.employee-master', ["Employee_fetch" => $Employee_fetch, "Department_fetch" => $Department_fetch, "Designation" => $Designation_fetch, "Workplace_fetch" => $Workplace_fetch, "Category_fetch" => $Category_fetch, "Employee_type_fetch" => $Employee_type_fetch, 'pay_grade_view' => $pay_grade_view, "Board_University_fetch" => $Board_University_fetch, "antecendent_fetch" => $antecendent_fetch, "Board_view" => $Board_view, "qualification_view" => $qualification_view, "qualification_level_mst" => $qualification_level_mst, "Bank_view" => $Bank_view, "pre_employee" => $pre_employee, "next_employee" => $next_employee]);
  }

  public function AddEmployeeMaster(Request $request)
  {
    $Designation_view = DB::table('desg_mst_live')->orderby('id', 'desc')->get();
    $Employee_Master_Official = new emp_official();
    $Employee_Master_Nominee = new Nominee();
    $empAdd = new Emp_mst_live();

    //get employee number
    $employee_number = Emp_mst_live::max('EMP_NO');
    if ($employee_number == null) {
      $employee_number = 1;
    } else {
      $employee_number += 1;
    }

    if ($request->hasFile('image')) {

      $image = $request->file('image');
      $name = rand() . time() . '.' . $image->getClientOriginalExtension();
      $destinationPath = public_path('/image/');
      $image->move($destinationPath, $name);
      $img = file_get_contents(public_path() . '/image/' . $name);
      //force_download($img, $img);
      $im = imagecreatefromstring($img);
      $width = imagesx($im);
      $height = imagesy($im);
      $newwidth1 = 200;
      $newheight1 = 205;
      $old_x          =   $width;
      $old_y          =   $height;
      if ($old_x > $old_y) {
        $thumb_w    =   $newwidth1;
        $thumb_h    =   $old_y * ($newheight1 / $old_x);
      }
      if ($old_x < $old_y) {
        $thumb_w    =   $old_x * ($newwidth1 / $old_y);
        $thumb_h    =   $newheight1;
      }
      if ($old_x == $old_y) {
        $thumb_w    =   $newwidth1;
        $thumb_h    =   $newheight1;
      }
      if ($width < 200 && $height > 205) {
        $thumb_w    =   $old_x * ($newwidth1 / $old_y);
        $thumb_h    =   $newheight1;
      }
      if ($width > 200 && $height < 205) {
        $thumb_w    =   $newwidth1;
        $thumb_h    =   $old_y * ($newheight1 / $old_x);
      }
      if ($width < 200 && $height < 205) {
        $thumb_w    =   $width;
        $thumb_h    =   $height;
      }
      $thumb1 = imagecreatetruecolor($thumb_w, $thumb_h);
      imagecopyresized($thumb1, $im, 0, 0, 0, 0, $thumb_w, $thumb_h, $width, $height);
      imagepng($thumb1, public_path() . '/image/' . $name); //save image as jpg
      imagedestroy($thumb1);
    } else {
      $name = null;
    }


    $isExist = Emp_mst_live::select("*")
      ->where("EMP_NO",  $employee_number)
      ->exists();
    if ($isExist) {
      return redirect()->back()->with('alert', 'the employee number is already exsits');
    } else {
      $empAdd->EMP_NO = $employee_number;
    }

    $empAdd->EMP_NAME                        = $request->EMP_NAME;
    $empAdd->DEPT_NO                         = $request->DEPT_NO;
    $empAdd->GRADE_CODE                      = $request->GRADE_CODE;
    $empAdd->DESG_CODE                       = $request->DESG_CODE;
    $empAdd->DOB                             = $request->DOB ? date('Y-m-d', strtotime($request->DOB)) : null;
    $empAdd->DOJ                             = $request->DOJ ? date('Y-m-d', strtotime($request->DOJ)) : null;
    $empAdd->EMP_TYPE                        = $request->EMP_TYPE;
    $empAdd->ACTIVE_TYPE                     = $request->type;
    $empAdd->CONT_END_DATE                   = $request->CONT_END_DATE;
    $empAdd->CONT_SAL                        = $request->CONT_SAL;
    $empAdd->PROB_START_DATE                 = $request->PROB_START_DATE;
    $empAdd->CONFIRM_DATE                    = $request->CONFIRM_DATE;
    $empAdd->SEX                             = $request->SEX;
    $empAdd->MARITAL_STATUS                  = $request->MARITAL_STATUS;
    $empAdd->BLOOD_GROUP                     = $request->BLOOD_GROUP;
    $empAdd->ID_MARK                         = $request->ID_MARK;
    $empAdd->SPOUSE_NAME                     = $request->SPOUSE_NAME;
    $empAdd->FATHER_NAME                     = $request->FATHER_NAME;
    $empAdd->PRESENT_ADDRESS1                = $request->PRESENT_ADDRESS1;
    $empAdd->PRESENT_ADDRESS2                = $request->PRESENT_ADDRESS2;
    $empAdd->PRESENT_ADDRESS3                = $request->PRESENT_ADDRESS3;
    $empAdd->PERM_ADDRESS1                   = $request->PERM_ADDRESS1;
    $empAdd->PERM_ADDRESS2                   = $request->PERM_ADDRESS2;
    $empAdd->PERM_ADDRESS3                   = $request->PERM_ADDRESS3;
    $empAdd->CITY                            = $request->CITY;
    $empAdd->PIN                             = $request->PIN;
    $empAdd->PH_NO                           = $request->PH_NO;
    $empAdd->qualification                   = $request->QUALIFICATION;
    $empAdd->reference                       = $request->REFERENCE;
    $empAdd->EMAIL                           = $request->EMAIL;
    $empAdd->PAYMENT_MODE                    = $request->PAYMENT_MODE;
    $empAdd->BANK_AC_NO                      = $request->BANK_AC_NO;
    $empAdd->BANK_CODE                       = $request->BANK_CODE;
    $empAdd->PF_AC_NO                        = $request->PF_AC_NO;
    $empAdd->BASIC_PAY                       = $request->BASIC_PAY;
    $empAdd->INCR_AMT                        = $request->INCR_AMT;
    $empAdd->INCR_DUE_DATE                   = $request->INCR_DUE_DATE;
    $empAdd->PROB_END_DATE                   = $request->PROB_END_DATE;
    $empAdd->VPF_PERC                        = $request->VPF_PERC;
    $empAdd->CATG                            = $request->CATG;
    $empAdd->DA_PAY                          = $request->DA_PAY;
    $empAdd->SRL_NO                          = $request->SRL_NO;
    $empAdd->LEAVE_ENCASH_DAYS               = $request->LEAVE_ENCASH_DAYS;
    $empAdd->PF_DED                          = $request->PF_DED;
    $empAdd->SPL_ALLOW                       = $request->SPL_ALLOW;
    $empAdd->ESI_DED                         = $request->ESI_DED;
    $empAdd->SAL_CATG                        = $request->SAL_CATG;
    $empAdd->sub_dpt_workplace               = $request->SUB_DPT_WORKPLACE;
    $empAdd->card_no                         = $request->CARD_NO;
    $empAdd->card_no2                        = $request->CARD_NO2;
    $empAdd->over_time                       = $request->OVER_TIME;
    $empAdd->LEFTON_DATE                     = $request->LEFTON_DATE;
    $empAdd->ENTRY_REQUIRED                  = $request->ENTRY_REQUIRED;
    $empAdd->shift_type                      = $request->shift_type;
    $empAdd->shift_rotaion                   = $request->child_cat_id;
    $empAdd->week_off                        = $request->week_off;
    $empAdd->AUTO_UPDATE                     = $request->AUTO_UPDATE;
    $empAdd->is_regular_employee             = $request->is_regular_employee;
    $empAdd->eligible_for_ph_if_present      = $request->eligible_for_ph_if_present;
    $empAdd->conciding_with_weekoff          = $request->conciding_with_weekoff;
    $empAdd->eligible_for_ch_if_not          = $request->eligible_for_ch_if_not;
    $empAdd->eligigble_for_PH_if_not_present = $request->eligigble_for_PH_if_not_present;
    $empAdd->entitled_for_night_shift        = $request->entitled_for_night_shift;

    $empAdd->save();

    //echo "<pre>";print_r($addtable2); echo "</pre>"; exit();
    //$id = DB::table('empmst_official')->insertGetId($addtable2);
    if (Auth::user()->role == "Administrator" || Auth::user()->role == "HR Manager" || Auth::user()->role == "Authorisor" || Auth::user()->role == "Supervisor") {
      return redirect('/employee_edit_master/?search_emp=' . $employee_number)->withInput()->with('SuccessStatus', 'Records sucessfully uploaded');
    } else {
      return redirect('/employee_master')->with('SuccessStatus', 'Records sucessfully uploaded');
    }
  }



  public function updateEmployeeDetails(Request $request)
  {
    $empAdd                                  = Emp_mst_live::find($request->editid);
    $empAdd->EMP_NAME                        = $request->EMP_NAME;
    $empAdd->DEPT_NO                         = $request->DEPT_NO;
    $empAdd->GRADE_CODE                      = $request->GRADE_CODE;
    $empAdd->DESG_CODE                       = $request->DESG_CODE;
    $empAdd->DOB                             = $request->DOB ? date('Y-m-d', strtotime($request->DOB)) : null;
    $empAdd->DOJ                             = $request->DOJ ? date('Y-m-d', strtotime($request->DOJ)) : null;
    $empAdd->EMP_TYPE                        = $request->EMP_TYPE;
    $empAdd->ACTIVE_TYPE                     = $request->type;
    $empAdd->CONT_END_DATE                   = $request->CONT_END_DATE;
    $empAdd->CONT_SAL                        = $request->CONT_SAL;
    $empAdd->PROB_START_DATE                 = $request->PROB_START_DATE;
    $empAdd->CONFIRM_DATE                    = $request->CONFIRM_DATE;
    $empAdd->SEX                             = $request->SEX;
    $empAdd->MARITAL_STATUS                  = $request->MARITAL_STATUS;
    $empAdd->BLOOD_GROUP                     = $request->BLOOD_GROUP;
    $empAdd->ID_MARK                         = $request->ID_MARK;
    $empAdd->SPOUSE_NAME                     = $request->SPOUSE_NAME;
    $empAdd->FATHER_NAME                     = $request->FATHER_NAME;
    $empAdd->PRESENT_ADDRESS1                = $request->PRESENT_ADDRESS1;
    $empAdd->PRESENT_ADDRESS2                = $request->PRESENT_ADDRESS2;
    $empAdd->PRESENT_ADDRESS3                = $request->PRESENT_ADDRESS3;
    $empAdd->PERM_ADDRESS1                   = $request->PERM_ADDRESS1;
    $empAdd->PERM_ADDRESS2                   = $request->PERM_ADDRESS2;
    $empAdd->PERM_ADDRESS3                   = $request->PERM_ADDRESS3;
    $empAdd->CITY                            = $request->CITY;
    $empAdd->PIN                             = $request->PIN;
    $empAdd->PH_NO                           = $request->PH_NO;
    $empAdd->qualification                   = $request->QUALIFICATION;
    $empAdd->reference                       = $request->REFERENCE;
    $empAdd->EMAIL                           = $request->EMAIL;
    $empAdd->PAYMENT_MODE                    = $request->PAYMENT_MODE;
    $empAdd->BANK_AC_NO                      = $request->BANK_AC_NO;
    $empAdd->BANK_CODE                       = $request->BANK_CODE;
    $empAdd->PF_AC_NO                        = $request->PF_AC_NO;
    $empAdd->BASIC_PAY                       = $request->BASIC_PAY;
    $empAdd->INCR_AMT                        = $request->INCR_AMT;
    $empAdd->INCR_DUE_DATE                   = $request->INCR_DUE_DATE;
    $empAdd->PROB_END_DATE                   = $request->PROB_END_DATE;
    $empAdd->VPF_PERC                        = $request->VPF_PERC;
    $empAdd->CATG                            = $request->CATG;
    $empAdd->DA_PAY                          = $request->DA_PAY;
    $empAdd->SRL_NO                          = $request->SRL_NO;
    $empAdd->LEAVE_ENCASH_DAYS               = $request->LEAVE_ENCASH_DAYS;
    $empAdd->PF_DED                          = $request->PF_DED;
    $empAdd->SPL_ALLOW                       = $request->SPL_ALLOW;
    $empAdd->ESI_DED                         = $request->ESI_DED;
    $empAdd->SAL_CATG                        = $request->SAL_CATG;
    $empAdd->sub_dpt_workplace               = $request->SUB_DPT_WORKPLACE;
    $empAdd->card_no                         = $request->CARD_NO;
    $empAdd->card_no2                        = $request->CARD_NO2;
    $empAdd->over_time                       = $request->OVER_TIME;
    $empAdd->LEFTON_DATE                     = $request->LEFTON_DATE;
    $empAdd->ENTRY_REQUIRED                  = $request->ENTRY_REQUIRED;
    $empAdd->shift_type                      = $request->shift_type;
    $empAdd->shift_rotaion                   = $request->child_cat_id;
    $empAdd->week_off                        = $request->week_off;
    $empAdd->AUTO_UPDATE                     = $request->AUTO_UPDATE;
    $empAdd->is_regular_employee             = $request->is_regular_employee;
    $empAdd->eligible_for_ph_if_present      = $request->eligible_for_ph_if_present;
    $empAdd->conciding_with_weekoff          = $request->conciding_with_weekoff;
    $empAdd->eligible_for_ch_if_not          = $request->eligible_for_ch_if_not;
    $empAdd->eligigble_for_PH_if_not_present = $request->eligigble_for_PH_if_not_present;
    $empAdd->entitled_for_night_shift        = $request->entitled_for_night_shift;

    $empAdd->save();

    //$update_Data=DB::table('emp_mst')->where('emp_no',  $request->EMP_NO)->update($empAdd); 

    if (Auth::user()->role == "Administrator" || Auth::user()->role == "HR Manager" || Auth::user()->role == "Authorisor" || Auth::user()->role == "Supervisor") {
      return redirect('/employee_master')->with('SuccessStatus', 'Records sucessfully updated');
    } else {
      return redirect('/employee_master')->with('SuccessStatus', 'Records sucessfully updated');
    }
  }
  //row dependent
  public function depdelete(Request $request)
  {
    $status = 1;
    $did = $request->did;
    //  echo"<pre>";print_r($pid );echo"</pre>";exit();
    $deletepreventive = Dependent::findOrFail($did);
    //echo"<pre>";print_r($deletepreventive );echo"</pre>";exit();
    if ($deletepreventive->delete()) {
      $status = 1;
    } else {
      echo "data not deleted";
      $status = 0;
    }
    return Response::json($status);
    exit;
  }
  //qualifications
  public function deletequali(Request $request)
  {
    $qid = $request->qid;
    //  echo"<pre>";print_r($pid );echo"</pre>";exit();
    $deletequalification = Qualification::findOrFail($qid);
    //echo"<pre>";print_r($deletepreventive );echo"</pre>";exit();
    if ($deletequalification->delete()) {
      $status = 1;
    } else {
      echo "data not deleted";
      $status = 0;
    }
    return Response::json($status);
    exit;
  }
  //organization
  public function deleteorganization(Request $request)
  {
    $qid = $request->qid;
    //  echo"<pre>";print_r($pid );echo"</pre>";exit();
    $deletequalification = Experience::findOrFail($qid);
    //echo"<pre>";print_r($deletepreventive );echo"</pre>";exit();
    if ($deletequalification->delete()) {
      $status = 1;
    } else {
      echo "data not deleted";
      $status = 0;
    }
    return Response::json($status);
    exit;
  }
  //transfer
  public function deletetransfer(Request $request)
  {
    $qid = $request->qid;
    //  echo"<pre>";print_r($pid );echo"</pre>";exit();
    $deletequalification = Transfer::findOrFail($qid);
    //echo"<pre>";print_r($deletepreventive );echo"</pre>";exit();
    if ($deletequalification->delete()) {
      $status = 1;
    } else {
      echo "data not deleted";
      $status = 0;
    }
    return Response::json($status);
    exit;
  }
  //promotion
  public function deletepromotion(Request $request)
  {
    $pid = $request->pid;
    //  echo"<pre>";print_r($pid );echo"</pre>";exit();
    $deletequalification = Promotion::findOrFail($pid);
    //echo"<pre>";print_r($deletepreventive );echo"</pre>";exit();
    if ($deletequalification->delete()) {
      $status = 1;
    } else {
      echo "data not deleted";
      $status = 0;
    }
    return Response::json($status);
    exit;
  }
  //probation
  public function deleteprobation(Request $request)
  {
    $pid = $request->pid;
    //  echo"<pre>";print_r($pid );echo"</pre>";exit();
    $deletequalification = Probation::findOrFail($pid);
    //echo"<pre>";print_r($deletepreventive );echo"</pre>";exit();
    if ($deletequalification->delete()) {
      $status = 1;
    } else {
      echo "data not deleted";
      $status = 0;
    }
    return Response::json($status);
    exit;
  }
  public function contractdelete(Request $request)
  {
    $cid = $request->cid;
    //  echo"<pre>";print_r($pid );echo"</pre>";exit();
    $deletequalification = Contract::findOrFail($cid);
    //echo"<pre>";print_r($deletepreventive );echo"</pre>";exit();
    if ($deletequalification->delete()) {
      $status = 1;
    } else {
      echo "data not deleted";
      $status = 0;
    }
    return Response::json($status);
    exit;
  }
  public function antecedentdelete(Request $request)
  {
    $cid = $request->cid;
    //  echo"<pre>";print_r($pid );echo"</pre>";exit();
    $deletequalification = Antecedent::findOrFail($cid);
    //echo"<pre>";print_r($deletepreventive );echo"</pre>";exit();
    if ($deletequalification->delete()) {
      $status = 1;
    } else {
      echo "data not deleted";
      $status = 0;
    }
    return Response::json($status);
    exit;
  }

  public function revocationdelete(Request $request)
  {
    $cid = $request->cid;
    //  echo"<pre>";print_r($pid );echo"</pre>";exit();
    $deletequalification = Revocation::findOrFail($cid);
    //echo"<pre>";print_r($deletepreventive );echo"</pre>";exit();
    if ($deletequalification->delete()) {
      $status = 1;
    } else {
      echo "data not deleted";
      $status = 0;
    }
    return Response::json($status);
    exit;
  }
  public function delete_intiation(Request $request)
  {
    $inti_id = $request->inti_id;
    //  echo"<pre>";print_r($pid );echo"</pre>";exit();
    $deleteintiation = Intiation::findOrFail($inti_id);
    //echo"<pre>";print_r($deletepreventive );echo"</pre>";exit();
    if ($deleteintiation->delete()) {
      $status = 1;
    } else {
      echo "data not deleted";
      $status = 0;
    }
    return Response::json($status);
    exit;
  }
  public function deleteachievement(Request $request)
  {
    $achievement_id = $request->achievement_id;
    //  echo"<pre>";print_r($pid );echo"</pre>";exit();
    $deleteAchievement = Achievement::findOrFail($achievement_id);
    //echo"<pre>";print_r($deletepreventive );echo"</pre>";exit();
    if ($deleteAchievement->delete()) {
      $status = 1;
    } else {
      echo "data not deleted";
      $status = 0;
    }
    return Response::json($status);
    exit;
  }
  public function appreecitaiondelete(Request $request)
  {
    $cid = $request->cid;
    //  echo"<pre>";print_r($pid );echo"</pre>";exit();
    $deletequalification = Appriciation::findOrFail($cid);
    //echo"<pre>";print_r($deletepreventive );echo"</pre>";exit();
    if ($deletequalification->delete()) {
      $status = 1;
    } else {
      echo "data not deleted";
      $status = 0;
    }
    return Response::json($status);
    exit;
  }

  public function rewarddelete(Request $request)
  {
    $cid = $request->cid;
    //  echo"<pre>";print_r($pid );echo"</pre>";exit();
    $deletequalification = Reward::findOrFail($cid);
    //echo"<pre>";print_r($deletepreventive );echo"</pre>";exit();
    if ($deletequalification->delete()) {
      $status = 1;
    } else {
      echo "data not deleted";
      $status = 0;
    }
    return Response::json($status);
    exit;
  }

  public function allEmployeDetails(Request $request)
  {
    // dd($request);
    $employee_number = $request->search_emp;
    if (!DB::table('emp_mst_live')->where('EMP_NO', trim($employee_number))->exists()) {
      return redirect('/home');
    }


    $EmployeeModel = new Emp_mst_live();
    $EmpEditData = 
    $EmployeeAllInfo = $EmployeeModel->getAllEmployeeInfo($employee_number);

    $Board_view = Board::Board_view();
    $Bank_view = Bank::all();
    $Department_fetch = Department_master::all();
    $qualification_level_mst = Qual_lvl::all();
    $Designation_fetch = Designation::all();
    $Workplace_fetch = Workplace::all();
    $Category_fetch = Category::all();
    $pay_grade_view = Pay_grade_master::Pay_grade_Master_view();
    $Employee_type_fetch = Employee_type::all();
    $Board_University_fetch = Board::all();
    $antecendent_fetch = Antecedent::all();
    $qualification_view = Qualification::Qualification_view();
    $pre_employee = Emp_mst_live::orderBy('id', 'DESC')->first();
    $next_employee = Emp_mst_live::orderBy('id', 'ASC')->first();

    return response()->json([
      "status" => true,
      "Department_fetch" => $Department_fetch, 
      "Designation" => $Designation_fetch, 
      "Workplace_fetch" => $Workplace_fetch, 
      "Category_fetch" => $Category_fetch, 
      "Employee_type_fetch" => $Employee_type_fetch, 
      "pay_grade_view" => $pay_grade_view, 
      "Board_University_fetch" => $Board_University_fetch, 
      "antecendent_fetch" => $antecendent_fetch, 
      "Board_view" => $Board_view, 
      "qualification_view" => $qualification_view, 
      "qualification_level_mst" => $qualification_level_mst, 
      "Bank_view" => $Bank_view, 
      "pre_employee" => $pre_employee, 
      "next_employee" => $next_employee,
      "EmployeeAllInfo" => $EmployeeAllInfo
    ]);
  }

  public function delete_empremark($id, $emp_id)
  {
    $check = Remark::where('id', $id)->count();
    if ($check > 0) {
      $delete = Remark::where('id', $id)->where('emp_no', $emp_id)->delete();
      if ($delete) {
        return redirect()->back()->with('success', "Records has bee successfully deleted.");
      } else {
        return redirect()->back()->with('failed', "Failed to delete..!!");
      }
    } else {
      return redirect()->back()->with('failed', "Something is wrong..!!");
    }
  }

  public function getPackage(Request $request)
  {
    $data = Pay_grade_master::where('pay_grade_code', $request->selectedid)->get();
    return json_encode($data);
  }
  public function getPromotion(Request $request)
  {
    $data = Pay_grade_master::where('id', $request->selectedid)->get();
    return json_encode($data);
  }
  public function gettoPromotion(Request $request)
  {
    $data = Pay_grade_master::where('id', $request->selectedid)->get();
    return json_encode($data);
  }
  public function gettoProbation(Request $request)
  {
    $data = Pay_grade_master::where('id', $request->selectedid)->get();
    return json_encode($data);
  }

  /**
   * Category Master page
   * */

  public function Category_Master_view(Request $request)
  {
    $Category_view = DB::table('category')->paginate(10);
    return view('Frontend.category', ['Category_view' => $Category_view]);
  }
  public function AddCategory(Request $request)
  {
    $Category = new Category();
    $category_name = $request->cat_name;
    $category_code = $request->cat_code;
    $Category->category_name =  $category_name;
    $Category->category_code =  $category_code;
    $Category->save();
    return redirect('/category');
  }
  public function Update_Category_Data(Request $request)
  {
    $category_id = $request->cat_id;
    $category_name = $request->cat_name;
    $category_code = $request->cat_code;

    $category_fetch = array(
      'category_name' => $category_name,

      'category_code' => $category_code,
    );

    $update_Data = DB::table('category')
      ->where('id',  $category_id)
      ->update($category_fetch);
    return redirect('/category');
  }
  public function Delete_category_data($id)
  {
    $category_data_all = category::find($id);
    $category_data_all->delete();
    return redirect('/category');
  }
  /**
   * EmployeeType Master page
   * */
  public function EmployeeType_Master_view(Request $request)
  {
    $Employee_view = DB::table('employee_type')->paginate(10);

    return view('Frontend.employee_type', ['Employee_view' => $Employee_view]);
  }
  public function AddEmployeeType(Request $request)
  {
    $employee_type = new Employee_type();
    $employee_type_name = $request->emp_name;
    $employee_type->employee_type_name =  $employee_type_name;
    $employee_type->save();
    return redirect('/employee_type');
  }
  public function Update_EmployeeType_Data(Request $request)
  {
    $employee_type_id = $request->emp_id;
    $employee_type_name = $request->emp_name;

    $employee_type_fetch = array(
      'employee_type_name' => $employee_type_name,
    );

    $update_Data = DB::table('employee_type')
      ->where('id',  $employee_type_id)
      ->update($employee_type_fetch);
    return redirect('/employee_type');
  }
  public function Delete_employee_type_data($id)
  {
    $employee_type_data_all = Employee_type::find($id);
    $employee_type_data_all->delete();
    return redirect('/employee_type');
  }

  public function EmployeeType_edit_Master_view(Request $request)
  {
    // $Employee_view = Employee_type::EmployeeType_Master_view();

    return view('Frontend.edit_profile');
  }

  public function EmployeelastRecordview()
  {
    $Emp_no = Emp_mst_live::Employee_Master_Last_record_view();
    //echo"<pre>";print_r($EmployeelastRecordfetch );echo"</pre>";
    return redirect('/employee_edit_master/?search_emp=' . $Emp_no);
  }
  public function EmployeefirstRecordview()
  {
    $Emp_first_no = Emp_mst_live::Employee_Master_first_record_view();
    return redirect('/employee_edit_master/?search_emp=' . $Emp_first_no);
  }
  public function EmpDeleteRecordview(Request $request)
  {
    $Emp_data_all = Emp_mst_live::Employee_Master_delete_record_view($request);
    return redirect('/employee_master');
  }


  public function EmployeeNextRecordview(Request $request)
  {
    $Employee_next = Emp_mst_live::Employee_Master_next_record_view($request);

    if ($Employee_next != "") {
      return redirect('/employee_edit_master/?search_emp=' . $Employee_next);
    } else {
      $empno = $request->input('search_emp');
      return redirect('/employee_edit_master/?search_emp=' . $empno);
    }
    // echo"<pre>";print_r($Emp_next_no );echo"</pre>";

  }
  public function EmployeePreviousRecordview(Request $request)
  {
    $Employee_prev = Emp_mst_live::Employee_Master_previous_record_view($request);

    if ($Employee_prev != "") {
      return redirect('/employee_edit_master/?search_emp=' . $Employee_prev);
    } else {
      $empno = $request->input('search_emp');
      return redirect('/employee_edit_master/?search_emp=' . $empno);
    }
    // echo"<pre>";print_r($Emp_next_no );echo"</pre>";

  }
  public function Update_contract_details(Request $request)
  {
    $datacontract = DB::select('SELECT * FROM emp_contract_live_dtl');

    foreach ($datacontract as $d) {
      $data = array(
        $id = 'id' => $d->id,
        //'EMP_NO'=> $d->EMP_NO,
        'CONT_START_DATE' => date("d-m-Y", strtotime($d->CONT_START_DATE)),
        'CONT_END_DATE' => date("Y-m-d", strtotime($d->CONT_END_DATE)),
      );

      $update_Data = DB::table('emp_contract_live_dtl')
        ->where('id', $id)
        ->update(array($data1));
      echo "<pre>";
      print_r($update_Data);
      echo "</pre>";
    }
    // echo"<pre>";
    // print_r($data1);
    // echo"</pre>";  
    // exit();
    // $update_contractdata=DB::table('emp_contract_live_dtl')
    // ->update($data1);



  }
  public function contract_index()
  {
    return view('Frontend.demo');
  }

  public function agecounter(Request $request)
  {
    $user_age = Carbon::parse($request->dob)->diff(Carbon::now())->format('%y_%m_%d');
    return $user_age;
  }

  public function delete_doc(Request $r)
  {
    $folder = base64_decode($r->f);
    $file = $r->file;
    $table = base64_decode($r->t);
    $column = base64_decode($r->c);
    $id = base64_decode($r->i);
    $eid = base64_decode($r->e);
    $check = DB::table($table)->where('id', '=', $id)->count();
    if ($check > 0) {
      echo $check;
      $data = [
        $column => "",
      ];
      $result = DB::table($table)->where('id', $id)->update($data);
      if (File::exists(public_path("$folder/$file"))) {
        File::delete(public_path("$folder/$file"));
        // echo $folder."--".$file."--".$table."--".$column."--".$id."--".$eid;
      }
      return redirect('/employee_edit_master?search_emp=' . $eid);
    } else {
      return redirect('/employee_edit_master?search_emp=' . $eid);
    }
  }

  public function changedata()
  {
    $data = DB::table('emp_mst')->select('id', 'DOB', 'DOC', 'DOJ', 'DOP', 'retirement_date', 'confirm_date')->get();
    foreach ($data as $key => $val) {
      $data = [
        'DOB' => $val->DOB ? date('Y-m-d', strtotime($val->DOB)) : null,
        'DOC' => $val->DOC ? date('Y-m-d', strtotime($val->DOC)) : null,
        'DOJ' => $val->DOJ ? date('Y-m-d', strtotime($val->DOJ)) : null,
        'DOP' => $val->DOP ? date('Y-m-d', strtotime($val->DOP)) : null,
        'retirement_date' => $val->retirement_date ? date('Y-m-d', strtotime($val->retirement_date)) : null,
        'confirm_date' => $val->confirm_date ? date('Y-m-d', strtotime($val->confirm_date)) : null
      ];
      DB::table('emp_mst')->where('id', $val->id)->update($data);
    }
    //UPDATE `emp_mst` SET `DOB` = NULL,`DOJ` = NULL,`DOP` = NULL,`retirement_date` = NULL,`confirm_date` = NULL WHERE `DOB` = '0000-00-00';

  }


  public function resetdata()
  {
    $users = DB::table('emp_mst')->select('id', 'emp_no')->get();
    foreach ($users as $key => $val) {
      $data = ['emp_no' => $val->emp_no];
      DB::table('emp_antecedent_dtl')->where('emp_no', $val->id)->update($data);
      DB::table('emp_revocation_dtl')->where('emp_no', $val->id)->update($data);
      DB::table('emp_achievement_dtl')->where('emp_no', $val->id)->update($data);
      DB::table('emp_appreciation')->where('emp_no', $val->id)->update($data);
      DB::table('emp_reward')->where('emp_no', $val->id)->update($data);
      DB::table('empmst_official')->where('emp_no', $val->id)->update($data);
      DB::table('emp_initiation_dtl')->where('emp_no', $val->id)->update($data);
      // emp_antecedent_dtl,emp_revocation_dtl,emp_achievement_dtl,emp_appreciation,emp_reward,empmst_official,emp_initiation_dtl
    }
    return 1;
  }

  public function zklibrarytest()
  {
    return view('zklibrarytest');
  }

  public function Attendance()
  {
    $zkLibrary = new ZKLibrary('172.168.1.208', 4370); //polosoftech biometrics
    // $zkLibrary = new ZKLibrary('192.168.10.55', 4370); //samaj biometrics
    $zkLibrary->connect();
    $zkLibrary->enableDevice();
    $current_date = date('Y-m-d');
    $allattendancesdata = $zkLibrary->getAttendance();
    foreach($allattendancesdata as $key=>$userattnd)
    {
        $cur_attend_date_arr = explode(' ',$userattnd[3]);
        $user_cur_attend_dt=$cur_attend_date_arr[0];
      
        if($current_date!=$user_cur_attend_dt)
        {
          unset($allattendancesdata[$key]);
        }
      
    }
    //dd($allattendancesdata);
    $attendances = Attendance::where('punching_date', Attendance::max('punching_date'))->paginate(18);
    return view('Frontend.attendance', ['attendances' => $attendances]);
  }

  public function AttendanceCreate(Request $request)
  {
    // $zkLibrary = new ZKLibrary('172.168.1.208', 4370); //polosoftech biometrics
    $zkLibrary = new ZKLibrary('192.168.10.55', 4370); //samaj biometrics
    $zkLibrary->connect();
    $zkLibrary->enableDevice();
    $current_date = $request->date;
    $allattendancesdata = $zkLibrary->getAttendance();
    foreach($allattendancesdata as $key=>$userattnd)
    {
      $cur_attend_date_arr = explode(' ',$userattnd[3]);
      $user_cur_attend_dt=$cur_attend_date_arr[0];
    
      if($current_date==$user_cur_attend_dt)
      {
        $attendancedata = Attendance::where(['emp_no' => $userattnd[1], 'punching_date' => $cur_attend_date_arr[0], 'punching_log' => $cur_attend_date_arr[1]])->get();
        $empMst = DB::table('emp_mst_live')->where('emp_no', $userattnd[0])->get();
        if(count($empMst) != 0){
          if(count($attendancedata) == 0) {
            $dept = DB::table('emp_mst_live')->where('emp_no', $userattnd[1])->value('DEPT_NO');
            $card_no = DB::table('emp_mst_live')->where('emp_no', $userattnd[1])->value('card_no');
            $createAttendance                = new Attendance();
            $createAttendance->emp_no        = $userattnd[1];
            $createAttendance->card_no       = $card_no;
            $createAttendance->dept_no       = $dept;
            $createAttendance->location      = "Cuttack";
            $createAttendance->punching_date = $cur_attend_date_arr[0];
            $createAttendance->punching_log  = $cur_attend_date_arr[1];
            $createAttendance->save();
          }
        }
      }      
    }
    $attendances = Attendance::where('punching_date', $current_date)->paginate(18);
    return view('Frontend.attendance', ['attendances' => $attendances]);
  }
}