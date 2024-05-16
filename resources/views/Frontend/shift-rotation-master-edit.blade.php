@extends('Frontend.footer')
@extends('Frontend.master')
@section('content')
<style>
  .table-bordered>tbody>tr>td,
  .table-bordered>tbody>tr>th,
  .table-bordered>tfoot>tr>td,
  .table-bordered>tfoot>tr>th,
  .table-bordered>tbody>tr>td,
  .table-bordered>tbody>tr>th {
    border: 1px solid #ddd !important;
  }

  .table>tbody>tr>td,
  .table>tbody>tr>th,
  .table>tfoot>tr>td,
  .table>tfoot>tr>th,
  .table>tbody>tr>td,
  .table>tbody>tr>th {
    padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
  }

  .table>tbody>tr>td {
    border: none;
    color: white !important;
    font-size: 12px;
    letter-spacing: 1px;
    font-weight: bold;
  }

  .table>tbody>tr>th {
    color: white;
    font-weight: 700;
    font-size: 13px;
    border: none;
    letter-spacing: 1px;
    text-transform: uppercase;
    background-color: green;
  }

  th {
    text-align: inherit;
    color: white;
    font-weight: 700;
    font-size: 13px;
    border: none;
    letter-spacing: 1px;
    text-transform: uppercase;
    background-color: green;
    border-top: 1px solid;
    padding-left: 10px;
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
<div id="content" class="main-content">
  <div class="layout-px-spacing">
    <div class="account-settings-container mt-1 layout-top-spacing">
      <div class="account-content">
        <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
          <div class="row">
            <div class="col-xl-12 pb-1 col-lg-8 mx-auto col-md-12 layout-spacing">
              <div id="general-info" class="section general-info">
                <div class="info">
                  <div class="row">
                    <div class="col-md-12 text-left p-0">
                      <h6 class="">SHIFT ROTATION MASTER</h6>
                    </div>
                    {{-- <div class="mt-1 float-right">
                      <a href="{{ url('/shift-rotation-calendar-view/') }}" class="btn btn-primary">Calendar View</a>
                    </div> --}}
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
                      <form action="#" method="post">
                        {{csrf_field()}}
                        <div class="col-12 py-2 ">
                          <input type="hidden" id="token" value="{{ csrf_token() }}" />
                          <input type="hidden" name="shift_rotation_id" id="shift_rotation_id" value="{{ $shift_rotation_data->id }}">
                          <div class=" row">
                            <div class="col-md-12">
                              <div class="row">
                                <label for="inputEmail3" class="col-md-2">Code</label>
                                <div class="col-md-10">
                                  <input type="text" class="form-control" name="code" id="code"
                                    value="{{ $shift_rotation_data->code }}" required readonly>
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
                                $shift = explode(",", $shift_rotation_data->shift_pattern);
                                ?>
                                  <select multiple placeholder="Choose shift" id="shift_pattern" name="shift_pattern[]"
                                    data-allow-clear="1" required>
                                    @foreach($ShiftDatas as $ShiftData)
                                    <option value="{{ $ShiftData->Scode }}" {{ in_array($ShiftData->Scode, $shift) ?
                                      'selected' : '' }}>
                                      {{ $ShiftData->Scode . "(" . $ShiftData->InTime . "," . $ShiftData->outtime . ")"
                                      }}
                                    </option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class=" row mt-4">
                            <div class="col-md-12">
                              <div class="row">
                                <label for="inputEmail3" class="col-md-2">Monthly</label>
                                <div class="col-md-4">
                                  <select name="monthly" id="monthly" class="form-control" required>
                                    <option value="TRUE" <?php if ($shift_rotation_data->monthly == 'TRUE') { echo
                                      'selected'; } ?>>TRUE</option>
                                    <option value="FALSE" <?php if ($shift_rotation_data->monthly == 'FALSE') { echo
                                      'selected'; } ?>>FALSE</option>
                                  </select>
                                </div>
                                <label for="inputEmail3" class="col-md-2">Skip Pattern</label>
                                <div class="col-md-4">
                                  monthly true you can use ","
                                  <input type="text" class="form-control" required name="skip_pattern"
                                    value="<?php echo $shift_rotation_data->skip_pattern; ?>">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <a href="{{ url('/shift-rotation-master') }}" class="btn btn-secondary"
                            data-dismiss="modal"><i class="fa fa-times"></i> Close</a>
                          <input type="button" onclick="shiftRotation()" value="Save changes" class="btn btn-primary">
                        </div>
                        <?php
                          $monthly = $shift_rotation_data->monthly;
                          if($monthly == "TRUE") {                 
                            $shift_patterns = explode(",", $shift_rotation_data->shift_pattern);
                            $skip_patterns = explode(",", $shift_rotation_data->skip_pattern);
                            $curMonth = date('m');
                            $curYear = date('Y');
                            
                            for ($month = 1; $month <= 3; $month++) {
                              $firstDay = strtotime("$curYear-$month-01");
                              $numDays = date('t', $firstDay);
                              echo '<div class="calendar">';
                              echo "<h6 class='text-left mt-0 mb-0'> Month " . $month ."</h6>";
                              echo "<table border='1' style='border-collapse: collapse;width: 100%;float: left;margin: 10px;'>";
                              echo "<tr>
                                      <th>Sun</th>
                                      <th>Mon</th>
                                      <th>Tue</th>
                                      <th>Wed</th>
                                      <th>Thu</th>
                                      <th>Fri</th>
                                      <th>Sat</th>
                                    </tr>";
                              echo "<tr>";
                              for ($i = 0; $i < date('w', $firstDay); $i++) {
                                echo "<td>&nbsp;</td>";
                              }
                              foreach ($skip_patterns as $key => $value) {
                                if ($key == 0) {
                                  for ($day = $value; $day <= $skip_patterns[$key+1] - 1; $day++) { ?>
                                    <td class="p-3 mb-2 text-dark bg-info calendar_light">{{$day}}
                                      <hr>
                                      {{ $shift_patterns[$key] }}
                                    </td>
                                    <?php
                                    if ((date('w', strtotime("$curYear-$month-$day")) + 1) % 7 == 0) {
                                      echo "</tr><tr>";
                                    }
                                  }
                                } elseif ($key != count($skip_patterns)-1 ){
                                  for ($day = $value; $day <= $skip_patterns[$key+1] - 1; $day++) { ?>
                                    <td class="p-3 mb-2 text-dark bg-info calendar_light">{{$day}}
                                      <hr>
                                      {{ $shift_patterns[$key] }}
                                    </td>
                                    <?php
                                    if ((date('w', strtotime("$curYear-$month-$day")) + 1) % 7 == 0) {
                                      echo "</tr><tr>";
                                    }
                                  }
                                }else {
                                  for ($day = $value; $day <= $numDays; $day++) { ?>
                                    <td class="p-3 mb-2 text-dark bg-info calendar_light">{{$day}}
                                      <hr>
                                      {{ $shift_patterns[$key] }}
                                    </td>
                                    <?php
                                    if ((date('w', strtotime("$curYear-$month-$day")) + 1) % 7 == 0) {
                                      echo "</tr><tr>";
                                    }
                                  }
                                }
                              }

                              for ($i = 0; (date('w', strtotime("$curYear-$month-$numDays")) + $i + 1) % 7 != 0; $i++) {
                                echo "<td>&nbsp;</td>";
                              }
                              echo "</tr></table>";
                              echo "<br>";
                              echo "</div>";
                            }
                          } else {
                            $shift_patterns = explode(",", $shift_rotation_data->shift_pattern);
                            $skip_patterns = $shift_rotation_data->skip_pattern;
                            $curMonth = date('m');
                            $curYear = date('Y');

                            $patterncount = 1;
                            $shiftPatternCount = count($shift_patterns);
                            $skipPatternsCount = 1;
                            $shiftCount = 1;

                            for ($month = 1; $month <= 3; $month++) {
                              $firstDay = strtotime("$curYear-$month-01");
                              $numDays = date('t', $firstDay);
                              echo '<div class="calendar">';
                              echo "<h6 class='text-left mt-0 mb-0'> Month " . $month . "</h6>";
                              echo "<table border='1' style='border-collapse: collapse;width: 100%;float: left;margin: 10px;'>";
                              echo "<tr>
                                      <th>Sun</th>
                                      <th>Mon</th>
                                      <th>Tue</th>
                                      <th>Wed</th>
                                      <th>Thu</th>
                                      <th>Fri</th>
                                      <th>Sat</th>
                                    </tr>";
                              echo "<tr>";
                              for ($i = 0; $i < date('w', $firstDay); $i++) {
                                echo "<td>&nbsp;</td>";
                              }
                              
                              if ($skip_patterns == 1) {                                
                                for ($day = 1; $day <= $numDays; $day++) {
                                  ?>
                                  <td class="p-3 mb-2 text-dark bg-info calendar_light">{{$day}}
                                    <hr>
                                    <?php
                                    if ($patterncount == $shiftPatternCount) {
                                      echo $shift_patterns[$patterncount - 1];
                                      $patterncount = 1;
                                    } else {
                                      echo $shift_patterns[$patterncount - 1];
                                      $patterncount++;
                                    }
                                    ?>
                                  </td>
                                  <?php
                                  if ((date('w', strtotime("$curYear-$month-$day")) + 1) % 7 == 0) {
                                    echo "</tr><tr>";
                                  }
                                }                         
                              } else {
                                
                                for ($day = 1; $day <= $numDays; $day++) {
                                  ?>
                                  <td class="p-3 mb-2 text-dark bg-info calendar_light">{{$day}}
                                    <hr>
                                    <?php
                                    if ($skip_patterns == $skipPatternsCount) {
                                      if($shiftPatternCount == $shiftCount){
                                        echo $shift_patterns[$shiftCount - 1];
                                        $shiftCount = 1;
                                      } else {
                                        echo $shift_patterns[$shiftCount - 1];
                                        $shiftCount++;
                                      }
                                      $skipPatternsCount = 0;
                                    } else {
                                      echo $shift_patterns[$shiftCount - 1];
                                    }
                                    $skipPatternsCount++;
                                    ?>
                                  </td>
                                  <?php
                                  if ((date('w', strtotime("$curYear-$month-$day")) + 1) % 7 == 0) {
                                    echo "</tr><tr>";
                                  }
                                }
                              }
                              for ($i = 0; (date('w', strtotime("$curYear-$month-$numDays")) + $i + 1) % 7 != 0; $i++) {
                                echo "<td>&nbsp;</td>";
                              }
                              echo "</tr></table>";
                              echo "<br>";
                              echo "</div>";
                            }
                          }
                        ?>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
          <script>
            function shiftRotation() {
              var shift_rotation_id = $('#shift_rotation_id').val();
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
                    url: "{{ url('/update-shift-rotation-data') }}",
                    type: "POST",
                    data: {
                      shift_rotation_id: shift_rotation_id,
                      code: code, 
                      shift_pattern: shiftpattern, 
                      monthly: monthly, 
                      skip_pattern: skippattern, 
                      _token: $('#token').val()
                    },
                    success:function(response){                        
                      alert("Shift Rotaion Updated Successfully");
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
                    url: "{{ url('/update-shift-rotation-data') }}",
                    type: "POST",
                    data: {
                      shift_rotation_id: shift_rotation_id,
                      code: code, 
                      shift_pattern: shiftpattern, 
                      monthly: monthly, 
                      skip_pattern: skippattern, 
                      _token: $('#token').val()
                    },
                    success:function(response){                        
                      alert("Shift Rotaion Updated Successfully");
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
          <script src="{{url('/')}}/public/assets/js/libs/jquery-3.1.1.min.js"></script>
          <script src="{{url('/')}}/public/bootstrap/js/popper.min.js"></script>
          <script src="{{url('/')}}/public/bootstrap/js/bootstrap.min.js"></script>
          <script src="{{url('/')}}/public/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
          <script src="{{url('/')}}/public/assets/js/app.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
          <script>
            $(document).ready(function() {
            App.init();
          });
          $(function() {
            $('select').each(function() {
              $(this).select2({
                theme: 'bootstrap4',
                width: 'style',
                placeholder: $(this).attr('placeholder'),
                allowClear: Boolean($(this).data('allow-clear')),
              });
            });
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
            var msg = '{{Session::get('alert ')}}';
            var exist = '{{Session::has('alert ')}}';
            if (exist) {
              alert(msg);
            }
          </script>
          {{-- Tag script --}}
          <script src="https://cdnjs.cloudflare.com/ajax/libs/magicsuggest/2.1.5/magicsuggest.js"></script>
          @php
          $shiftList= DB::table('tms_shifts')->get();
          @endphp
          
          @endsection