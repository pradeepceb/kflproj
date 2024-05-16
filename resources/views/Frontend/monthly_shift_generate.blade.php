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
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="account-settings-container mt-3 layout-top-spacing">
            <div class="account-content">
                <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll"
                    data-offset="-100">
                    @if(session('alert'))
                    <div class="alert alert-success">
                        {{ session('alert') }}
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-xl-12 pb-1 col-lg-12 col-md-12 layout-spacing mx-auto">
                            <div id="general-info" class="section general-info">
                                <div class="info">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">MONTHLY SHIFT GENERATION</h5>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-lg-12 mx-auto">
                                            <form action="{{url('/')}}/monthly-shift-generate" method="post">
                                                {{csrf_field()}}
                                                <div style="margin-left:200px">
                                                    <h5>Create Shift File for</h5>
                                                </div>
                                                <div class="col-12 py-2 px-3">
                                                    <div class="row">
                                                        <label class="col-md-2" for="">Month</label>
                                                        <div class="col-md-3">
                                                            <select name="month" class="form-control">
                                                                <option value=""> --select month-- </option>
                                                                @for($i=1; $i<=12; $i++) <option
                                                                    value="{{ date('m', mktime(0, 0, 0, $i, 10)) }}"> {{
                                                                    date('F', mktime(0, 0, 0, $i, 10)) }} </option>
                                                                    @endfor
                                                            </select>
                                                        </div>
                                                        <label class="col-md-2 text-right" for="">Year</label>
                                                        <div class="col-md-3">

                                                            <select name="year" class="form-control">
                                                                <option value=""> --select year-- </option>
                                                                <option value="2023" <?php if(date('Y')=="2023" ) {?>
                                                                    selected
                                                                    <?php } ?>>2023
                                                                </option>
                                                                <option value="2024" <?php if(date('Y')=="2024" ) {?>
                                                                    selected
                                                                    <?php } ?>>2024
                                                                </option>
                                                                <option value="2025" <?php if(date('Y')=="2025" ) {?>
                                                                    selected
                                                                    <?php } ?>>2025
                                                                </option>
                                                                <option value="2026" <?php if(date('Y')=="2026" ) {?>
                                                                    selected
                                                                    <?php } ?>>2026
                                                                </option>
                                                                <option value="2027" <?php if(date('Y')=="2027" ) {?>
                                                                    selected
                                                                    <?php } ?>>2027
                                                                </option>
                                                                <option value="2028" <?php if(date('Y')=="2028" ) {?>
                                                                    selected
                                                                    <?php } ?>>2028
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row text-center mt-4 mr-2">
                                                    <div class="col-12 pb-3">
                                                        <button class="btn btn-success"
                                                            data-target=".bd-example-modal-xl"> <b> Generate Shift</b>
                                                        </button>
                                                        <button class="btn btn-danger"
                                                            data-target=".bd-example-modal-xl">
                                                            <b>Close</b> </button>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value=""
                                                                id="flexCheckDefault">
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                Overwrite Sheduling
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


    <!-- Modal -->
    <!-- <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Department Edit Data</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body pb-0">
                  <form action="">
                      <div class="col-12 py-2 ">
                          <div class="row">
                              <label class="col-md-3" for="">Department</label>
                              <div class="col-md-9">
                                  <input type="text" class="form-control">
                              </div>
                          </div>

                          <div class="row mt-2">
                              <label class="col-md-3 pr-0" for="">Description</label>
                              <div class="col-md-9">
                                  <input type="text" class="form-control">
                              </div>
                          </div>
                      </div>



                  </form>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Save changes</button>
              </div>
          </div>
      </div>
  </div> -->
    <!-- Modal -->
    <!-- <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel"> Add New Department</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body pb-0">
                  <form action="">
                      <div class="col-12 py-2 ">
                          <div class="row">
                              <label class="col-md-3" for="">Department</label>
                              <div class="col-md-9">
                                  <input type="text" class="form-control">
                              </div>
                          </div>

                          <div class="row mt-2">
                              <label class="col-md-3 pr-0" for="">Description</label>
                              <div class="col-md-9">
                                  <input type="text" class="form-control">
                              </div>
                          </div>
                      </div>



                  </form>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Save</button>
              </div>
          </div>
      </div>
  </div> -->
</div>
<!--  END CONTENT AREA  -->
</div>
<!-- END MAIN CONTAINER -->
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
</script>
<!-- END GLOBAL MANDATORY SCRIPTS -->
@endsection