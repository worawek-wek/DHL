@extends('layouts.master')

@section('title') Dashboard @endsection

@section('css') 

        <link href="{{ URL::asset('assets/libs/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}" rel="stylesheet">
        <link href="{{ URL::asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
        <link href="{{ URL::asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet" />
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
            <form id="shippingForm" action="{{$action}}" target="_blank" method="post" class="needs-validation outer-repeater" novalidate="" enctype="multipart/form-data">
                <div class="col-sm-12">
                    <div class="form-group">
                        <button class="btn btn-primary">Save</button> &nbsp; &nbsp;
                    <a type="button" href="{{url($page_url)}}" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" id="shippingId">
                            <h4 class="card-title">ผู้มีหน้าที่หักภาษี ณ ที่จ่าย</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select name="customer_id" onchange="customerChange(this.value)" class="form-control select2" required>
                                            <option value="">ค้นหาลูกค้า</option>
                                            @foreach ($customer as $cus)
                                                <option value="{{$cus->id}}" @if ($cus->id==@$shipping['ref_customer_id'])
                                                    selected
                                                @endif>{{$cus->companyName}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="deduct_tax_identification">เลขประจำตัวผู้เสียภาษีอากร</label> <span class="required">*</span>
                                        <input type="text" name="deduct_tax_identification" class="form-control" id="deduct_tax_identification" placeholder="เลขประจำตัวผู้เสียภาษีอากร" value="{{@$shipping['deduct_tax_identification']}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="deduct_name">ชื่อ</label> <span class="required">*</span>
                                        <input type="text" name="deduct_name" class="form-control" id="deduct_name" placeholder="ชื่อ" value="{{@$shipping['deduct_name']}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="deduct_address">ที่อยู่</label> <span class="required">*</span>
                                        <textarea name="deduct_address" class="form-control" id="deduct_address" placeholder="ที่อยู่" rows="5" required>{{@$shipping['deduct_address']}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="awb_no">AWB No.</label> <span class="required">*</span>
                                        <input type="text" name="awb_no" class="form-control" id="awb_no" placeholder="AWB No." value="{{@$shipping['awb_no']}}" required>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>               
                <div class="card">
                    <div class="card-body">
                            <h4 class="card-title">ประเภทเงินได้ที่จ่าย</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date_current">วัน เดือน หรือ ปีภาษีที่จ่าย</label> <span class="required">*</span>
                                        <input type="text" name="date_current" class="form-control" id="date_current" placeholder="วัน เดือน หรือ ปีภาษีที่จ่าย" data-provide="datepicker" value="{{@$shipping['date_current']}}" required>
                                        {{-- <input type="text" name="date_current" class="form-control" id="date_current" placeholder="mm/dd/yyyy" data-provide="datepicker" value="{{@$shipping['date_current']}}" required> --}}
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pay_price">จำนวนเงินที่จ่าย</label> <span class="required">*</span>
                                        <input type="number" name="pay_price" class="form-control" id="pay_price" oninput="payPrice(this.value)" pattern="(d{3})([.])(d{2})" placeholder="จำนวนเงินที่จ่าย" value="{{@$shipping['pay_price']}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pay_tax">ภาษีที่หักและนำส่งไว้</label> <span class="required">*</span><span style="color: coral"> (หักจากจำนวนที่จ่าย 3 %)</span>
                                        <input type="number" name="pay_tax" oninput="payTax(this.value)" class="form-control" id="pay_tax" placeholder="ภาษีที่หักและนำส่งไว้" value="{{@$shipping['pay_tax']}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pay_tax_text">รวมเงินภาษีที่หักนำส่ง</label> <span class="required">*</span><span style="color: coral"> (ตัวอักษร)</span>
                                        <input type="text" name="pay_tax_text" class="form-control" id="pay_tax_text" placeholder="รวมเงินภาษีที่หักนำส่ง" value="{{@$shipping['pay_tax_text']}}" required>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>                 
                
                <div class="card">
                    <div class="card-body">
                            <h4 class="card-title" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">การกระทำการแทน&nbsp; <i class="bx bx-chevron-down"></i></h4>
                            <div class="row collapse" id="collapseExample">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="represent_tax_identification">เลขประจำตัวผู้เสียภาษีอากร</label> <span class="required">*</span>
                                        <input type="text" name="represent_tax_identification" class="form-control" id="represent_tax_identification" placeholder="เลขประจำตัวผู้เสียภาษีอากร" value="{{@$shipping['represent_tax_identification']}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="represent_name">โดยตัวแทน</label> <span class="required">*</span>
                                        <input type="text" name="represent_name" class="form-control" id="represent_name" placeholder="โดยตัวแทน" value="{{@$shipping['represent_name']}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="represent_address">ที่อยู่</label> <span class="required">*</span>
                                        <textarea name="represent_address" class="form-control" id="represent_address" placeholder="ที่อยู่" rows="5"  required>{{@$shipping['represent_address']}}</textarea>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>                           
                <div class="card">
                    <div class="card-body">
                            <h4 class="card-title" type="button" data-toggle="collapse" data-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample2">ผู้ถูกหักภาษี ณ ที่จ่าย&nbsp; <i class="bx bx-chevron-down"></i></h4>
                            <div class="row collapse" id="collapseExample2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pay_tax_identification">เลขประจำตัวผู้เสียภาษีอากร</label> <span class="required">*</span>
                                        <input type="text" name="pay_tax_identification" class="form-control" id="pay_tax_identification" placeholder="เลขประจำตัวผู้เสียภาษีอากร" value="{{@$shipping['pay_tax_identification']}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="pay_name">ชื่อ</label> <span class="required">*</span>
                                        <input type="text" name="pay_name" class="form-control" id="pay_name" placeholder="ชื่อ" value="{{@$shipping['pay_name']}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pay_address">ที่อยู่</label> <span class="required">*</span>
                                        <textarea name="pay_address" class="form-control" id="pay_address" placeholder="ที่อยู่" rows="5" required >{{@$shipping['pay_address']}}</textarea>
                                    </div>
                                </div>
                                    <div class="col-md-9">
                                    <label>ลำดับที่</label> <span class="required">*</span>
                                    <div style="margin: 0 15px;" class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                                <input type="radio" name="number" class="form-check-input" id="number1" value="1" required>
                                                <label class="form-check-label" for="number1">(1) ภ.ง.ด. 1ก.</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                                <input type="radio" name="number" class="form-check-input" id="number2" value="2" required>
                                                <label class="form-check-label" for="number2">(2) ภ.ง.ด. 1ก. พิเศษ</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                                <input type="radio" name="number" class="form-check-input" id="number3" value="3" required>
                                                <label class="form-check-label" for="number3">(3) ภ.ง.ด. 2</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                                <input type="radio" name="number" class="form-check-input" id="number4" value="4" required>
                                                <label class="form-check-label" for="number4">(4) ภ.ง.ด. 3</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                                <input type="radio" name="number" class="form-check-input" id="number5" value="5" required>
                                                <label class="form-check-label" for="number5">(5) ภ.ง.ด. 2ก.</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                                <input type="radio" name="number" class="form-check-input" id="number6" value="6" required>
                                                <label class="form-check-label" for="number6">(6) ภ.ง.ด. 3ก.</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                                <input type="radio" name="number" class="form-check-input" id="number7" value="7" checked required>
                                                <label class="form-check-label" for="number7">(7) ภ.ง.ด. 53</label>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>                                
                <div class="col-sm-12">
                    <div class="form-group">
                        <button class="btn btn-primary">Save</button>
                        <a type="button" href="{{url($page_url)}}" class="btn btn-danger">Cancel</a>
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
    document.getElementById("shippingForm").addEventListener("submit", function(event){
            event.preventDefault()
        var form = $(this);
        $.ajax({
            type: "POST",
            url: form.attr('action')+'/ajax',
            data:form.serialize(),
            success: function( result ) {
                $('#shippingId').val(result);
                document.getElementById("shippingForm").submit();
                window.location.href = "{{url('shipping')}}";
            },
            error: function (error) {
                alert('โปรดตรวจสอบความถูกต้อง');
            }

        });
    });

    function customerChange(id){
        console.log(id);
        $.ajax({
            type: "GET",
            url: '{{url("shipping/customer")}}/'+id,
            success: function( result ) {
                $('#deduct_tax_identification').val(result.companyTaxNo);
                $('#deduct_name').val(result.companyName);
                $('#deduct_address').val(result.streetAndNumber+' '+result.district+' '+result.subProvince+' '+result.province+' '+result.postCode);
            },
            error: function (error) {
                alert(error);
            }
        });
    }
    function payPrice(value){
        var d = (value*0.03).toFixed(2);
        var thaibath = ArabicNumberToText(d);
        $('#pay_tax').val(d);
        $('#pay_tax_text').val(thaibath);
        // $('#pay_price').val(value.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
    }
    function payTax(value){
        var d = value;
        var thaibath = ArabicNumberToText(d);
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
        <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/thaibath.js')}}" type="text/javascript" charset="utf-8"></script>
        <script src="{{ URL::asset('assets/libs/select2/js/select2.min.js')}}"></script>

        <script src="{{ URL::asset('assets/js/pages/form-repeater.int.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/jquery.repeater/jquery.repeater.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-validation.init.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-element.init.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js')}}"></script>
@endsection