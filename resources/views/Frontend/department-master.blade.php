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
            <div class="col-xl-12 pb-1 col-lg-12 col-md-12 layout-spacing mx-auto">
              <div id="general-info" class="section general-info">
                <div class="info">
                  <div class="row">
                    <div class="col-md-12 text-left p-0">
                      <h6 class="">DEPARTMENT MASTER</h6>
                    </div>
                    {{-- <div class="col-md-2 mt-1 pl-3 float-right">
                      <button class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="feather feather-plus">
                          <line x1="12" y1="5" x2="12" y2="19"></line>
                          <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg> Add </button>
                    </div> --}}
                  </div>
                  <div class="row">
                    <div class="col-lg-12 mx-auto">
                      <table class="table table-bordered table-hover text-center">
                        <thead>
                          <tr>
                            <th>Id</th>
                            <th>Department Number</th>
                            <th>Department Name</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($Department_view as $ky=>$val)
                          <tr>
                            <td>{{$val->id}}</td>
                            <td>{{$val->DEPT_NO}}</td>
                            <td>{{$val->DEPT_NAME}}</td>
                            <td>
                              <a href="" data-toggle="modal" data-target="#myModal" title="Edit" class="editbtn" class="btn btn-success editbtn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2fbb4d" stroke-width="2"
                                  stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                                  <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                  <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                              </a>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                      <br>
                      {{ $Department_view->appends(Request::all())->links() }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- add modal start here		-->
          <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <form id="general-info" class="section general-info" action="{{url('/')}}/add-department-master"
                method="post">
                {!! csrf_field() !!}
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Add New Department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @php
                  $getMaxRecord= DB::table('dept_mst_live')->count();
                  @endphp
                  <div class="modal-body pb-0">
                    <div class="col-12 py-2 ">
                      <div class="row">
                        <label class="col-md-3" for="">Department Number</label>
                        <div class="col-md-2">
                          <input type="text" class="form-control" readonly name="dept_no" required=""
                            value="{{ $getMaxRecord+1 }}">
                        </div>

                        <label class="col-md-3 pr-0" for="">Department Name</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" name="dept_name" required="">
                        </div>

                      </div>
                      <div class="row mt-2">

                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <!-- add modal start here		-->
          <!-- edit modal start here		-->
          <div class="modal fade bd-example-modal-lg" id="modal-animation-14" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">View Deaprtment Details</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <form action="{{url('/')}}/Update_Department_Data" method="post">
                  {{csrf_field()}}

                  <div class="modal-body pb-0">
                    <input type="hidden" class="form-control" name="dept_id" id="dept_id" aria-describedby="textHelp">
                    <div class="col-12 py-2 ">
                      <div class="row">
                        <label class="col-md-3" for="">Department Number</label>
                        <div class="col-md-2">
                          <input type="text" class="form-control" id="dept_no" name="dept_no" disabled
                            aria-describedby="textHelp">
                        </div>

                        <label class="col-md-3 pr-0" for="">Department Name</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" id="dept_name" name="dept_name"
                            aria-describedby="textHelp" disabled>
                        </div>


                      </div>
                      <div class="row mt-2">

                      </div>
                    </div>
                </form>

              </div>
            </div>
          </div>
          <!-- edit modal end here		-->
          <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
          <script>
    $(document).ready(function(){
        $('.editbtn').on('click' ,function(){
          $('#modal-animation-14').modal('show');
          $tr = $(this).closest('tr');
           var data = $tr.children("td").map(function(){
            return $(this).text();
           }).get();
          $('#dept_id').val(data[0]).prop("readonly", true);;
           $('#dept_no').val(data[1]);
           $('#dept_name').val(data[2]);
          });
    });
          </script>

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