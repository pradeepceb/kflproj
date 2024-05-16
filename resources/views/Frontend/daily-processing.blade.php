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
</style>
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
  <div class="layout-px-spacing">

    <div class="account-settings-container mt-1 layout-top-spacing">
      <div class="account-content">
        <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
          <div class="row">
            <div class="col-xl-12 mx-auto mt-4 pb-1 col-lg-12 col-md-12 layout-spacing">
              <div id="general-info" class="section general-info">
                <div class="info">
                  <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Daily Processing</h6>
                  </div>
                  <div class="row px-3 mt-3">
                    <div class="col-lg-12">
                      <form action="{{ url('/') }}/daily-processing-data" method="post">
                        {!! csrf_field() !!}
                        <div style="margin-left:40px">
                          <h5>Data Processing</h5>
                        </div>
                        <div class="col ml-2">
                          <div class="row ml-1">
                            <label class="ml-5 mt-2 ">FROM</label>
                            <div class="col-md-3 mt-2">
                              <input type="date" id="fromdate" name="from_date" class="form-control" max="{{date('Y-m-d')}}" required>
                            </div>
                            <label class="ml-5  mt-2">TO</label>
                            <div class="col-md-3 mt-2">
                              <input type="date" class="form-control" id="todate" name="to_date" max="{{date('Y-m-d')}}" onclick="fromandtodate();" required>
                            </div>
                          </div>
                          <div class="row px-3">
                            <div class="col-lg-6 p-0">
                              <fieldset class="border rounded" style="width:250px ;height:120px">
                                <legend class="ml-3 col-md-7 text-dark">Employee
                                </legend>
                                <div class="row">
                                  <label class="ml-3 col-md-3  ">FROM</label>
                                  <div class="col-md-8 ">
                                    <select class="nice-select-country form-control" name="employee_from">
                                      <option value=""> - select employee - </option>
                                      @foreach(Helper::allEmployeDetails() as $cn)
                                      <option value="{{ $cn->EMP_NO }}">{{ $cn->EMP_NO }} - {{ $cn->EMP_NAME }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="row mt-2">
                                  <label class="ml-3 col-md-3  ">TO</label>
                                  <div class="col-md-8 ">
                                    <select class="nice-select-country form-control" name="employee_to">
                                      <option value=""> - select employee - </option>
                                      @foreach(Helper::allEmployeDetails() as $cn)
                                      <option value="{{ $cn->EMP_NO }}">{{ $cn->EMP_NO }} - {{ $cn->EMP_NAME }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                              </fieldset>
                            </div>
                            <div class="col-lg-5 p-0">
                              <fieldset class="border rounded " style="width:250px ;height:120px;margin-left:-20px">
                                <legend class="ml-2 col-md-8 text-dark">Department
                                </legend>
                                <div class="row  ">
                                  <label class="ml-3 col-md-3  ">FROM</label>
                                  <div class="col-md-8 ">
                                    <select class="nice-select-country form-control" name="department_from">
                                      <option value=""> - select department - </option>
                                      @foreach(Helper::DepartmentData() as $cn)
                                      <option value="{{ $cn->id }}">{{ $cn->id }} - {{ $cn->DEPT_NAME }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="row mt-2">
                                  <label class="ml-3 col-md-3  ">TO</label>
                                  <div class="col-md-8 ">
                                    <select class="nice-select-country form-control" name="department_to">
                                      <option value=""> - select department - </option>
                                      @foreach(Helper::DepartmentData() as $cn)
                                      <option value="{{ $cn->id }}">{{ $cn->id }} - {{ $cn->DEPT_NAME }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                              </fieldset>
                            </div>
                          </div>
                          <div class="row text-center my-2 mr-4">
                            <div class="col">
                              <div style="margin-top: 10px;">
                                <button class="btn btn-success" data-toggle="modal" data-target=".bd-example-modal-xl">
                                  <b>Process</b> </button>
                                <button class="btn btn-danger ml-5" data-toggle="modal"
                                  data-target=".bd-example-modal-xl">
                                  <b>Close</b>
                                </button>
                              </div>
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

    function fromandtodate(){
      var from_date = $('#fromdate').val();
      console.log(from_date);
      $('#todate').attr('min',from_date);
    }
</script>
<!-- END GLOBAL MANDATORY SCRIPTS -->
@endsection