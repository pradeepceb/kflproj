@extends('Frontend.footer')
@extends('Frontend.master')
@section('content')
<style>
  @media (min-width: 992px) {

    .newtms_design .modal-lg,
    .modal-xl {
      max-width: 742px !important;
    }
  }
</style>
<div id="content" class="main-content newtms_design">
  <div class="layout-px-spacing">
    <div class="account-settings-container mt-1 layout-top-spacing">
      <div class="account-content">
        <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
          <div class="row">
            <div class="col-xl-8 pb-1 col-lg-8 col-md-12 layout-spacing mx-auto">
              <div id="general-info" class="section general-info">
                <div class="info">
                  <div class="row">
                    <div class="col-md-12 text-left p-0">
                      <h6 class="">DEPARTMENT MASTER</h6>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12 mx-auto">
                      <table class="table table-bordered table-hover text-center">
                        <thead>
                          <tr>
                            <th>EMP CODE</th>
                            <th>NAME</th>
                            <th>DAYS FOR</th>
                            <th>ARREAR FOR</th>
                            <th>TOTAL DAYS</th>
                            <th>REMARKS</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($nightProcessing as $ky=>$val)
                          <tr>
                            <td>{{$val['emp_no']}}</td>
                            <td>{{$val['emp_name']}}</td>
                            <td>{{$val['days_for']}}</td>
                            <td>00.00</td>
                            <td>{{$val['total_day']}}</td>
                            <td>00.00</td>
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
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>

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
<script src="{{url('/public')}}/assets/js/custom.js"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->

<script>
  var msg = '{{Session::get('alert')}}';
  var exist = '{{Session::has('alert')}}';
  if(exist){
    alert(msg);
  }
</script>
@endsection