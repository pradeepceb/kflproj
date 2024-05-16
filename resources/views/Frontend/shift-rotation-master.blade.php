@extends('Frontend.footer')
@extends('Frontend.master')
@section('content')
<style>
  @media (min-width: 992px) {

    .newtms_design .modal-lg,
    .modal-xl {
      max-width: 800px !important;
    }
  }

  select {
    width: 100%;
    min-height: 100px;
    border-radius: 3px;
    border: 1px solid #444;
    padding: 10px;
    color: #444444;
    font-size: 14px;
  }
</style>
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/magicsuggest/2.1.5/magicsuggest.css" rel="stylesheet"
  type="text/css">
<!-- select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<!-- select2-bootstrap4-theme -->
<link href="https://raw.githack.com/ttskch/select2-bootstrap4-theme/master/dist/select2-bootstrap4.css"
  rel="stylesheet">
<div id="content" class="main-content newtms_design">
  <div class="layout-px-spacing">
    <div class="account-settings-container mt-1 layout-top-spacing">
      <div class="account-content">
        <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
          <div class="row">
            <div class="col-xl-12 pb-1 col-lg-12 mx-auto col-md-12 layout-spacing">
              <div id="general-info" class="section general-info">
                <div class="info">
                  <div class="row">
                    <div class="col-md-10 text-left p-0">
                      <h6 class="">SHIFT ROTATION MASTER</h6>
                    </div>

                    {{-- <div class="mt-1 float-right">
                      <a href="{{ url('/shift-rotation-calendar-view/') }}" class="btn btn-primary">Calendar View</a>
                    </div> --}}

                    <div class="col-md-2 mt-1 pl-3 float-right">
                      <button class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          class="feather feather-plus">
                          <line x1="12" y1="5" x2="12" y2="19"></line>
                          <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg> Add </button>
                    </div>



                  </div>
                  <div class="row">
                    <div class="col-lg-12 mx-auto">
                      <table class="table table-bordered table-hover text-center">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Code</th>
                            <th>Shift Pattern</th>
                            <th>Monthly</th>
                            <th>Skip Pattern</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($Shift_Rotaion_view as $ky=>$val)
                          <tr>
                            <td>{{$val->id}}</td>
                            <td>{{$val->code}}</td>
                            <td>{{$val->shift_pattern}}</td>
                            <td>{{$val->monthly}}</td>
                            <td>{{$val->skip_pattern}}</td>
                            <td>
                              <a href="shift-rotation-master-edit/{{ $val->id }}" title="Edit"><svg
                                  xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                  fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                  stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                  <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                </svg></a>
                              <a href="delete_shift_rotation_data/{{ $val->id }}" data-toggle="tooltip"
                                data-placement="top" title="Delete"
                                onclick="return confirm('Do you want to delete this shift rotation record?');"><svg
                                  xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                  fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                  stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                                  <polyline points="3 6 5 6 21 6"></polyline>
                                  <path
                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                  </path>
                                </svg></a>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                      <br>
                      {{ $Shift_view->appends(Request::all())->links() }}
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
              <form class="section general-info" action="#" method="post">
                {!! csrf_field() !!}
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Add New Shift Rotation Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @php
                  $getMaxRecord= DB::table('tms_shift_rotation')->count();
                  @endphp
                  <div class="modal-body pb-0">
                    <div class="col-12 py-2 ">
                      <div class=" row">
                        <div class="col-md-12">
                          <em class="text-danger">put comma while adding shift pattern & skip pattern </em>
                          <div class="row">
                            <input type="hidden" id="token" value="{{ csrf_token() }}" />
                            <label for="inputEmail3" class="col-md-2">Code</label>
                            <div class="col-md-10">
                              <input type="text" class="form-control" id="code" readonly name="code" required
                                value="{{ $getMaxRecord+1 }}">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class=" row mt-4">
                        <div class="col-md-12">
                          <div class="row">
                            <label for="inputEmail3" class="col-md-2">Shift Pattern</label>
                            <div class="col-md-10">
                              <?php
                              $ShiftDatas = (new Helper())->ShiftData();
                              ?>
                              <select multiple placeholder="Choose shift" id="shift_pattern" name="shift_pattern[]" data-allow-clear="1" required>
                                @foreach($ShiftDatas as $ShiftData)
                                  <option value="{{ $ShiftData->Scode }}">{{ $ShiftData->Scode ."(". $ShiftData->InTime .",". $ShiftData->outtime .")" }}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row mt-4">
                        <div class="col-md-12">
                          <div class="row">
                            <label for="inputEmail3" class="col-md-2">Monthly</label>
                            <div class="col-md-4">
                              <select name="monthly" class="form-control" required>
                                <option value="TRUE">TRUE</option>
                                <option value="FALSE">FALSE</option>
                              </select>
                            </div>
                            <label for="inputEmail3" class="col-md-2">Skip Pattern</label>
                            <div class="col-md-4">
                              monthly true you can use ","
                              <input type="text" class="form-control" name="skip_pattern" required>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="button" onclick="shiftRotation()" value="Save" class="btn btn-primary">
                  </div>
                </div>
              </form>
            </div>
          </div>
          <!-- add modal start here		-->
          
          <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
          <script>
            function shiftRotation() {
              var code = $('#code').val();
              var shiftpattern = $('#shift_pattern').val();
              var monthly = $('[name="monthly"]').val();
              var skippattern = $('[name="skip_pattern"]').val();

              var shiftpatternAsString = shiftpattern.join(',');
              var arrayshift = shiftpatternAsString.split(',');
              var countshift = arrayshift.length;

              var arrayskip = skippattern.split(',');
              var countskip = arrayskip.length;
              if(monthly === "TRUE") {
                if (countshift !== countskip) {
                  alert("Skip pattern and shift pattern do not match");
                  return;
                } else {
                  $.ajax({
                    url: "{{ url('/add-shift-rotation-master') }}",
                    type: "POST",
                    data: {
                      code: code, 
                      shift_pattern: shiftpattern, 
                      monthly: monthly, 
                      skip_pattern: skippattern, 
                      _token: $('#token').val()
                    },
                    success:function(response){                        
                      alert("New Shift Rotation Added Successfully");
                      location.reload();
                    },
                    error:function(error){
                      alert("There is some issue. Please check."); 
                    }
                  });
                }
              } else {
                if(countskip == 1) {
                  $.ajax({
                    url: "{{ url('/add-shift-rotation-master') }}",
                    type: "POST",
                    data: {
                      code: code, 
                      shift_pattern: shiftpattern, 
                      monthly: monthly, 
                      skip_pattern: skippattern, 
                      _token: $('#token').val()
                    },
                    success:function(response){                        
                      alert("New Shift Rotation Added Successfully");
                      location.reload();
                    },
                    error:function(error){
                      alert("There is some issue. Please check.");
                    }
                  });
                } else {
                  alert("Skip pattern should be single value");
                  return;
                }
              }
            }
          </script>

          <script src="{{url('/public')}}/assets/js/libs/jquery-3.1.1.min.js"></script>
          <script src="{{url('/public')}}/bootstrap/js/popper.min.js"></script>
          <script src="{{url('/public')}}/bootstrap/js/bootstrap.min.js"></script>
          <script src="{{url('/public')}}/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
          <script src="{{url('/public')}}/assets/js/app.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
          <script>
            $(document).ready(function() {
              App.init();
            });
            $(function () {
              $('select').each(function () {
                $(this).select2({
                  theme: 'bootstrap4',
                  width: 'style',
                  placeholder: $(this).attr('placeholder'),
                  allowClear: Boolean($(this).data('allow-clear')),
                });
              });
            });
          </script>
          <script src="{{url('/public')}}/assets/js/custom.js"></script>
          <!-- END GLOBAL MANDATORY SCRIPTS -->

          <!--  BEGIN CUSTOM SCRIPTS FILE  -->
          <script src="{{url('/public')}}/plugins/dropify/dropify.min.js"></script>
          <script src="{{url('/public')}}/plugins/blockui/jquery.blockUI.min.js"></script>
          <!-- <script src="plugins/tagInput/tags-input.js"></script> -->
          <script src="{{url('/public')}}/assets/js/users/account-settings.js"></script>
          <!--  END CUSTOM SCRIPTS FILE  -->

          <script>
            var msg = '{{Session::get('alert')}}';
            var exist = '{{Session::has('alert')}}';
            if(exist){ alert(msg); }
          </script>
          {{-- Tag script --}}
          <script src="https://cdnjs.cloudflare.com/ajax/libs/magicsuggest/2.1.5/magicsuggest.js"></script>
          @php
          $shiftList= DB::table('tms_shifts')->get();
          @endphp
        </div>
      </div>
    </div>
  </div>
</div>
@endsection