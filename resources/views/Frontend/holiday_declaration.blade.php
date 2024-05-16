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
                    <div class="col-md-10 text-left p-0">
                      <h6 class="">HOLIDAYS DECLARATION LIST</h6>
                    </div>
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
                            <th>Id</th>
                            <th>DECLARED ON</th>
                            <th>COMPENSATORY ON</th>
                            <th>DECLARED AS</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($Holiday_declarations as $ky=>$val)
                          <tr>
                            <td>{{$val->id}}</td>
                            <td>{{$val->declared_on}}</td>
                            <td>{{$val->compensatory_on}}</td>
                            <td>{{$val->declared_as}}</td>
                            <td>
                              <a href="" data-toggle="modal" data-target="#myModal" title="Edit" class="editbtn"
                                class="btn btn-success editbtn"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                  height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                  stroke-linecap="round" stroke-linejoin="round"
                                  class="feather feather-edit-2 text-success">
                                  <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                </svg></a>
                              <a href="delete-holiday-declaration/{{ $val->id }}" data-toggle="tooltip" data-placement="top"
                                title="Delete"
                                onclick="return confirm('Do you want to delete this department record?');"><svg
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
                      {{ $Holiday_declarations->appends(Request::all())->links() }}
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
              <form id="general-info" class="section general-info" action="{{url('/')}}/add-holiday-declaration"
                method="post">
                {!! csrf_field() !!}
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="" id="exampleModalLabel"> Add New Holiday Declaration</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <div class="modal-header">
                    <label for="inputEmail3" class="col-md-8">Holiday Declared on (dd/mm/yyyy)</label>
                    <div class="col-md-4">
                      <input type="date" class="form-control" name="declared_on">
                    </div>
                  </div>
                  <div class="modal-header">
                    <label for="inputEmail3" class="col-md-8">Compensatory Date on (dd/mm/yyyy)</label>
                    <div class="col-md-4">
                      <input type="date" class="form-control" name="compensatory_on">
                    </div>
                  </div>
                  <div class="modal-header">
                    <label for="inputEmail3" class="col-md-8">Holiday Declared as HH/WW (HH.Holiday WW.Weekoff)
                    </label>
                    <div class="col-md-4">
                      <select class="form-control" name="declared_as" id="type">
                        <option value="">-- select an option --</option>
                        <option value="HH">HH</option>
                        <option value="WW">WW</option>
                      </select>
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
              <form id="general-info" class="section general-info" action="{{url('/')}}/edit-holiday-declaration"
                method="post">
                {!! csrf_field() !!}
                <input type="hidden" class="form-control" name="holiday_id" id="holiday_id"
                      aria-describedby="textHelp">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="" id="exampleModalLabel">Edit Holiday Declaration</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <div class="modal-header">
                    <label for="inputEmail3" class="col-md-8">Holiday Declared on (dd/mm/yyyy)</label>
                    <div class="col-md-4">
                      <input type="date" class="form-control" name="declared_on" id="declared_on">
                    </div>
                  </div>
                  <div class="modal-header">
                    <label for="inputEmail3" class="col-md-8">Compensatory Date on (dd/mm/yyyy)</label>
                    <div class="col-md-4">
                      <input type="date" class="form-control" name="compensatory_on" id="compensatory_on">
                    </div>
                  </div>
                  <div class="modal-header">
                    <label for="inputEmail3" class="col-md-8">Holiday Declared as HH/WW (HH.Holiday WW.Weekoff)
                    </label>
                    <div class="col-md-4">
                      <select class="form-control" name="declared_as" id="declared_as">
                        <option value="">-- select an option --</option>
                        <option value="HH">HH</option>
                        <option value="WW">WW</option>
                      </select>
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
          <!-- edit modal end here		-->

        </div>
      </div>
    </div>
  </div>
</div>

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
      $('#holiday_id').val(data[0]).prop("readonly", true);
      $('#declared_on').val(data[1]);
      $('#compensatory_on').val(data[2]);
      $('#declared_as').val(data[3]);
    });
  });
</script>
@endsection