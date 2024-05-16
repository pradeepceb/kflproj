@extends('Frontend.footer')

@extends('Frontend.master')

@section('content')
<style>
    @media (min-width: 992px) {

        .newtms_design .modal-lg,
        .modal-xl {
            max-width: 445px !important;
        }
    }
</style>
<!--  BEGIN CONTENT AREA  -->
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
                                        <div class="col-md-12 text-left p-0">
                                            <h6 class="">CATEGORY MASTER</h6>
                                        </div>
                                        {{-- <div class="col-md-2 mt-1 pl-3 float-right">
                                            <button class="btn btn-primary" data-toggle="modal"
                                                data-target=".bd-example-modal-xl">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-plus">
                                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                                </svg> Add 
                                            </button>
                                        </div> --}}
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 mx-auto">
                                            <table class="table table-bordered table-hover text-center">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>.
                                                        <th>Category Code</th>
                                                        <th width="40%">Category Name</th>
                                                        <th>Action</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($Category_view as $ky=>$val)
                                                    <tr>
                                                        <td>{{$val->id}}</td>
                                                        <td>{{$val->category_code}}</td>
                                                        <td width="40%">{{$val->category_name}}</td>
                                                        <td>
                                                            <a href="" data-toggle="modal" data-target="#myModal"
                                                                title="Edit" class="editbtn"
                                                                class="btn btn-success editbtn">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="#2fbb4d" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-eye">
                                                                    <path
                                                                        d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z">
                                                                    </path>
                                                                    <circle cx="12" cy="12" r="3"></circle>
                                                                </svg>
                                                            </a>
                                                        </td>

                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table><br>
                                            {{ $Category_view->appends(Request::all())->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- add modal start here		-->
                    <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog"
                        aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form id="general-info" class="section general-info" action="{{url('/')}}/add-category"
                                method="post">
                                {!! csrf_field() !!}

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"> Add New Category</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body pb-0">
                                        <div class="col-12 py-2 ">
                                            <div class="row">
                                                <label class="col-md-4" for="">Category Code</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" name="cat_code" required="">
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <label class="col-md-4 pr-0" for="">Category Name</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" name="cat_name" required="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- add modal start here		-->

                    <!-- edit modal start here		-->
                    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
                        aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal-animation-14">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Category Details</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form action="{{url('/')}}/Update_Category_data" method="post">
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" name="cat_id" id="cat_id"
                                            aria-describedby="textHelp">
                                    </div>
                                    <div class="modal-body pb-0">
                                        <div class="col-12 py-2 ">
                                            <div class="row">
                                                <label class="col-md-4" for="">Category Code</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" name="cat_code"
                                                        id="cat_code" required="" readonly>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <label class="col-md-4 pr-0" for="">Category Name</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" id="cat_name"
                                                        name="cat_name" required readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
                                                console.log(data);
                                                $('#cat_id').val(data[0]);
                                                $('#cat_code').val(data[1]);
                                                $('#cat_name').val(data[2]);
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
                    <script>
                        var msg = '{{Session::get('alert')}}';
                        var exist = '{{Session::has('alert')}}';
                        if(exist){
                          alert(msg);
                        }
                    </script>
                    @endsection