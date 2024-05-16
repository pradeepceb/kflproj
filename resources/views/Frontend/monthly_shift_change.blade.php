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
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="account-settings-container mt-1 layout-top-spacing">
            <div class="account-content">
                <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll"
                    data-offset="-100">
                    <div class="row">
                        <div class="col-xl-12 pb-1 col-lg-12 px-2 col-md-12 layout-spacing">
                            <div id="general-info" class="section general-info">
                                <div class="info">
                                    <div class="row">
                                        <div class="col-md-12 text-left p-0">
                                            <h6 class="mb-0">Shift Information/ Shedule</h6>
                                        </div>
                                        <div class="col-md-12 mx-auto py-2">
                                            <div class="row">
                                                <label for="inputEmail3" class="col-md-6 text-right">Enter Month & Year</label>
                                                <form action="{{url('/monthly-shift-change-search')}}" method="POST" >
                                                    @csrf
                                                    <div class="col-md-8" style="display: flex; align-items: center; gap: 0 10px;">
                                                        <input type="month" class="form-control" id="month" name="month_year">
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 pb-1 col-lg-12 col-md-12 layout-spacing">
                            <div id="general-info" class="section general-info">
                                <div class="info">
                                    <div class="row">
                                        <div class="col-md-12 text-left p-0">
                                            <h6 class="mb-0">{{ date('F', mktime(0, 0, 0, $month, 10)) }} {{ $year }}
                                            </h6>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 mx-auto">
                                            <div style="overflow-x:auto;">


                                                <table style="width:1550px;"
                                                    class="table border-none table-hover text-center">
                                                    <thead class="py-2">
                                                        <tr class="py-2">
                                                            <th>Emp Code</th>
                                                            <th>1 </th>
                                                            <th>2</th>
                                                            <th>3</th>
                                                            <th>4</th>
                                                            <th>5</th>
                                                            <th>6</th>
                                                            <th>7</th>
                                                            <th>8</th>
                                                            <th>9</th>
                                                            <th>10</th>
                                                            <th>11 </th>
                                                            <th>12</th>
                                                            <th>13</th>
                                                            <th>14</th>
                                                            <th>15</th>
                                                            <th>16</th>
                                                            <th>17</th>
                                                            <th>18</th>
                                                            <th>19</th>
                                                            <th>20</th>
                                                            <th>21 </th>
                                                            <th>22</th>
                                                            <th>23</th>
                                                            <th>24</th>
                                                            <th>25</th>
                                                            <th>26</th>
                                                            <th>27</th>
                                                            <th>28</th>
                                                            <th>29</th>
                                                            <th>30</th>
                                                            <th>31</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($MonthlyShiftGenerates as $ky=>$val)
                                                        <tr class="py-2">
                                                            <td>{{$val->empcode}}</td>
                                                            <td>{{$val->d1}}</td>
                                                            <td>{{$val->d2}}</td>
                                                            <td>{{$val->d3}}</td>
                                                            <td>{{$val->d4}}</td>
                                                            <td>{{$val->d5}}</td>
                                                            <td>{{$val->d6}}</td>
                                                            <td>{{$val->d7}}</td>
                                                            <td>{{$val->d8}}</td>
                                                            <td>{{$val->d9}}</td>
                                                            <td>{{$val->d10}}</td>
                                                            <td>{{$val->d11}}</td>
                                                            <td>{{$val->d12}}</td>
                                                            <td>{{$val->d13}}</td>
                                                            <td>{{$val->d14}}</td>
                                                            <td>{{$val->d15}}</td>
                                                            <td>{{$val->d16}}</td>
                                                            <td>{{$val->d17}}</td>
                                                            <td>{{$val->d18}}</td>
                                                            <td>{{$val->d19}}</td>
                                                            <td>{{$val->d20}}</td>
                                                            <td>{{$val->d21}}</td>
                                                            <td>{{$val->d22}}</td>
                                                            <td>{{$val->d23}}</td>
                                                            <td>{{$val->d24}}</td>
                                                            <td>{{$val->d25}}</td>
                                                            <td>{{$val->d26}}</td>
                                                            <td>{{$val->d27}}</td>
                                                            <td>{{$val->d28}}</td>
                                                            <td>{{$val->d29}}</td>
                                                            <td>{{$val->d30}}</td>
                                                            <td>{{$val->d31}}</td>
                                                            <td>
                                                                <a href="" data-toggle="modal" id="openModalBtn"
                                                                    title="Edit" class="editbtn" data-id="{{ $val->empcode }}" data-month="{{ $month }}" data-year="{{ $year }}"
                                                                    class="btn btn-success editbtn"><svg
                                                                        xmlns="http://www.w3.org/2000/svg" width="18"
                                                                        height="18" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-edit-2 text-success">
                                                                        <path
                                                                            d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                                        </path>
                                                                    </svg></a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        @if($MonthlyShiftGenerates->count() == 0)
                                                            <tr>
                                                                <td colspan="32" class="text-center">No Data Found</td>
                                                            </tr>
                                                        @endif
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

<!-- edit modal start here		-->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit monthly shift generates</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="editForm">
                {{csrf_field()}}
                <input type="hidden" class="form-control" id="empcode">
                <input type="hidden" class="form-control" id="monthdata">
                <input type="hidden" class="form-control" id="year">
                <div class="modal-body pb-0">
                    <input type="hidden" class="form-control" name="holiday_id" id="holiday_id"
                        aria-describedby="textHelp">
                    <div class="col-12 py-2 ">
                        <div class="row">
                            <label class="col-md-2" for="">Date</label>
                            <div class="col-md-4">
                                <input type="date" class="form-control" id="dateData" name="dateData" >
                            </div>
                            @php
                                $tms_shifts = DB::table('tms_shifts')->orderBy('id', 'DESC' )->get();
                            @endphp
                            <label class="col-md-2 pr-0" for="">Shift</label>
                            <div class="col-md-4">
                                <select name="child_cat_id" id="shift_rotation" class="form-control shiftrotation">
                                    <option value="">--select shift--</option>
                                    @foreach($tms_shifts as $ky=>$val)
                                    <option value="{{$val->Scode}}">{{$val->Scode}} : {{$val->InTime}} - {{$val->outtime}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>
                            Close</button>
                        <button type="button" id="submitButton" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Save
                            changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- edit modal end here		-->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="{{url('/public')}}/assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="{{url('/public')}}/bootstrap/js/popper.min.js"></script>
<script src="{{url('/public')}}/bootstrap/js/bootstrap.min.js"></script>
<script src="{{url('/public')}}/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="{{url('/public')}}/assets/js/app.js"></script>
<script src="{{url('/public')}}/assets/js/custom.js"></script>
<script>
    $(document).ready(function() {      
        $("#openModalBtn").click(function() {
            var empCode = $(this).data('id');
            var month = $(this).data('month');
            var year = $(this).data('year');

            $("#empcode").val(empCode);
            $("#monthdata").val(month);
            $("#year").val(year);
            $(".bd-example-modal-lg").modal('show');
        });

        $('#submitButton').on('click', function() {
            var empCode = $("#empcode").val();
            var month = $("#monthdata").val();
            var year = $("#year").val();
            var shift = $("#shift_rotation").val();
            var date = $("#dateData").val();

            $.ajax({
                type: 'POST',
                url: "{{url('/monthlyShiftChangeEdit')}}",
                dataType: "json",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'empCode': empCode,
                    'month': month,
                    'year': year,
                    'shift': shift,
                    'date': date
                },
                success: function(data) {
                    alert(data.msg)
                    location.reload();
                },
                error: function(data) {
                    alert(data.msg)
                }
            });
        });
    });
</script>
<!-- END GLOBAL MANDATORY SCRIPTS -->
@endsection