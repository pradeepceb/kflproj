@extends('Frontend.footer')
@extends('Frontend.master')
@section('content')
<style>
  @media (min-width: 992px) {

    .newtms_design .modal-lg,
    .modal-xl {
      max-width: 545px !important;
    }
  }
  .border-new {
    border: 1px solid #bfc9d4;
  }
</style>
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
  <div class="layout-px-spacing">

    <div class="account-settings-container mt-1 layout-top-spacing">

      <div class="account-content">
        <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
          <div class="row">
            <div class="col-xl-8 mt-4" style="margin:auto">
              <div id="general-info" class="section general-info">
                <div class="info">

                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Periodic Performance Report</h5>
                  </div>
                  <div class="modal-body p-0">
                    <form action="{{url('/')}}/periodic-performance-data" method="post">
                      {{csrf_field()}}
                      <div class="row m-0 p-2">
                        <label class="col-ml-2"> From Date </label>
                        <div class="col-md-3">
                          <input type="date" class="form-control" id="from_date" name="from_date" max="{{ date('Y-m-d') }}" required>
                        </div>
                        <label class="col-ml-2"> To Date </label>
                        <div class="col-md-3">
                          <input type="date" class="form-control" id="to_date" name="to_date" onclick="toDate();" required>
                        </div>
                        <div class="input-group-append">
                          <button type="submit" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                          <button type="button" class="btn btn-primary ml-2">Close</button>
                        </div>
                      </div>

                      <div class="row m-0 p-2">
                        <div class="form-check m-2">
                          <input class="form-check-input" type="radio" id="radioEmpCode" name="employeeSort" value="1" onclick="empCodeWiseDaily();" checked>
                          <label class="form-check-label" for="radioEmpCode">Emp Code Wise</label>
                        </div>

                        <div class="form-check m-2">
                          <input class="form-check-input" type="radio" id="radioEmpCode" value="2" name="employeeSort" onclick="departmentWiseDaily();">
                          <label class="form-check-label" for="radioEmpCode">Department Wise</label>
                        </div>
                      </div>

                      <div id="empCodeWise" style="display:block">
                        <div class="row border-new rounded p-2 m-0">
                          <div class="col-md-4">
                            <div class="row">
                              <div class="form-check col-md-6">
                                <input class="form-check-input" type="radio" value="1" name="empCodeWise" checked>
                                <label class="form-check-label" for="flexRadioDefault1">
                                  All
                                </label>
                              </div>
                              <div class="form-check col-md-6">
                                <input class="form-check-input" type="radio" value="2" name="empCodeWise">
                                <label class="form-check-label" for="flexRadioDefault2">
                                  Selected
                                </label>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="row">
                              <div class="form-check col-md-3">
                                <label class="form-check-label">Starting</label>
                              </div>
                              <div class="form-check col-md-9">
                                <select class="nice-select-country form-control" name="employee_from">
                                  <option value=""> - select employee - </option>
                                  @foreach(Helper::allEmployeDetails() as $cn)
                                  <option value="{{ $cn->EMP_NO }}">{{ $cn->EMP_NO }} - {{ $cn->EMP_NAME }}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="row">
                              <div class="form-check col-md-3">
                                <label class="form-check-label">Ending</label>
                              </div>
                              <div class="form-check col-md-9">
                                <select class="nice-select-country form-control" name="employee_to">
                                  <option value=""> - select employee - </option>
                                  @foreach(Helper::allEmployeDetails() as $cn)
                                  <option value="{{ $cn->EMP_NO }}">{{ $cn->EMP_NO }} - {{ $cn->EMP_NAME }}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>

                      <div id="departmentWise" style="display:none">
                        <div class="row border-new rounded p-2 m-0">
                          <div class="col-md-4">
                            <div class="row">
                              <div class="form-check col-md-6">
                                <input class="form-check-input" type="radio" value="1" name="departmentWise" checked>
                                <label class="form-check-label" for="flexRadioDefault1">
                                  All
                                </label>
                              </div>
                              <div class="form-check col-md-6">
                                <input class="form-check-input" type="radio" value="2" name="departmentWise">
                                <label class="form-check-label" for="flexRadioDefault2">
                                  Selected
                                </label>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-4">
                            <div class="row">
                              <div class="form-check col-md-3">
                                <label class="form-check-label">Starting</label>
                              </div>
                              <div class="form-check col-md-9">
                                <select class="nice-select-country form-control" name="department_from">
                                  <option value=""> - select department - </option>
                                  @foreach(Helper::DepartmentData() as $cn)
                                  <option value="{{ $cn->id }}">{{ $cn->id }} - {{ $cn->DEPT_NAME }}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="row">
                              <div class="form-check col-md-3">
                                <label class="form-check-label">Ending</label>
                              </div>
                              <div class="form-check col-md-9">
                                <select class="nice-select-country form-control" name="department_to">
                                  <option value=""> - select department - </option>
                                  @foreach(Helper::DepartmentData() as $cn)
                                  <option value="{{ $cn->id }}">{{ $cn->id }} - {{ $cn->DEPT_NAME }}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>

                      <div class="row  p-2 mt-2">
                        <div class="col-md-1">
                          <label class="form-check-label">Group</label>
                        </div>
                        <div class="col-md-3">
                          <input type="text" class="form-control">
                        </div>

                        <div class="col-md-1">
                          <label class="form-check-label">Category</label>
                        </div>
                        <div class="col-md-3 ml-3">
                          <input type="text" class="form-control">
                        </div>
                      </div>

                      <div class=" row  p-2 mt-2">
                        <label class="col-md-2" for="">Male/Female</label>
                        <div class="col-md-4">
                          <select class="form-control" id="" name="gender">
                            <option value="No">Both</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                          </select>
                        </div>

                      </div>
                      <div class="rwo">
                        <div class="col">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                            <label class="form-check-label" for="flexCheckChecked">
                              Page Break At Deptt.
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                            <label class="form-check-label" for="flexCheckChecked">
                              Report By Card No.
                            </label>
                          </div>
                        </div>
                      </div>
                    </form>
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
<!--  END CONTENT AREA  -->

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="{{url('/public')}}/assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="{{url('/public')}}/bootstrap/js/popper.min.js"></script>
<script src="{{url('/public')}}/bootstrap/js/bootstrap.min.js"></script>
<script src="{{url('/public')}}/assets/js/app.js"></script>
<script src="{{url('/public')}}/assets/js/custom.js"></script>

<script>
  $(document).ready(function(){
    setTimeout(function() {
      $('.alert').fadeOut('fast');
    }, 4000);
  });

  function empCodeWiseDaily(){
    $("#empCodeWise").show();
    $("#departmentWise").hide();
  }

  function departmentWiseDaily(){
    $("#departmentWise").show();
    $("#empCodeWise").hide();
  }

  function toDate() {
    updateMaxDate();
  }

  function updateMaxDate() {
    var selectedDateStr = $("#from_date").val();
    if (selectedDateStr) {
      var selectedDate = new Date(selectedDateStr);
      selectedDate.setMonth(selectedDate.getMonth() + 1);
      selectedDate.setDate(0);
      var lastDayOfMonth = selectedDate.toISOString().split('T')[0];
      $("#to_date").attr("max", lastDayOfMonth);
      $("#to_date").attr("min", selectedDateStr);
    } else {
      alert("Please select from date first");
    }
  }
</script>
<!-- END GLOBAL MANDATORY SCRIPTS -->
@endsection