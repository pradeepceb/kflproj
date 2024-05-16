@extends('Frontend.footer')
@extends('Frontend.master')
@section('content')
<style>
  @media (min-width: 992px) {
    .newtms_design .modal-lg, .modal-xl {
      max-width: 742px !important;
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
              <div class="col-xl-12 pb-1 col-lg-12 col-md-12 layout-spacing mx-auto">
                <div id="general-info" class="section general-info">
                  <div class="info">                              
                      <div class="row">
                        <div class="col-md-10 text-left p-0">
                          <h6 class="">LEAVE CODES MASTER</h6>
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
                              <th>Id</th>
                              <th>LEAVE CODE</th>
                              <th>LEAVE TYPE</th>
                              <th>PAID</th>
                              <th>Balance Maintained</th>
                              <th>Encashment Available</th>
                              <th>Running/ Working</th>
                              <th>Balance Carry Forward</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($Leave_Code_view as $ky=>$val)
                            <tr>
                              <td>{{$val->id}}</td>
                              <td>{{$val->leave_code}}</td> 
                              <td>{{$val->type_of_leave}}</td> 
                              <td>{{$val->paid}}</td> 
                              <td>{{$val->balanace_maintained}}</td> 
                              <td>{{$val->encashment_available}}</td> 
                              <td>{{$val->running_working}}</td> 
                              <td>{{$val->balance_carry_forward}}</td> 
                              <td>     
                              <a href=""  data-toggle="modal" data-target="#myModal" title="Edit" class="editbtn" class="btn btn-success editbtn" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>
                              <a href="delete_Leave_data/{{ $val->id }}" data-toggle="tooltip" data-placement="top" title="Delete"  onclick="return confirm('Do you want to delete this department record?');"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></a>
                              </td> 
                            </tr>
                            @endforeach
                          </tbody>
                          </table>
                        <br>
                        {{ $Leave_Code_view->appends(Request::all())->links() }}
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
		  <form id="general-info" class="section general-info" action="{{url('/')}}/add-leave-codes" method="post">
      {!! csrf_field() !!}  
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Add New Leave Code</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body pb-0">
                        <div class="col-12 py-2 ">
                            <div class="row">
                                <label class="col-md-3" for="">Leave Code</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control"  name="leave_code"  >
                                </div>

                                <label class="col-md-3 pr-0" for="">Type Of Leave</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="type_of_leave" >
                                </div>
                            </div>

                            <div class="row">
                              <label class="col-md-3" for="">Paid</label>
                              <div class="col-md-2">
                                 
                                  <select class="form-control"  name="paid" >
                                    <option value="">-- select an option --</option>
                                    <option value="TRUE">TRUE</option>
                                    <option value="FALSE">FALSE</option>
                                  </select>
                              </div>

                              <label class="col-md-3 pr-0" for="">Balance Maintained</label>
                              <div class="col-md-4">
                                  
                                  <select class="form-control"  name="balanace_maintained" >
                                    <option value="">-- select an option --</option>
                                    <option value="TRUE">TRUE</option>
                                    <option value="FALSE">FALSE</option>
                                  </select>
                              </div>
                          </div>

                          <div class="row">
                            <label class="col-md-3" for="">Encashment Available</label>
                            <div class="col-md-2">
                                
                                <select class="form-control"  name="encashment_available" >
                                  <option value="">-- select an option --</option>
                                  <option value="TRUE">TRUE</option>
                                  <option value="FALSE">FALSE</option>
                                </select>
                            </div>

                            <label class="col-md-3 pr-0" for="">Running(Ture)/ Working(False)
                            </label>
                            <div class="col-md-4">
                               

                                <select class="form-control"  name="running_working" >
                                  <option value="">-- select an option --</option>
                                  <option value="TRUE">TRUE</option>
                                  <option value="FALSE">FALSE</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                          <label class="col-md-3" for="">Balance Carry Forward</label>
                          <div class="col-md-2">
                              
                              <select class="form-control"  name="balance_carry_forward" >
                                <option value="">-- select an option --</option>
                                <option value="TRUE">TRUE</option>
                                <option value="FALSE">FALSE</option>
                              </select>
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
                        <h5 class="modal-title">Edit Leave Code</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
          
                       <form action="{{url('/')}}/Update_Leave_Codes"  method="post">
                        {{csrf_field()}}

                        <div class="modal-body pb-0">
                            <input type="hidden" class="form-control" name="leave_id" id="leave_id"  aria-describedby="textHelp">
                              <div class="col-12 py-2 ">

                                <div class="row">
                                  <label class="col-md-3" for="">Leave Code</label>
                                  <div class="col-md-2">
                                  <input type="text" class="form-control" id="leave_code"   name="leave_code"  >
                                  </div>
                                  
                                  <label class="col-md-3 pr-0" for="">Type Of Leave</label>
                                  <div class="col-md-4">
                                  <input type="text" class="form-control" id="type_of_leave" name="type_of_leave" >
                                  </div>
                                  </div>



                                  <div class="row">
                                    <label class="col-md-3" for="">Paid</label>
                                    <div class="col-md-2">
                                       
                                        <select class="form-control" id="paid"  name="paid" >
                                          <option value="">-- select option --</option>
                                          <option value="TRUE">TRUE</option>
                                          <option value="FALSE">FALSE</option>
                                        </select>
                                    </div>
      
                                    <label class="col-md-3 pr-0" for="">Balance Maintained</label>
                                    <div class="col-md-4">
                                        
                                        <select class="form-control" id="balanace_maintained"  name="balanace_maintained" >
                                          <option value="">-- select option --</option>
                                          <option value="TRUE">TRUE</option>
                                          <option value="FALSE">FALSE</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="row">
                                  <label class="col-md-3" for="">Encashment Available</label>
                                  <div class="col-md-2">
                                      
                                      <select class="form-control"  id="encashment_available"  name="encashment_available" >
                                        <option value="">-- select option --</option>
                                        <option value="TRUE">TRUE</option>
                                        <option value="FALSE">FALSE</option>
                                      </select>
                                  </div>
                                  <label class="col-md-3 pr-0" for="">Running(Ture)/ Working(False)
                                  </label>
                                <div class="col-md-4">
                                <select class="form-control"  id="running_working" name="running_working" >
                                  <option value="">-- select option --</option>
                                  <option value="TRUE">TRUE</option>
                                  <option value="FALSE">FALSE</option>
                                </select>
                                  </div>
                              </div>
                              <div class="row">
                                <label class="col-md-3" for="">Balance Carry Forward</label>
                                <div class="col-md-2">
                                    <select class="form-control" id="balance_carry_forward"  name="balance_carry_forward" >
                                      <option value="">-- select option --</option>
                                      <option value="TRUE">TRUE</option>
                                      <option value="FALSE">FALSE</option>
                                    </select>
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
	 <!-- edit modal end here		-->		
                                      
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>           
  

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



<script>
$(document).ready(function(){
  $('.editbtn').on('click' ,function(){
    $('#modal-animation-14').modal('show');
    $tr = $(this).closest('tr');
    var data = $tr.children("td").map(function(){
    return $(this).text();
    }).get();
    $('#leave_id').val(data[0]).prop("readonly", true);
    $('#leave_code').val(data[1]);
    $('#type_of_leave').val(data[2]);
    $('#paid').val(data[3]);
    $('#balanace_maintained').val(data[4]);
    $('#encashment_available').val(data[5]);
    $('#running_working').val(data[6]);
    $('#balance_carry_forward').val(data[7]);
  });
});
</script> 
@endsection