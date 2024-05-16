@extends('Frontend.footer')
@extends('Frontend.master')
@section('content')
<style>
  .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
    border: 1px solid #ddd !important;
}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
}


.table > tbody > tr > td {
    border: none;
    color: white;
    font-size: 12px;
    letter-spacing: 1px;
    background-color: green;
    font-weight: 700;
}

.table > thead > tr > th {
    color: white;
    font-weight: 700;
    font-size: 13px;
    border: none;
    letter-spacing: 1px;
    text-transform: uppercase;
    background-color: green;
}

</style>
<div id="content" class="main-content newtms_design">
  <div class="layout-px-spacing">      
    <div class="account-settings-container mt-1 layout-top-spacing">
      <div class="account-content">
        <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll"
            data-offset="-100">
            <div class="row">
              <div class="col-xl-12 pb-1 col-lg-8 mx-auto col-md-12 layout-spacing">
                <div id="general-info" class="section general-info">
                  <div class="info">                              
                      <div class="row">
                        <div class="col-md-6 text-left p-0">
                          <h6 class="">SHIFT ROTATION MASTER</h6>
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
                          <div class="table-responsive">
                            <table class="table table-bordered responsive">
                              <thead>
                                <tr>
                                  <th scope="col" style="padding:15px 0px 5px 1px">Shift</th>
                                  <th scope="col" class="text-center">1</th>
                                  <th scope="col" class="text-center">2</th>
                                  <th scope="col" class="text-center">3</th>
                                  <th scope="col" class="text-center">4</th>
                                  <th scope="col" class="text-center">5</th>
                                  <th scope="col" class="text-center">6</th>
                                  <th scope="col" class="text-center">7</th>
                                  <th scope="col" class="text-center">8</th>
                                  <th scope="col" class="text-center">9</th>
                                  <th scope="col" class="text-center">10</th>
                                  <th scope="col" class="text-center">11</th>
                                  <th scope="col" class="text-center">12</th>
                                  <th scope="col" class="text-center">13</th>
                                  <th scope="col" class="text-center">14</th>
                                  <th scope="col" class="text-center">15</th>
                                  <th scope="col" class="text-center">16</th>
                                  <th scope="col" class="text-center">17</th>
                                  <th scope="col" class="text-center">18</th>
                                  <th scope="col" class="text-center">19</th>
                                  <th scope="col" class="text-center">20</th>
                                  <th scope="col" class="text-center">21</th>
                                  <th scope="col" class="text-center">22</th>
                                  <th scope="col" class="text-center">23</th>
                                  <th scope="col" class="text-center">24</th>
                                  <th scope="col" class="text-center">25</th>
                                  <th scope="col" class="text-center">26</th>
                                  <th scope="col" class="text-center">27</th>
                                  <th scope="col" class="text-center">28</th>
                                  <th scope="col" class="text-center">29</th>
                                  <th scope="col" class="text-center">30</th>
                                </tr>
                              </thead>
                              <tbody>
                              <tr>
                                @foreach ($Shift_Rotaion_view as $ss)
                                  @php
                                    $shift_patterns = explode(",", $ss->shift_pattern);        
                                    $first_shift    = $shift_patterns[0];
                                    $second_shift   = $shift_patterns[1];

                                    $skip_patterns = explode(",", $ss->skip_pattern);        
                                    $first_num     = $skip_patterns[0];
                                    $sec_num       = $skip_patterns[1];
                                  @endphp
                                  <td scope="row" style="padding:15px 0px 5px 0px">{{ $ss->shift_pattern }}</td>
                                  @for($m=$first_num;$m<=$sec_num-1;$m++)
                                    <td class="p-3 mb-2 bg-warning text-dark">{{ $first_shift }}</td>
                                  @endfor
                                  @for($m<=$sec_num;$m<=30;$m++)
                                    <td class="p-3 mb-2 bg-info text-dark" style="color:#fff !important;">{{ $second_shift }}</td>
                                  @endfor
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


          
	

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>                                      
    <script src="{{url('/')}}/public/assets/js/libs/jquery-3.1.1.min.js"></>
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

   
@endsection