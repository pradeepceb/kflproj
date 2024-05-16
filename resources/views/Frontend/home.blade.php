@extends('Frontend.footer')
@extends('Frontend.master')
@section('content')
 <div id="content" class="main-content">
            <div class="layout-px-spacing">                
                <div class="account-settings-container layout-top-spacing">
                    <div class="account-content">
                        <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                            <div class="row">
                                <div class="col-md-6">
                                       <img src="{{url('/public')}}/assets/img/time1.png" class="img-fluid" alt="Dashboard Image">
                                </div>
                                <div class=" col-md-6 m-auto" style=" border-radius:10px;">
                                    <div class="centered"> <span>T</span>ime <span>M</span>anagement <span>S</span>ystem</div>
                                </div>   
                            </div>
                        </div>
                    </div>
                </div>
                </div>
        </div>
@endsection

