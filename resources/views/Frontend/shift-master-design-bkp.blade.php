@extends('Frontend.footer')
@extends('Frontend.master')
@section('content')
<style>
  @media (min-width: 992px){
    .newtms_design .modal-lg, .modal-xl {
    max-width: 800px !important;
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
                              <td>{{$val->Wrkhrs}}</td> 
                              <td>{{$val->HdStart}}</td> 
                              <td>{{$val->HdEnd}}</td> 
                              <td>{{$val->RstOut}}</td> 
                              <td>{{$val->Rstin}}</td> 
                              <td>{{$val->Rsthrs}}</td> 
                              <td>{{$val->HFOption}}</td> 
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

                <div class=" row">
                  <div class="col-md-12">
                    <div class="row">
                      
                        <div class="col-md-2">
                          <label for="inputEmail3" class="col-md-1">Code</label>
                          <input type="text" class="form-control col-md-4" name="Scode">
                        </div>

                        <div class="col-md-4" style="padding: 0px;margin: 0px;">
                          <label for="inputEmail3" class="col-md-6">In Time</label><br>
                          <select class="form-control  col-md-4 float-left" name="InTime_hour">
                            @for ($mm=1; $mm<=24; $mm++)
                            <option value="<?= $mm ?>" @if($mm == '6') selected @endif ><?= $mm ?></option>
                            @endfor
                          </select>
                          <select class="form-control  col-md-4" name="InTime_minute">
                            <option value="00">00</option>
                            <option value="30">30</option>
                          </select>
                        </div>


                        <div class="col-md-4" style="padding: 0px;margin: 0px;">
                          <label for="inputEmail3" class="col-md-6">Out Time</label><br>
                          <select class="form-control  col-md-4 float-left" name="outtime_hour">
                            @for ($mm=1; $mm<=24; $mm++)
                            <option value="<?= $mm ?>" @if($mm == '6') selected @endif ><?= $mm ?></option>
                            @endfor
                          </select>
                          <select class="form-control  col-md-4" name="outtime_minute">
                            <option value="00">00</option>
                            <option value="30">30</option>
                          </select>
                        </div>




                        <div class="col-md-4" style="padding: 0px;margin: 0px;">
                          <label for="inputEmail3" class="col-md-6">Rst In</label><br>
                          <select class="form-control  col-md-4 float-left" name="Rstin_hour">
                            @for ($mm=1; $mm<=24; $mm++)
                            <option value="<?= $mm ?>" @if($mm == '6') selected @endif ><?= $mm ?></option>
                            @endfor
                          </select>
                          <select class="form-control  col-md-4" name="Rstin_minute">
                            <option value="00">00</option>
                            <option value="30">30</option>
                          </select>
                        </div>


                        <div class="col-md-4" style="padding: 0px;margin: 0px;">
                          <label for="inputEmail3" class="col-md-6">Rst Out</label><br>
                          <select class="form-control  col-md-4 float-left" name="RstOut_hour">
                            @for ($mm=1; $mm<=24; $mm++)
                            <option value="<?= $mm ?>" @if($mm == '6') selected @endif ><?= $mm ?></option>
                            @endfor
                          </select>
                          <select class="form-control  col-md-4" name="RstOut_minute">
                            <option value="00">00</option>
                            <option value="30">30</option>
                          </select>
                        </div>

                        <div class="col-md-4" style="padding: 0px;margin: 0px;">
                          <label for="inputEmail3" class="col-md-6">Rst Hrs</label><br>
                          <select class="form-control  col-md-4 float-left" name="Rsthrs_hour">
                            @for ($mm=1; $mm<=24; $mm++)
                            <option value="<?= $mm ?>" @if($mm == '6') selected @endif ><?= $mm ?></option>
                            @endfor
                          </select>
                          <select class="form-control  col-md-4" name="Rsthrs_minute">
                            <option value="00">00</option>
                            <option value="30">30</option>
                          </select>
                        </div>

                        <div class="col-md-4" style="padding: 0px;margin: 0px;">
                          <label for="inputEmail3" class="col-md-6">Wrk Hrs</label><br>
                          <select class="form-control  col-md-4 float-left" name="Wrkhrs_hour">
                            @for ($mm=1; $mm<=24; $mm++)
                            <option value="<?= $mm ?>" @if($mm == '6') selected @endif ><?= $mm ?></option>
                            @endfor
                          </select>
                          <select class="form-control  col-md-4" name="Wrkhrs_minute">
                            <option value="00">00</option>
                            <option value="30">30</option>
                          </select>
                        </div>
                        <div class="col-md-4" style="padding: 0px;margin: 0px;">
                          <label for="inputEmail3" class="col-md-6">H.D.Start</label><br>
                          <select class="form-control  col-md-6 float-left" name="HdStart_hour">
                            @for ($mm=1; $mm<=24; $mm++)
                            <option value="<?= $mm ?>" @if($mm == '6') selected @endif ><?= $mm ?></option>
                            @endfor
                          </select>
                          <select class="form-control  col-md-6" name="HdStart_minute">
                            <option value="00">00</option>
                            <option value="30">30</option>
                          </select>
                        </div>

                        <div class="col-md-4" style="padding: 0px;margin: 0px;">
                          <label for="inputEmail3" class="col-md-6">H.D.End</label><br>
                          <select class="form-control  col-md-6 float-left" name="HdEnd_hour">
                            @for ($mm=1; $mm<=24; $mm++)
                            <option value="<?= $mm ?>" @if($mm == '6') selected @endif ><?= $mm ?></option>
                            @endfor
                          </select>
                          <select class="form-control  col-md-6" name="HdEnd_minute">
                            <option value="00">00</option>
                            <option value="30">30</option>
                          </select>
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
                          <input type="hidden" class="form-control" name="shift_id" id="shift_id"  aria-describedby="textHelp">
                          <div class=" row">
                            <div class="col-md-12">
                              <div class="row">
                                <label for="inputEmail3" class="col-md-2">Code</label>
                                  <div class="col-md-10">
                                    <input type="text" class="form-control" name="Scode" id="Scode">
                                  </div>
                              </div>
                            </div>
                          </div>
          
                          <div class=" row mt-2">
                            <div class="col-md-12">
                              <div class="row">
                                <label for="inputEmail3" class="col-md-2">In Time</label>
          
                                <div class="col-md-4" style="margin:0px;padding:0px;">
                                  <div class="col-md-12">
                                    <select class="form-control  col-md-6 float-left" name="InTime_hour" id="InTime_hour">
                                      @for ($mm=1; $mm<=24; $mm++)
                                      <option value="<?= $mm ?>" @if($mm == '6') selected @endif ><?= $mm ?></option>
                                      @endfor
                                    </select>
                                    <select class="form-control  col-md-6" name="InTime_minute" id="InTime_minute">
                                      <option value="00">00</option>
                                      <option value="30">30</option>
                                    </select>
                                  </div>
                                </div>
          
                                  <label for="inputEmail3" class="col-md-2">Out Time</label>
                                  <div class="col-md-4" style="margin:0px;padding:0px;">
                                    <div class="col-md-12">
                                      <select class="form-control  col-md-6 float-left" name="outtime_hour" id="outtime_hour">
                                        @for ($mm=1; $mm<=24; $mm++)
                                        <option value="<?= $mm ?>" @if($mm == '6') selected @endif ><?= $mm ?></option>
                                        @endfor
                                      </select>
                                      <select class="form-control  col-md-6" name="outtime_minute" id="outtime_minute">
                                        <option value="00">00</option>
                                        <option value="30">30</option>
                                      </select>
                                    </div>
                                  </div>
                              </div>
                            </div>
                          </div>
          
                          <div class=" row mt-2">
                            <div class="col-md-12">
                              <div class="row">
                                  <label for="inputEmail3" class="col-md-2">Rst In</label>
                                  <div class="col-md-4" style="margin:0px;padding:0px;">
                                    <div class="col-md-12">
                                      <select class="form-control  col-md-6 float-left" id="Rstin_hour" name="Rstin_hour">
                                        @for ($mm=1; $mm<=24; $mm++)
                                        <option value="<?= $mm ?>" @if($mm == '6') selected @endif ><?= $mm ?></option>
                                        @endfor
                                      </select>
                                      <select class="form-control  col-md-6" id="Rstin_minute" name="Rstin_minute">
                                        <option value="00">00</option>
                                        <option value="30">30</option>
                                      </select>
                                    </div>
                                  </div>
                                  <label for="inputEmail3" class="col-md-2">Rst Out</label>
                                  <div class="col-md-4" style="margin:0px;padding:0px;">
                                    <div class="col-md-12">
                                      <select class="form-control  col-md-6 float-left" id="RstOut_hour" name="RstOut_hour">
                                        @for ($mm=1; $mm<=24; $mm++)
                                        <option value="<?= $mm ?>" @if($mm == '6') selected @endif ><?= $mm ?></option>
                                        @endfor
                                      </select>
                                      <select class="form-control  col-md-6" id="RstOut_minute" name="RstOut_minute">
                                        <option value="00">00</option>
                                        <option value="30">30</option>
                                      </select>
                                    </div>
                                  </div>
                              </div>
          
          
                            </div>
                          </div>
          
                          <div class=" row mt-2">
                            <div class="col-md-12">
                              
          
                                <div class="row">
                                  <label for="inputEmail3" class="col-md-2">Rst Hrs</label>
                                  <div class="col-md-4" style="margin:0px;padding:0px;">
                                    <div class="col-md-12">
                                      <select class="form-control  col-md-6 float-left" id="Rsthrs_hour" name="Rsthrs_hour">
                                        @for ($mm=1; $mm<=24; $mm++)
                                        <option value="<?= $mm ?>" @if($mm == '6') selected @endif ><?= $mm ?></option>
                                        @endfor
                                      </select>
                                      <select class="form-control  col-md-6" id="Rsthrs_minute" name="Rsthrs_minute">
                                        <option value="00">00</option>
                                        <option value="30">30</option>
                                      </select>
                                    </div>
                                  </div>
          
                                  <label for="inputEmail3" class="col-md-2">Wrk Hrs</label>
                                  <div class="col-md-4" style="margin:0px;padding:0px;">
                                    <div class="col-md-12">
                                      <select class="form-control  col-md-6 float-left" id="Wrkhrs_hour" name="Wrkhrs_hour">
                                        @for ($mm=1; $mm<=24; $mm++)
                                        <option value="<?= $mm ?>" @if($mm == '6') selected @endif ><?= $mm ?></option>
                                        @endfor
                                      </select>
                                      <select class="form-control  col-md-6" id="Wrkhrs_minute" name="Wrkhrs_minute">
                                        <option value="00">00</option>
                                        <option value="30">30</option>
                                      </select>
                                    </div>
                                  </div>
                              </div>
          
                             
                            </div>
                          </div>


                          <div class=" row mt-2">
                            <div class="col-md-12">
                              <div class="row">
                                <label for="inputEmail3" class="col-md-2">H.D.Start</label>
                                <div class="col-md-4" style="margin:0px;padding:0px;">
                                  <div class="col-md-12">
                                    <select class="form-control  col-md-6 float-left" id="HdStart_hour" name="HdStart_hour">
                                      @for ($mm=1; $mm<=24; $mm++)
                                      <option value="<?= $mm ?>" @if($mm == '6') selected @endif ><?= $mm ?></option>
                                      @endfor
                                    </select>
                                    <select class="form-control  col-md-6" id="HdStart_minute" name="HdStart_minute">
                                      <option value="00">00</option>
                                      <option value="30">30</option>
                                    </select>
                                  </div>
                                </div>
          
                                <label for="inputEmail3" class="col-md-2">H.D.End</label>
                                <div class="col-md-4" style="margin:0px;padding:0px;">
                                  <div class="col-md-12">
                                    <select class="form-control  col-md-6 float-left" id="HdEnd_hour" name="HdEnd_hour">
                                      @for ($mm=1; $mm<=24; $mm++)
                                      <option value="<?= $mm ?>" @if($mm == '6') selected @endif ><?= $mm ?></option>
                                      @endfor
                                    </select>
                                    <select class="form-control  col-md-6" id="HdEnd_minute" name="HdEnd_minute">
                                      <option value="00">00</option>
                                      <option value="30">30</option>
                                    </select>
                                  </div>
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

            $('#shift_id').val(data[0]);
            $('#Scode').val(data[1]);

            var sdata = data[2].split(":");
            $('#InTime_hour').val(sdata[0]);
            $('#InTime_minute').val(sdata[1]);

            var sdata = data[3].split(":");
            $('#outtime_hour').val(sdata[0]);
            $('#outtime_minute').val(sdata[1]);

            var sdata = data[4].split(":");
            $('#Wrkhrs_hour').val(sdata[0]);
            $('#Wrkhrs_minute').val(sdata[1]);

            var sdata = data[5].split(":");
            $('#HdStart_hour').val(sdata[0]);
            $('#HdStart_minute').val(sdata[1]);

            var sdata = data[6].split(":");
            $('#HdEnd_hour').val(sdata[0]);
            $('#HdEnd_minute').val(sdata[1]);

            var sdata = data[7].split(":");
            $('#RstOut_hour').val(sdata[0]);
            $('#RstOut_minute').val(sdata[1]);

            var sdata = data[8].split(":");
            $('#Rstin_hour').val(sdata[0]);
            $('#Rstin_minute').val(sdata[1]);

            var sdata = data[9].split(":");
            $('#Rsthrs_hour').val(sdata[0]);
            $('#Rsthrs_minute').val(sdata[1]);

          });
    });
    </script> 
  
<script src="{{url('/')}}/public/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="{{url('/')}}/public/bootstrap/js/popper.min.js"></script>
    <script src="{{url('/')}}/public/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{url('/')}}/public/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="{{url('/')}}/public/assets/js/app.js"></script>
    
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="{{url('/')}}/public/assets/js/custom.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->


    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->

    <script src="public/plugins/dropify/dropify.min.js"></script>
    <script src="public/plugins/blockui/jquery.blockUI.min.js"></script>
    <!-- <script src="plugins/tagInput/tags-input.js"></script> -->
    <script src="public/assets/js/users/account-settings.js"></script>
    <!--  END CUSTOM SCRIPTS FILE  -->


    <script>
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
      alert(msg);
    }
  </script>
@endsection