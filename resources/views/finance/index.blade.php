@extends('layouts.master')

@section('title') About Customer @endsection

@section('content')
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<style>
    .search-box .form-control{
        padding-left:15px;
    }
    .search-box .search-icon {
        right: 13px;
        left: unset;
    }
</style>

@section('css') 

<!-- Lightbox css -->
<link href="{{ URL::asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/magnific-popup/magnific-popup.css')}}">

@endsection

<div class="container-fluid">
<input type="hidden" id='token' value="{{ csrf_token() }}">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{{$page}}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <?php //if(isset($page_before)){echo "<li class='breadcrumb-item active'>$page_before</li>";}?>
                        <li class="breadcrumb-item active">{{$page}}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        {{-- @if (!Auth::user()->isBilling())
                        <div class="col-sm-2">
                            <div class="text-sm-left">
                                <a href="{{$page_url}}/create" class="btn btn-success waves-effect waves-light mb-2 mr-2"><i class="mdi mdi-plus mr-1"></i> เพิ่มรายการ</a>
                            </div>
                        </div>
                        @endif --}}
                        <div class="col-sm-12">
                            <form method="GET" action="{{@$page_url}}">
                                    <div class="col-sm-3 mb-2 d-inline-block">
                                        <div class="position-relative">
                                            <input type="search" class="form-control" name="deduct_tax_identification" placeholder="Consignee Tax ID..." value="{{@$query['deduct_tax_identification']}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 mb-2 d-inline-block">
                                        <div class="position-relative">
                                            <input type="search" class="form-control" name="deduct_name" placeholder="Consignee..." value="{{@$query['deduct_name']}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 mb-2 d-inline-block">
                                        <div class="position-relative">
                                        <input type="text" name="month_year" id="month_year" class="form-control" autocomplete="off" data-provide="datepicker" placeholder="เดือน" data-date-format="mm yyyy" data-date-min-view-mode="1" value="{{@$query['month_year']}}">
                                        {{-- <input type="date" class="form-control" name="created_at" placeholder="Create Date..." value="{{@$query['created_at']}}"> --}}
                                        </div>
                                    </div>
                                    <div class="col-sm-2 mb-2 d-inline-block">
                                        <div class="position-relative">
                                            <button style="background-color: #556ee6; color:white;top:-1px" class="btn waves-effect waves-light" type="submit"><i class='bx bx-search-alt'></i>&nbsp; ค้นหา</button>
                                        </div>
                                    </div>
                            </form>
                        </div><!-- end col-->
                        <div class="col-sm-12 btnDeleteAll" style="display: none">
                            <div class="text-sm-right">
                            <button onclick="pdf()" type="button" class="btn btn-dark waves-effect waves-light"><i class="far fa-file-pdf"></i> PDF 53 PND</button>
                            {{-- <button onclick="excel()" type="button" class="btn btn-info waves-effect waves-light"><i class="mdi mdi-microsoft-excel"></i> Excel</button> --}}
                            </div>
                        </div><!-- end col-->
                    </div>

                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap">
                            <thead class="thead-light">
                                <tr align="center">
                                    <th style="width: 20px;">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" onchange="checkAll(this)" class="custom-control-input" id="customCheckAll">
                                            <label class="custom-control-label" for="customCheckAll">&nbsp;</label>
                                        </div>
                                    </th>
                                    <th>#</th>
                                    <th width='15%'>เลขประจำตัวผู้เสียภาษีอากร</th>
                                    <th width='25%'>ชื่อ</th>
                                    <th width='25%'>ที่อยู่</th>
                                    <th>ล่าสุด</th>
                                    <th>ดำเนินการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_data as $value)
                                
                                <tr align="center">
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input checkId" onchange="checkList()" id="customCheck{{$num}}" value="{{$value->ref_customer_id}}">
                                            <label class="custom-control-label" for="customCheck{{$num}}">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>{{$num++}}</td>
                                    <td>{{$value->deduct_tax_identification}}</td>
                                    <td>{{$value->deduct_name}}</td>
                                    <td>@empty(!$value->address_street){{iconv_substr($value->address_number.' '.$value->address_moo.' '.$value->address_alley.' '.$value->address_street.' '.$value->address_subdistrict.' '.$value->address_district.' '.$value->address_province.' '.$value->address_zipcode.' '.$value->phone, 0, 45, "UTF-8")}}...  @endempty</td>
                                    <td>
                                        {{$value->updated_at}}
                                    </td>
                                    <td>
                                    @if (!Auth::user()->isBilling())
                                        <a href="{{$page_url}}/{{$value->ref_customer_id}}/customer" class="mr-3 text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-eye font-size-18"></i></a>
                                    @endif
                                    @if (@$month)
                                        <a href="{{$page_url}}/pdf/{{$value->ref_customer_id}}/{{$month}}/{{$year}}" target="_blank" class="mr-3 text-defult" data-toggle="tooltip" data-placement="top" title="" data-original-title="PDF"><i class="bx bxs-file-pdf font-size-18"></i></a>
                                        {{-- <a href="javascript: void(0);" onclick="deleteFromTable({{$value->ref_customer_id}})" class="text-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="mdi mdi-delete font-size-18"></i></a> --}}
                                    @endif
                                </td>
                                </tr>
                                @endforeach
                                @include('layouts/data-notfound')
                            </tbody>
                        </table>
                    </div>
                    <ul class="pagination pagination-rounded justify-content-end mb-2">
                    {{  $list_data->links() }}
                    </ul>
                </div>
            </div>
        </div>
    </div>
{{-- @include('layouts/modal') --}}
<!-- end row -->
                <!-- end modal -->
@endsection

@section('script')
<script>
    function excel(){
        var id = [];
                $('.checkId').each(function() {
                    if($(this).is(':checked')){
                        var v = $(this).val();
                        id.push(v);
                    }
                });
        window.location.href = "{{url($page_url.'/excel')}}/"+id;
    }
    function pdf(){
        var id = [];
        var searchMonth = '{{@$query['month_year']}}';
                $('.checkId').each(function() {
                    if($(this).is(':checked')){
                        var v = $(this).val();
                        id.push(v);
                    }
                });
        if(searchMonth==''){
            if(confirm('กรุณาค้นหาด้วยเดือน')==true){
                return $('#month_year').focus();
            }
        }
        var ex = searchMonth.split(" ")
        // window.location.href = "{{url('shipping/excel')}}/"+id;
        window.open("{{url($page_url.'/pdf')}}/"+id+"/"+ex[0]+"/"+ex[1], '_blank')
        // window.open("{{url($page_url.'/pdf')}}/"+id, '_blank')
    }
</script>
        <!-- Magnific Popup-->
        <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/magnific-popup/jquery.magnific-popup.min.js')}}"></script>

        <!-- lightbox init js-->
        <script src="{{ URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
@endsection