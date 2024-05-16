<?php
use Illuminate\Http\Request;
use App\Emp_mst_live;
use App\Shift;
use App\Department_master;

class Helper{
    function editEmployeDetails($empid) {

        $employee_number = $empid;
        if (!DB::table('emp_mst_live')->where('EMP_NO', trim($employee_number))->exists()) {
            return redirect('/home');
        }
    
        $EmployeeModel = new Emp_mst_live();
        $EmployeeAllInfo = $EmployeeModel->getAllEmployeeInfo($employee_number);
        return $EmployeeAllInfo;
    }

    function ShiftData() {

        $Shift_view = Shift::select('id', 'Scode', 'InTime' , 'outtime')->orderBy('id', 'DESC')->get();
        return $Shift_view;
    }

    public static function DepartmentData() {

        $department_view = Department_master::select('id', 'DEPT_NO', 'DEPT_NAME')->orderBy('id', 'ASC')->get();
        return $department_view;
    }

    public static function allEmployeDetails() {

        $allEmployeeModel = Emp_mst_live::select('EMP_NO', 'EMP_NAME')->orderBy('EMP_NO', 'ASC')->get();
        return $allEmployeeModel;
    }

}
?>  