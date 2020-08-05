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
            <form id="shippingForm" action="{{$action}}" method="post" class="needs-validation outer-repeater" novalidate="" enctype="multipart/form-data">
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
                                        <label for="deduct_tax_identification">เลขประจำตัวผู้เสียภาษีอากร</label> <span class="required">*</span>
                                        <input type="text" name="deduct_tax_identification" class="form-control" id="deduct_tax_identification" placeholder="เลขประจำตัวผู้เสียภาษีอากร" value="{{@$shipping->deduct_tax_identification}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="deduct_name">ชื่อ</label> <span class="required">*</span>
                                        <input type="text" name="deduct_name" class="form-control" id="deduct_name" placeholder="ชื่อ" value="{{@$shipping->deduct_name}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="deduct_address">ที่อยู่</label> <span class="required">*</span>
                                        <textarea name="deduct_address" class="form-control" id="deduct_address" placeholder="ที่อยู่" rows="5" required>{{@$shipping->deduct_address}}</textarea>
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
                                        <label for="represent_tax_identification">เลขประจำตัวผู้เสียภาษีอากร</label> <span class="required">*</span>
                                        <input type="text" name="represent_tax_identification" class="form-control" id="represent_tax_identification" placeholder="เลขประจำตัวผู้เสียภาษีอากร" value="{{@$shipping->represent_tax_identification}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="represent_name">โดยตัวแทน</label> <span class="required">*</span>
                                        <input type="text" name="represent_name" class="form-control" id="represent_name" placeholder="โดยตัวแทน" value="{{@$shipping->represent_name}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="represent_address">ที่อยู่</label> <span class="required">*</span>
                                        <textarea name="represent_address" class="form-control" id="represent_address" placeholder="ที่อยู่" rows="5"  required>{{@$shipping->represent_address}}</textarea>
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
                                        <label for="pay_tax_identification">เลขประจำตัวผู้เสียภาษีอากร</label> <span class="required">*</span>
                                        <input type="text" name="pay_tax_identification" class="form-control" id="pay_tax_identification" placeholder="เลขประจำตัวผู้เสียภาษีอากร" value="{{@$shipping->pay_tax_identification}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="pay_name">ชื่อ</label> <span class="required">*</span>
                                        <input type="text" name="pay_name" class="form-control" id="pay_name" placeholder="ชื่อ" value="{{@$shipping->pay_name}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pay_address">ที่อยู่</label> <span class="required">*</span>
                                        <textarea name="pay_address" class="form-control" id="pay_address" placeholder="ที่อยู่" rows="5" required >{{@$shipping->pay_address}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="awb_no">AWB No.</label> <span class="required">*</span>
                                        <input type="text" name="awb_no" class="form-control" id="awb_no" placeholder="AWB No." value="{{@$shipping->awb_no}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="number">ลำดับที่</label> <span class="required">*</span>
                                        <input type="text" name="number" class="form-control" id="number" placeholder="ลำดับที่" value="{{@$shipping->number}}" required>
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
                                        <label for="date_current">วัน เดือน หรือ ปีภาษีที่จ่าย</label> <span class="required">*</span>
                                        <input type="text" name="date_current" class="form-control" id="date_current" placeholder="วัน เดือน หรือ ปีภาษีที่จ่าย" value="{{@$shipping->date_current}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pay_price">จำนวนเงินที่จ่าย</label> <span class="required">*</span>
                                        <input type="number" name="pay_price" class="form-control" id="pay_price" oninput="payPrice(this.value)" pattern="(d{3})([.])(d{2})" placeholder="จำนวนเงินที่จ่าย" value="{{@$shipping->pay_price}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pay_tax">ภาษีที่หักและนำส่งไว้</label> <span class="required">*</span><span style="color: coral"> (หักจากจำนวนที่จ่าย 3 %)</span>
                                        <input type="number" name="pay_tax" class="form-control" id="pay_tax" placeholder="ภาษีที่หักและนำส่งไว้" value="{{@$shipping->pay_tax}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pay_tax_text">รวมเงินภาษีที่หักนำส่ง</label> <span class="required">*</span><span style="color: coral"> (ตัวอักษร)</span>
                                        <input type="text" name="pay_tax_text" class="form-control" id="pay_tax_text" placeholder="รวมเงินภาษีที่หักนำส่ง" value="{{@$shipping->pay_tax_text}}" required>
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
    document.getElementById("shippingForm").addEventListener("submit", function(event){
        
        $.ajax({
            type: "POST",
            url: "{{url('customer')}}",
            data:{
                code:v,
                '_token': "{{ csrf_token() }}",
            },
            success: function( result ) {
                if(result){
                    $("#customer").html("<b>ชื่อลูกค้า</b> &nbsp; "+result.customer_name+' '+result.customer_surname+'<input type="hidden" name="customer_name" id="inCus" value="'+result.customer_name+' '+result.customer_surname+'">');
                }else{
                    $("#customer").html("")
                }
            }
    });
        // var cusName = $('#inCus').val();
        // var qty = $('.qty').val();
        // var submit = true;
        // if(cusName == undefined){
        //     $("#customer").html("<p style='color:red;'>กรุณากรอกหมายเลขสมาชิกให้ถูกต้อง</p>");
        //     event.preventDefault()
        //     submit = false;
        // }
        // if(qty == undefined){
        //     $("#validatProduct").html("<p style='color:red;'>กรุณาระบุสินค้าให้ถูกต้อง</p>");
        //         event.preventDefault()
        //         return false
        //         submit = false;
        // }
        // $('.qty').each(function() {
        //     var v = $(this).val();
        //     if(v == ''||v == undefined){
        //         $("#validatProduct").html("<p style='color:red;'>กรุณาระบุสินค้าให้ถูกต้อง</p>");
        //         event.preventDefault()
        //         submit = false;
        //     }
        // });
        // if(!submit) return false;
        // var order = $('#order').val();

        // if(order == ''){
        //     setTimeout(function(){ 
        //         document.getElementById('productForm').reset();
        //         $('.qty').each(function() {
        //             var v = $(this).val();
        //             var id = $(this).attr('idi');
        //                 $('#product'+id).html('');
        //         });

        //         $("#customer").html("");
        //         $('#price').html("0 บาท");
        //         $('#d').html('');
        //     }, 1000);
        // }
    });

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