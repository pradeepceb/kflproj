@extends('Frontend.footer')
@extends('Frontend.master')
@section('content')

<link rel="stylesheet" type="text/css" href="{{url('/public')}}/plugins/table/datatable/datatables.css">
<link rel="stylesheet" type="text/css" href="{{url('/public')}}/plugins/table/datatable/custom_dt_html5.css">
<link rel="stylesheet" type="text/css" href="{{url('/public')}}/plugins/table/datatable/dt-global_style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" />
<meta name="csrf-token" content="{{ csrf_token() }}" />

<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
  <div class="layout-px-spacing">
    <div class="account-settings-container mt-1 layout-top-spacing">
      <div class="account-content">
        <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
          <!-- Employee view listing table start here -->
          <div class="row">
            <div class="col-xl-12 pb-1 col-lg-12 col-md-12 layout-spacing">
              <div id="general-info" class="section general-info">
                <div class="info">
                  <div class="row">
                    <div class="col-md-12 text-left p-0">
                      <h6 class="mb-0">PERIODIC PERFORMANCE REPORT FROM :@php echo($fromDate) @endphp TO : @php echo($toDate) @endphp</h6>
                    </div>
                    <div class="col-lg-12 mx-auto">
                      <div style="overflow-x:auto;">
                        <table style="width:150%;" class="table border-none table-hover text-center">
                          <tbody>
                            @for ($i = 0; $i < count($periodicPerformance); $i++)
                            <tr>
                              <th width="5%">Emp No: {{ $periodicPerformance[$i][0]['emp_no'] }}</th>
                              <th width="5%">Emp Name: {{ $periodicPerformance[$i][0]['emp_name'] }}</th>
                              <th width="5%">Emp Dept: {{ $periodicPerformance[$i][0]['dept_name'] }}</th>
                              <th width="5%">Card No: {{ $periodicPerformance[$i][0]['card_no'] }}</th>
                            </tr>
                            <tr>
                              <th width="5%">Date:</th>
                              @foreach ($periodicPerformance[$i] as $key1 => $val1)
                                <td width="5%" style="color: #272c87"><b>{{ date('d' , strtotime($val1['punching_date'])) }}</b></td> 
                              @endforeach
                              <td width="5%" style="color: #272c87"><b>Total</b></td>
                            </tr>
                            <tr>
                              <th width="5%">In</th>
                              @foreach ($periodicPerformance[$i] as $key1 => $val1)
                                <td width="5%">{{ $val1['in_time'] }}</td>
                              @endforeach
                              <td width="5%" ></td>
                            </tr>
                            <tr>
                              <th width="5%">Out</th>
                              @foreach ($periodicPerformance[$i] as $key1 => $val1)
                                <td width="5%">{{ $val1['out_time'] }}</td> 
                              @endforeach
                              <td width="5%" ></td>
                            </tr>
                            <tr>
                              <th width="5%">Late</th>
                              @foreach ($periodicPerformance[$i] as $key1 => $val1)
                                <td width="5%">{{ $val1['earlhrs'] }}</td> 
                              @endforeach
                              <td width="5%" >{{ array_sum(explode(':', $val1['earlhrs'])) }}</td>
                            </tr>
                            <tr>
                              <th width="5%">Early</th>
                              @foreach ($periodicPerformance[$i] as $key1 => $val1)
                                <td width="5%">{{ $val1['earlhrs'] }}</td> 
                              @endforeach
                              <td width="5%" >{{ array_sum(explode(':', $val1['earlhrs'])) }}</td>
                            </tr>
                            <tr>
                              <th width="5%">Wrkhrs</th>
                              @foreach ($periodicPerformance[$i] as $key1 => $val1)
                                <td width="5%">{{ $val1['wrkhrs'] }}</td> 
                              @endforeach
                              <td width="5%" >{{ array_sum(explode(':', $val1['wrkhrs'])) }}</td>
                            </tr>
                            <tr>
                              <th width="5%">OT Hrs</th>
                              @php
                                $overtimeSum = 0;
                              @endphp
                              @foreach ($periodicPerformance[$i] as $key1 => $val1)
                                <td width="5%">{{ $val1['overtime'] }}</td>
                                @php
                                  $timeComponents  = explode(':', $val1['overtime']);
                                  if (count($timeComponents) === 3) {
                                    $overtimeSum += $timeComponents[0] * 3600 + $timeComponents[1] * 60 + $timeComponents[2];
                                  }
                                @endphp
                              @endforeach
                              <td width="5%" >{{ gmdate("H:i:s", $overtimeSum) }}</td>
                            </tr>
                            <tr>
                              <th width="5%">Status</th>
                              @foreach ($periodicPerformance[$i] as $key1 => $val1)
                                <td width="5%">{{ $val1['status'] }}</td> 
                              @endforeach
                              <td width="5%" ></td>
                            </tr>
                            <tr>
                              <th width="5%">Shitf</th>
                              @foreach ($periodicPerformance[$i] as $key1 => $val1)
                                <td width="5%">{{ $val1['shift'] }}</td> 
                              @endforeach
                              <td width="5%" ></td>
                            </tr>
                            @endfor
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
</div>
<style type="text/css">
  table.table.border-none.table-hover.text-center tbody {
    height: 450px;
    overflow-y: scroll;
    display: block;
    overflow-x: hidden;

  }



  table.table.border-none.table-hover.text-center thead,
  table.table.border-none.table-hover.text-center tbody tr {
    display: table;
    width: 100%;
    table-layout: fixed;
  }

  table.table.border-none.table-hover.text-center table th,
  td {}

  table.table.border-none.table-hover.text-center thead {
    width: calc(100% - 1em)
  }

  table.table.border-none.table-hover.text-center table {
    border: 0px !important;
  }

  table.table.border-none.table-hover.text-center .modal-body label {
    font-size: 12px;
  }

  @media (min-width: 992px) {

    .modal-lg,
    .modal-xl {
      max-width: 1050px !important;
    }

    .modal-dialog {
      margin-top: 0rem !important;
    }
  }

  .days-thead {
    font-size: 11px;
    color: blue;
    background-color: #f8f8f8;
  }

  .days {
    border: 1px solid #ebebeb !important;
    /* border-radius:5px; */
  }

  .popup,
  .popup1 {
    height: 25px;
    border: none;
    background-color: #94bdff;
    border-radius: 5px;
    box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
  }

  .popupbox {
    position: relative;
  }

  .popuptext {
    display: none;
    width: 180px;
    background-color: #fff;
    color: #555;
    border-radius: 6px;
    height: 170px;
    overflow-y: auto;
    padding: 8px 10px;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    position: absolute;
    z-index: 1;
    top: 30%;
    left: 50%;
  }

  .popuptext.open {
    display: block;
  }
</style>
<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
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
<script src="{{url('/')}}/public/assets/js/custom.js"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->
<script src="{{url('/')}}/public/plugins/table/datatable/button-ext/dataTables.buttons.min.js"></script>
<script src="{{url('/')}}/public/plugins/table/datatable/button-ext/jszip.min.js"></script>
<script src="{{url('/')}}/public/plugins/table/datatable/button-ext/buttons.html5.min.js"></script>
<script src="{{url('/')}}/public/plugins/table/datatable/button-ext/buttons.print.min.js"></script>

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="public/plugins/table/datatable/datatables.js"></script>

<script src="{{ url('/') }}/assets/js/custom.js"></script>
<script src="{{url('/')}}/plugins/dropify/dropify.min.js"></script>
<script src="{{url('/')}}/plugins/blockui/jquery.blockUI.min.js"></script>
<!-- <script src="plugins/tagInput/tags-input.js"></script> -->
<script src="{{url('/')}}/assets/js/users/account-settings.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
  integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
  crossorigin="anonymous"></script>
</body>

</html>
@endsection