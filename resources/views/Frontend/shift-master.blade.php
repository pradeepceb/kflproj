@extends('Frontend.footer')
@extends('Frontend.master')
@section('content')
<style>
  @media (min-width: 992px){
    .newtms_design .modal-lg, .modal-xl {
    max-width: 1024px !important;
    }
  }
</style>
<div id="content" class="main-content newtms_design">
  <div class="layout-px-spacing">      
    <div class="account-settings-container mt-1 layout-top-spacing">
      <div class="account-content">
        <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll"
            data-offset="-100">
            <div class="row">
              <div class="col-xl-12 pb-1 col-lg-12 col-md-12 layout-spacing">
                <div id="general-info" class="section general-info">
                  <div class="info">                              
                      <div class="row">
                        <div class="col-md-10 text-left p-0">
                          <h6 class="">SHIFT MASTER</h6>
                        </div>
                        <div class="col-md-2 mt-1 pl-3 float-right">
                          <button class="btn btn-primary" data-toggle="modal"
                          data-target=".bd-example-modal-xl">
                          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                          viewBox="0 0 24 24" fill="none" stroke="currentColor"
                          stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
                              <th>In Time</th>
                              <th>Out Time</th>
                              <th>Rst Out</th>
                              <th>Rst In</th>
                              <th>Rst Hrs</th>
                              <th>Wrk Hrs</th>
                              <th>H.D.Start</th>
                              <th>H.D.End</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($Shift_view as $ky=>$val)
                            <tr>
                              <td>{{$val->id}}</td> 
                              <td>{{$val->Scode}}</td> 
                              <td>{{$val->InTime}}</td> 
                              <td>{{$val->outtime}}</td> 
                              <td>{{$val->RstOut}}</td> 
                              <td>{{$val->Rstin}}</td> 
                              <td>{{$val->Rsthrs}}</td> 
                              <td>{{$val->Wrkhrs}}</td> 
                              <td>{{$val->HdStart}}</td> 
                              <td>{{$val->HdEnd}}</td> 
                              <td>     
                              <a href=""  data-toggle="modal" data-target="#myModal" title="Edit" class="editbtn" class="btn btn-success editbtn" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>
                              <a href="delete_Shift_data/{{ $val->id }}" data-toggle="tooltip" data-placement="top" title="Delete"  onclick="return confirm('Do you want to delete this shift record?');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>
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

		  <form id="general-info" class="section general-info" action="{{url('/')}}/add-shift-master" method="post">
      {!! csrf_field() !!}  

      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> Add New Shift Information</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>



              <div class="modal-body pb-0">


                <div class="col-12 py-2 ">
                <div class=" row mt-2">
                  <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-1">
                          <label for="inputEmail3" class="col-md-2">Code</label>
                          <input type="text" class="form-control" name="Scode" required>
                        </div>

                        <div class="col-md-1">
                          <label for="inputEmail3" >In Time</label><br>
                          <input type="text" class="form-control" id="InTime" name="InTime" required>
                        </div>

                        <div class="col-md-1">
                          <label for="inputEmail3" style="font-size: 10px;">Out Time</label><br>
                          <input type="text" class="form-control" id="outtime" name="outtime" required>
                        </div>

                        <div class="col-md-1">
                          <label for="inputEmail3" style="font-size: 10px;">Rst Out</label><br>
                          <input type="text" class="form-control" id="RstOut" name="RstOut" required>
                        </div>

                        <div class="col-md-1">
                          <label for="inputEmail3">Rst In</label><br>
                          <input type="text" class="form-control" id="Rstin" name="Rstin" required>
                        </div>

                        <div class="col-md-1">
                          <label for="inputEmail3">Rst Hrs</label><br>
                          <input type="text" class="form-control" id="Rsthrs" name="Rsthrs" required>
                        </div>

                        <div class="col-md-1">
                          <label for="inputEmail3" style="font-size: 10px;">Wrk Hrs</label><br>
                          <input type="text" class="form-control" id="Wrkhrs" name="Wrkhrs" required>
                        </div>
    
                        <div class="col-md-1">
                          <label for="inputEmail3">H.D.Start</label><br>
                          <input type="text" class="form-control" name="HdStart" required>
                        </div>
    
                        <div class="col-md-1">
                          <label for="inputEmail3">H.D.End</label><br>
                          <input type="text" class="form-control" name="HdEnd" required>
                        </div>


                    </div>
                  </div>
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
                <div class="modal fade bd-example-modal-lg" id="modal-animation-14" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
                  aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Edit Shift Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body pb-0">
                       <form action="{{url('/')}}/update-shift-data"  method="post">
                        {{csrf_field()}}
                        <div class="col-12 py-2 ">

                          <input type="hidden" class="form-control shift_id" name="shift_id" id="shift_id"  aria-describedby="textHelp">

                          <div class=" row mt-2">
                            <div class="col-md-12">
                              <div class="row">                                
                                  <div class="col-md-1">
                                    <label for="inputEmail3" class="col-md-2">Code</label>
                                    <input type="text" class="form-control Scode" name="Scode" id="Scode" required>
                                  </div>                        
                                  <div class="col-md-1">
                                    <label for="inputEmail3" >In Time</label><br>
                                    <input type="text" class="form-control InTime" name="InTime" id="InTime" required>
                                  </div>                                           
                                  <div class="col-md-1">
                                    <label for="inputEmail3" style="font-size: 10px;">Out Time</label><br>
                                    <input type="text" class="form-control outtime" name="outtime" id="outtime" required>
                                  </div>   
                                  <div class="col-md-1">
                                    <label for="inputEmail3" style="font-size: 10px;">Rst Out</label><br>
                                    <input type="text" class="form-control RstOut" name="RstOut" id="RstOut" required>
                                  </div>                                           
                                  <div class="col-md-1">
                                    <label for="inputEmail3">Rst In</label><br>
                                    <input type="text" class="form-control Rstin" name="Rstin" id="Rstin" required>
                                  </div>
                                  <div class="col-md-1">
                                    <label for="inputEmail3">Rst Hrs</label><br>
                                    <input type="text" class="form-control Rsthrs" name="Rsthrs" id="Rsthrs" required>
                                  </div>
                                                                                              
                                  <div class="col-md-1">
                                    <label for="inputEmail3" style="font-size: 10px;">Wrk Hrs</label><br>
                                    <input type="text" class="form-control Wrkhrs" name="Wrkhrs" id="Wrkhrs" required>
                                  </div>
                                                                        
                                  <div class="col-md-1">
                                    <label for="inputEmail3">H.D.Start</label><br>
                                    <input type="text" class="form-control HdStart" name="HdStart" id="HdStart" required>
                                  </div>                        
                                  <div class="col-md-1">
                                    <label for="inputEmail3">H.D.End</label><br>
                                    <input type="text" class="form-control HdEnd" name="HdEnd" id="HdEnd" required>
                                  </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Save changes</button>
                      </div>
                          </form>
                      </div>
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
            $('.shift_id').val(data[0]);
            $('.Scode').val(data[1]);
            $('.InTime').val(data[2]);
            $('.outtime').val(data[3]);
            $('.RstOut').val(data[4]);
            $('.Rstin').val(data[5]);
            $('.Rsthrs').val(data[6]);
            $('.Wrkhrs').val(data[7]);
            $('.HdStart').val(data[8]);
            $('.HdEnd').val(data[9]);
          });
    });
      $("#Rsthrs").click(function(){
        var RstOut = $("#RstOut").val();
        var Rstin = $("#Rstin").val();
        var RstHourss  = calculateTimeDifference(RstOut, Rstin);
        // Display the difference
        $('#Rsthrs').val(RstHourss); 
      });

      $("#Wrkhrs").click(function(){
        var outtime          = $("#outtime").val();
        var InTime           = $("#InTime").val();
        var RstOut           = $("#RstOut").val();
        var Rstin            = $("#Rstin").val();

        var inout_diff       = calculateTimeDifference(outtime, InTime);
        var restin_out_diff  = calculateTimeDifference(Rstin, RstOut);
        var work_hours       = calculateTimeDifference(inout_diff, restin_out_diff);
        // Display the difference
        $('#Wrkhrs').val(work_hours); 
      });

      function calculateTimeDifference(time1, time2) {
        // Convert time strings to Date objects
        var date1 = new Date("1970-01-01T" + time1 + "Z");
        var date2 = new Date("1970-01-01T" + time2 + "Z");

        // Calculate the time difference in milliseconds
        var timeDiff = Math.abs(date2 - date1);

        // Convert the time difference to hours, minutes, seconds
        var hours = Math.floor(timeDiff / (1000 * 60 * 60));
        var minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);

        // Format the result
        return formatNumber(hours) + ":" + formatNumber(minutes);
      }
      function formatNumber(number) {
        // Add a leading zero if the number is a single digit
        return number < 10 ? "0" + number : number;
      }

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
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <script src="{{url('/public')}}/plugins/dropify/dropify.min.js"></script>
    <script src="{{url('/public')}}/plugins/blockui/jquery.blockUI.min.js"></script>
    <!-- <script src="plugins/tagInput/tags-input.js"></script> -->
    <script src="{{url('/public')}}/assets/js/users/account-settings.js"></script>
    <!--  END CUSTOM SCRIPTS FILE  -->
    <script>
      var msg = '{{Session::get('alert')}}';
      var exist = '{{Session::has('alert')}}';
      if(exist){
        alert(msg);
      }
    </script>
@endsection