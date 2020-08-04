@extends('layouts.master')

@section('title') Dashboard @endsection

@section('css') 

@endsection

@section('content')
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{{$page}}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        {{-- <li class="breadcrumb-item"><a href="javascript: void(0);">Year/li> --}}
                        <?php if(!is_null($page_before)){echo "<li class='breadcrumb-item active'>$page_before</li>";}?>
                        <li class="breadcrumb-item active">{{$page}}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <form id="about_holidayForm" action="{{$action}}" method="post" class="needs-validation outer-repeater" novalidate="" enctype="multipart/form-data">
                <div class="col-sm-12">
                    <div class="form-group">
                        <button class="btn btn-primary">Save</button>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <h4 class="card-title">ผู้มีหน้าที่หักภาษี ณ ที่จ่าย</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_holiday_date">เลขประจำตัวผู้เสียภาษีอากร</label>
                                        <input type="text" name="about_holiday_date" class="form-control" id="about_holiday_date" placeholder="เลขประจำตัวผู้เสียภาษีอากร" value="{{@$about_holiday->about_holiday_date}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="about_holiday_date">ชื่อ</label>
                                        <input type="text" name="about_holiday_date" class="form-control" id="about_holiday_date" placeholder="ชื่อ" value="{{@$about_holiday->about_holiday_date}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_holiday_date">ที่อยู่</label>
                                        <textarea name="about_holiday_date" class="form-control" id="about_holiday_date" placeholder="ที่อยู่" rows="5" value="{{@$about_holiday->about_holiday_date}}" required></textarea>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>        
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <h4 class="card-title">การกระทำการแทน</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_holiday_date">เลขประจำตัวผู้เสียภาษีอากร</label>
                                        <input type="text" name="about_holiday_date" class="form-control" id="about_holiday_date" placeholder="เลขประจำตัวผู้เสียภาษีอากร" value="{{@$about_holiday->about_holiday_date}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="about_holiday_date">โดยตัวแทน</label>
                                        <input type="text" name="about_holiday_date" class="form-control" id="about_holiday_date" placeholder="โดยตัวแทน" value="{{@$about_holiday->about_holiday_date}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_holiday_date">ที่อยู่</label>
                                        <textarea name="about_holiday_date" class="form-control" id="about_holiday_date" placeholder="ที่อยู่" rows="5" value="{{@$about_holiday->about_holiday_date}}" required></textarea>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>                               
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <h4 class="card-title">ผู้ถูกหักภาษี ณ ที่จ่าย</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_holiday_date">เลขประจำตัวผู้เสียภาษีอากร</label>
                                        <input type="text" name="about_holiday_date" class="form-control" id="about_holiday_date" placeholder="เลขประจำตัวผู้เสียภาษีอากร" value="{{@$about_holiday->about_holiday_date}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="about_holiday_date">ชื่อ</label>
                                        <input type="text" name="about_holiday_date" class="form-control" id="about_holiday_date" placeholder="ชื่อ" value="{{@$about_holiday->about_holiday_date}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_holiday_date">ที่อยู่</label>
                                        <textarea name="about_holiday_date" class="form-control" id="about_holiday_date" placeholder="ที่อยู่" rows="5" value="{{@$about_holiday->about_holiday_date}}" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_holiday_date">AWB No.</label>
                                        <input type="text" name="about_holiday_date" class="form-control" id="about_holiday_date" placeholder="AWB No." value="{{@$about_holiday->about_holiday_date}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_holiday_date">ลำดับที่</label>
                                        <input type="text" name="about_holiday_date" class="form-control" id="about_holiday_date" placeholder="ลำดับที่" value="{{@$about_holiday->about_holiday_date}}" required>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>                        
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <h4 class="card-title">ประเภทเงินได้ที่จ่าย</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_holiday_date">วัน เดือน หรือ ปีภาษีที่จ่าย</label>
                                        <input type="text" name="about_holiday_date" class="form-control" id="about_holiday_date" placeholder="วัน เดือน หรือ ปีภาษีที่จ่าย" value="{{@$about_holiday->about_holiday_date}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pay_price">จำนวนเงินที่จ่าย</label>
                                        <input type="number" name="pay_price" class="form-control" id="pay_price" oninput="payPrice(this.value)" pattern="(d{3})([.])(d{2})" placeholder="จำนวนเงินที่จ่าย" value="{{@$about_holiday->pay_price}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pay_tax">ภาษีที่หักและนำส่งไว้</label><span style="color: coral"> (หักจากจำนวนที่จ่าย 3 %)</span>
                                        <input type="number" name="pay_tax" class="form-control" id="pay_tax" placeholder="ภาษีที่หักและนำส่งไว้" value="{{@$about_holiday->pay_tax}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pay_tax_text">รวมเงินภาษีที่หักนำส่ง</label><span style="color: coral"> (ตัวอักษร)</span>
                                        <input type="text" name="pay_tax_text" class="form-control" id="pay_tax_text" placeholder="รวมเงินภาษีที่หักนำส่ง" value="{{@$about_holiday->pay_tax_text}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_holiday_date">ลำดับที่</label>
                                        <input type="text" name="about_holiday_date" class="form-control" id="about_holiday_date" placeholder="ลำดับที่" value="{{@$about_holiday->about_holiday_date}}" required>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>                            
                <div class="col-sm-12">
                    <div class="form-group">
                        <button class="btn btn-primary">Save</button>
                    </div>
                </div>
        </form>

            </div>
        </div><br>
        </div>
    </div>
    <!-- end row -->
</div>

                        <!-- end row -->
                <!-- end modal -->
@endsection
@section('script')
<script>
    function payPrice(value){
        var d = (value*0.3).toFixed(2);
        var thaibath = ArabicNumberToText(d);
        $('#pay_tax').val(d);
        $('#pay_tax_text').val(thaibath);
        // $('#pay_price').val(value.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
    }
    function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    $('.imagePreview').show();
                    reader.onload = function(e) {
                    $('.imagePreview').attr('src', e.target.result);
                    }
                    
                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
            }
            function imgChange(t) {
                readURL(t);
            }
</script>
        <!-- plugin js -->
        <script src="{{ URL::asset('assets/js/thaibath.js')}}" type="text/javascript" charset="utf-8"></script>

        <script src="{{ URL::asset('assets/js/pages/form-repeater.int.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/jquery.repeater/jquery.repeater.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-validation.init.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-element.init.js')}}"></script>
@endsection