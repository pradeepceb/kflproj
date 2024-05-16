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
            <div class="col-xl-12 pb-1 col-lg-12 px-2 col-md-12 layout-spacing">
              <div id="general-info" class="section general-info">
                <div class="info">
                  <div class="row">
                    <div class="col-md-12 text-left p-0">
                      <h6 class="mb-0">ATTENDANCE CREATE</h6>
                    </div>
                    <div class="col-md-12 mx-auto py-2">
                      <div class="row">
                        <label for="inputEmail3" class="col-md-6 text-right">Attendance enter Date</label>
                        <form action="{{url('/attendance_create')}}" method="POST">
                          @csrf
                          <div class="col-md-8" style="display: flex; align-items: center; gap: 0 10px;">
                            <input type="date" class="form-control" name="date" max="{{ date('Y-m-d') }}">
                            <button type="submit" class="btn btn-primary">Save</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xl-12 pb-1 col-lg-12 col-md-12 layout-spacing mx-auto">
              <div id="general-info" class="section general-info">
                <div class="info">
                  <div class="row">
                    <div class="col-md-12 text-left p-0">
                      <h6 class="">ATTENDANCE</h6>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12 mx-auto">
                      <table class="table table-bordered table-hover text-center">
                        <thead>
                          <tr>
                            <th>Id</th>
                            <th>EMP NO</th>
                            <th>CARD NO</th>
                            <th>LOCATION</th>
                            <th>PUNCH DATE</th>
                            <th>PUNCH TIME</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($attendances as $ky=>$val)
                          <tr>
                            <td>{{ $val->id }}</td>
                            <td>{{ $val->emp_no }}</td>
                            <td>{{ $val->card_no?$val->card_no:'9876 5432 1987' }}</td>
                            <td>{{ $val->location }}</td>
                            <td>{{ $val->punching_date }}</td>
                            <td>{{ $val->punching_log }}</td>                            
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                      <br>
                      {{ $attendances->appends(Request::all())->links() }}
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
<script src="{{url('/public')}}/assets/js/custom.js"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->
@endsection