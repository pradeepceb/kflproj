@extends('Frontend.footer')
@extends('Frontend.master')
@section('content')
<style type="text/css">
.boxdes {
    border: 1px solid #B2b2b2;
    padding: 8px;
    margin: 8px;
}
</style>

<div id="content" class="main-content newtms_design">
  <div class="layout-px-spacing">  
    
    <form method="POST" action="{{url('/')}}/option_data_update/" >
    {{csrf_field()}}
    <div class="account-settings-container mt-1 layout-top-spacing">
        <div class="account-content">
            <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll"
                data-offset="-100">
                <div class="row">
                    <div class="col-xl-12 mx-auto mt-0 pb-1 col-lg-12 col-md-12 layout-spacing">
                        <div id="general-info" class="section general-info">
                            <div class="info">
                                <div class="row">
                                    <div class="col-md-12 text-left p-0">
                                        <h6 class="mb-0">Options </h6>
                                    </div>
                                </div>
                                <div class="row px-3">
                                    <div class="col-lg-6 p-0">
                                        <div class="boxdes">
                                            <div class="row">
                                                <label for="inputEmail3" class="col-md-9">No. of Machines
                                                    Connected</label>
                                                <div class="col-md-3">
                                                    <input type="taxt" class="form-control" name="noof_machine_connected" value="{{ $OptionView->noof_machine_connected }}">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <label for="inputEmail3" class="col-md-9">Length of Card No.</label>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control" name="length_of_cardno" value="{{ $OptionView->length_of_cardno }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="inputEmail3" class="col-md-9">Max. Out Time
                                                    Search</label>
                                                <div class="col-md-3">
                                                    <input type="text" name="maxout_time_search" value="{{ $OptionView->maxout_time_search }}" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="inputEmail3" class="col-md-9">Time Gap for Shift
                                                    Change</label>
                                                <div class="col-md-3">
                                                    <input type="text" name="time_gap_for_shift_change" value="{{ $OptionView->time_gap_for_shift_change }}" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="inputEmail3" class="col-md-9">Filter for Duplicate
                                                    Punches</label>
                                                <div class="col-md-3">
                                                    <input type="text" name="filter_for_duplicate_punches"  value="{{ $OptionView->filter_for_duplicate_punches }}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="boxdes py-4">
                                            <input class="" type="checkbox" name="night_processing_required" 
                                            @if($OptionView->night_processing_required=='1') checked @endif value="1" id="flexCheckDefault">
                                            <label class="form-check-label pb-2" for="flexCheckDefault">
                                            Night Processing Required
                                            </label>

                                            <br>
                                            <input class="" type="checkbox" name="using_permission_card" @if($OptionView->using_permission_card=='1') checked @endif value="1" id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault">
                                             Using the Permission Cards
                                            </label>


                                        </div>
                                        <div class="boxdes">
                                            <div class="row">
                                                <label for="inputEmail3" class="col-md-9">Minimum Work Hours for
                                                    Half Present</label>
                                                <div class="col-md-3">
                                                    <input type="text" name="min_work_hr_half_present" value="{{ $OptionView->min_work_hr_half_present }}"   class="form-control">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <label for="inputEmail3" class="col-md-9">Minimum Over Time
                                                    Hours.</label>
                                                <div class="col-md-3">
                                                    <input type="text" name="min_over_time_hr" value="{{ $OptionView->min_over_time_hr }}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="inputEmail3" class="col-md-9">Maximum Short Leave Hours.
                                                </label>
                                                <div class="col-md-3">
                                                    <input type="text" name="max_short_leave_hr"  value="{{ $OptionView->max_short_leave_hr }}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="inputEmail3" class="col-md-9">Minimum Short Leave Hours.
                                                </label>
                                                <div class="col-md-3">
                                                    <input type="text" name="min_short_leave_hr" class="form-control" value="{{ $OptionView->min_short_leave_hr }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 p-0">
                                        <div class="boxdes">
                                            <P><b>Single Punch</b></P>
                                            <div class="row">
                                                <div class="form-check">
                                                    <input type="radio" name="single_punch" 
                                                        id="flexRadioDefault1" @if($OptionView->single_punch=='absent') checked @endif value="absent">
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        Absent
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-check">
                                                    <input type="radio" name="single_punch" 
                                                        id="flexRadioDefault1" @if($OptionView->single_punch=='half-day-present') checked @endif value="half-day-present">
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        Half Day Present
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-check">
                                                    <input type="radio" name="single_punch" 
                                                        id="flexRadioDefault1" @if($OptionView->single_punch=='full-day-present') checked @endif value="full-day-present">
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        Full Day Present
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="boxdes">
                                            <P><b>Over Time Calculation</b></P>
                                            <div class="row">
                                                <div class="form-check">
                                                    <input type="radio" name="over_time_calculation" id="flexRadioDefault1"  @if($OptionView->over_time_calculation=='after-normal-work-hours') checked @endif  value="after-normal-work-hours">
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        After Normal Work Hours
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-check">
                                                    <input type="radio" name="over_time_calculation" 
                                                        id="flexRadioDefault1" @if($OptionView->over_time_calculation=='after-before-shift-departure') checked @endif  value="after-before-shift-departure">
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        After/Before Shift's Departure/Arrival
                                                    </label>
                                                </div>
                                            </div>
                                            <hr class="m-1">
                                            <p><b>Over Time Round Off</b></p>
                                            <div class="row">
                                                <div class="form-check">
                                                    <input type="radio" name="over_time_round_off" 
                                                        id="flexRadioDefault1" @if($OptionView->over_time_round_off=='no') checked @endif  value="no">
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        No
                                                    </label>
                                                    <input type="radio" name="over_time_round_off" 
                                                        id="flexRadioDefault1" @if($OptionView->over_time_round_off=='25min') checked @endif  value="25min">
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        25 Min.
                                                    </label>
                                                    <input type="radio" name="over_time_round_off" 
                                                        id="flexRadioDefault1" @if($OptionView->over_time_round_off=='15%') checked @endif  value="15%">
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        15%
                                                    </label>
                                                    <input type="radio" name="over_time_round_off" 
                                                        id="flexRadioDefault1" @if($OptionView->over_time_round_off=='15Min') checked @endif  value="15Min">
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        15 Min
                                                    </label>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="boxdes">
                                            <div class="row">
                                                <label for="inputEmail3" class="col-md-9">Minimum Work Hours Full
                                                    Present</label>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control" name="minimum_work_hr_full_present" value="{{ $OptionView->minimum_work_hr_full_present }}">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <label class="col-md-6" for="inputEmail3">Late nos.</label>
                                                        <input type="text" name="late_nos" class="form-control col-md-4" value="{{ $OptionView->late_nos }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <label for="inputEmail3" class="col-md-6">Deduction</label>
                                                        <input type="text" name="deduction"  class="form-control col-md-5" value="{{ $OptionView->deduction }}">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <label for="inputEmail3" class="col-md-6">Month
                                                            start</label>
                                                        <input type="text" name="month_start" class="form-control col-md-4" value="{{ $OptionView->month_start }}">
                                                    </div>
                                                </div>
                                                {{-- <div class="col-md-6">
                                                    <div class="row">
                                                        <label for="inputEmail3" class="col-md-6">DOS
                                                            Print</label>
                                                        <select type="text" name="dos_print"  class="form-control col-md-5">
                                                            <option value="">True</option>
                                                            <option value="">False</option>
                                                    </select>

                                                    </div>
                                                </div> --}}

                                            </div>
                                            <div class="row">
                                                <label for="inputEmail3" class="col-md-9">Minimum Hours for Double
                                                    Duty</label>
                                                <div class="col-md-3">
                                                    <input type="text" name="min_hr_double_duty"   class="form-control" value="{{ $OptionView->min_hr_double_duty }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row text-center my-2">
                                    <div class="col">
                                        <button type="submit" class="btn btn-success"> <b> Update File</b> </button>
                                        <button class="btn btn-danger" >
                                            <b>Close</b> </button>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>
</form>
                 
<script src="{{url('/')}}/assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="{{url('/')}}/bootstrap/js/popper.min.js"></script>
<script src="{{url('/')}}/bootstrap/js/bootstrap.min.js"></script>
<script src="{{url('/')}}/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="{{url('/')}}/assets/js/app.js"></script>
@endsection