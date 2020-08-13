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
            <form id="financeForm" action="{{$action}}" target="_blank" method="post" class="needs-validation outer-repeater" novalidate="" enctype="multipart/form-data">
                <div class="col-sm-12">
                    <div class="form-group">
                        <button class="btn btn-primary">Save</button>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" id="financeId">
                            <h4 class="card-title">ผู้มีหน้าที่หักภาษี ณ ที่จ่าย</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select name="customer_id" onchange="customerChange(this.value)" class="form-control select2" required>
                                            <option value="">ค้นหาลูกค้า</option>
                                            @foreach ($customer as $cus)
                                                <option value="{{$cus->id}}" @if ($cus->id==@$finance['ref_customer_id'])
                                                    selected
                                                @endif>{{$cus->companyName}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="deduct_tax_identification">เลขประจำตัวผู้เสียภาษีอากร</label> <span class="required">*</span>
                                        <input type="text" name="deduct_tax_identification" class="form-control" id="deduct_tax_identification" placeholder="เลขประจำตัวผู้เสียภาษีอากร" value="{{@$finance['deduct_tax_identification']}}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="deduct_name">ชื่อผู้มีหน้าที่หักภาษี ณ ที่จ่าย</label> <span class="required">*</span>
                                        <input type="text" name="deduct_name" class="form-control" id="deduct_name" placeholder="ชื่อ" value="{{@$finance['deduct_name']}}" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h5>ที่อยู่</h5>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="address_number">เลขที่</label> <span class="required">*</span>
                                        <input name="address_number" class="form-control" id="address_number" placeholder="เลขที่" rows="5" required value="{{@$finance['address_number']}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="address_moo">หมู่ที่</label> <span class="required">*</span>
                                        <input name="address_moo" class="form-control" id="address_moo" placeholder="หมู่ที่" rows="5" required value="{{@$finance['address_moo']}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="address_alley">ตรอก/ซอย</label> <span class="required">*</span>
                                        <input name="address_alley" class="form-control" id="address_alley" placeholder="ตรอก/ซอย" rows="5" required value="{{@$finance['address_alley']}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="address_street">ถนน</label> <span class="required">*</span>
                                        <input name="address_street" class="form-control" id="address_street" placeholder="ถนน" rows="5" required value="{{@$finance['address_street']}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="address_subdistrict">ตำบล/แขวง</label> <span class="required">*</span>
                                        <input name="address_subdistrict" class="form-control" id="address_subdistrict" placeholder="ตำบล/แขวง" rows="5" required value="{{@$finance['address_subdistrict']}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="address_district">อำเภอ/เขต</label> <span class="required">*</span>
                                        <input name="address_district" class="form-control" id="address_district" placeholder="อำเภอ/เขต" rows="5" required value="{{@$finance['address_district']}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="address_province">จังหวัด</label> <span class="required">*</span>
                                        <input name="address_province" class="form-control" id="address_province" placeholder="จังหวัด" rows="5" required value="{{@$finance['address_province']}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="address_zipcode">รหัสไปรษณีย์</label> <span class="required">*</span>
                                        <input name="address_zipcode" class="form-control" id="address_zipcode" placeholder="รหัสไปรษณีย์" rows="5" required value="{{@$finance['address_zipcode']}}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="phone">โทรศัพท์</label> <span class="required">*</span>
                                        <input name="phone" class="form-control" id="phone" placeholder="โทรศัพท์" rows="5" required value="{{@$finance['phone']}}">
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>        
                <div class="card">
                    <div class="card-body">
                            <h4 class="card-title">เดือนที่จ่ายเงินได้พึงประเมิน</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="month_pay">เดือน</label> <span class="required">*</span>
                                        <input type="text" name="month_pay" class="form-control" data-provide="datepicker" placeholder="เดือน" data-date-format="mm yyyy" data-date-min-view-mode="1" value="{{@$finance['month_pay']}}" required>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>   
                <div class="card">
                    <div class="card-body">
                            <h4 class="card-title">รายละเอียดการหักเป็นรายผู้มีเงินได้</h4>
                            <div class="row" style="margin: 0 15px;">
                                <div class="col-md-12">
                                    <div class="form-group">
                                            <input type="radio" name="attachment" class="form-check-input" id="attachment1" @if(@$finance['attachment'] == 1) checked @endif value="1" required>
                                            <label class="form-check-label" for="attachment1">ใบแนบ ภ.ง.ด.53 ที่แนบมาพร้อมนี้</label><br>
                                            <input type="radio" name="attachment" class="form-check-input" id="attachment2" @if(@$finance['attachment'] == 2) checked @endif value="2" required>
                                            <label class="form-check-label" for="attachment2">สื่อบันทึกในระบบคอมพิวเตอร์ ที่แนบมาพร้อมนี้</label>
                                    </div>
                                </div>
                            </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="qty_case">ราย</label> <span class="required">*</span>
                                        <input type="text" name="qty_case" class="form-control" placeholder="ราย" value="{{@$finance['qty_case']}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="qty_sheet">แผ่น</label> <span class="required">*</span>
                                        <input type="text" name="qty_sheet" class="form-control" placeholder="แผ่น" value="{{@$finance['qty_sheet']}}" required>
                                    </div>
                                </div>
                    </div>
                </div>                               
                <div class="card">
                    <div class="card-body">
                            <h4 class="card-title">สรุปรายการภาษีที่นำส่ง</h4>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="total_amount">รวมยอดเงินได้ทั้งสิ้น</label> <span class="required">*</span>
                                        <input type="text" name="total_amount" class="form-control" id="total_amount" placeholder="รวมยอดเงินได้ทั้งสิ้น" value="{{@$finance['total_amount']}}" required>
                                    </div>
                                </div>
                                    <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="total_tax">รวมยอดภาษีที่นำส่งได้ทั้งสิ้น</label> <span class="required">*</span>
                                        <input type="text" name="total_tax" class="form-control" id="total_tax" placeholder="รวมยอดภาษีที่นำส่งได้ทั้งสิ้น" value="{{@$finance['total_tax']}}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="extra_money">เงินเพิ่ม(ถ้ามี)</label>
                                        <input type="text" name="extra_money" class="form-control" id="extra_money" placeholder="เงินเพิ่ม(ถ้ามี)" value="{{@$finance['extra_money']}}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="total_tax_delivered">รวมยอดภาษีที่นำส่งได้ทั้งสิ้น และเงินเพิ่ม (2. + 3.)</label> <span class="required">*</span>
                                        <input type="text" name="total_tax_delivered" class="form-control" id="total_tax_delivered" placeholder="รวมยอดภาษีที่นำส่งได้ทั้งสิ้น และเงินเพิ่ม (2. + 3.)" value="{{@$finance['total_tax_delivered']}}" required>
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
    document.getElementById("financeForm").addEventListener("submit", function(event){
            event.preventDefault()
        var form = $(this);
        $.ajax({
            type: "POST",
            url: form.attr('action')+'/ajax',
            data:form.serialize(),
            success: function( result ) {
                $('#financeId').val(result);
                document.getElementById("financeForm").submit();
                window.location.href = "{{url($page_url)}}";
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
            url: '{{url("$page_url/customer")}}/'+id,
            success: function( result ) {
                $('#deduct_tax_identification').val(result.companyTaxNo);
                $('#deduct_name').val(result.companyName);
                $('#address_street').val(result.streetAndNumber);
                $('#address_subdistrict').val(result.district);
                $('#address_district').val(result.subProvince);
                $('#address_province').val(result.province);
                $('#address_zipcode').val(result.postCode);
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