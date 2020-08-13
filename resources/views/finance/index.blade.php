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
                        <div class="col-sm-9">
                            <form method="GET" action="{{@$page_url}}">
                                <div class="col-sm-3 search-box mb-2 d-inline-block">
                                    <div class="position-relative">
                                        <input type="search" class="form-control" name="deduct_tax_identification" placeholder="เลขประจำตัวผู้เสียภาษีอากร..." value="{{@$query['deduct_tax_identification']}}">
                                    </div>
                                </div>
                                <div class="col-sm-3 mb-2 d-inline-block">
                                        <button style="background-color: #556ee6; color:white" class="btn btn-rounded waves-effect waves-light" type="submit"><i class='bx bx-search-alt'></i>&nbsp; ค้นหา</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-3">
                            <div class="text-sm-right">
                                <a href="{{$page_url}}/create" class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2"><i class="mdi mdi-plus mr-1"></i> เพิ่ม {{$page}}</a>
                            </div>
                        </div><!-- end col-->
                        <div class="col-sm-12 btnDeleteAll" style="display: none">
                            <div class="text-sm-right">
                            <button onclick="excel()" type="button" class="btn btn-info waves-effect waves-light"><i class="mdi mdi-microsoft-excel"></i> Excel</button>
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
                                    <th>สร้าง</th>
                                    <th>แก้ไข</th>
                                    <th>ดำเนินการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_data as $value)
                                
                                <tr align="center">
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input checkId" onchange="checkList()" id="customCheck{{$num}}" value="{{$value->id}}">
                                            <label class="custom-control-label" for="customCheck{{$num}}">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>{{$num++}}</td>
                                    <td>{{$value->deduct_tax_identification}}</td>
                                    <td>{{$value->deduct_name}}</td>
                                    <td>@empty(!$value->address_street){{iconv_substr($value->address_number.' '.$value->address_moo.' '.$value->address_alley.' '.$value->address_street.' '.$value->address_subdistrict.' '.$value->address_district.' '.$value->address_province.' '.$value->address_zipcode.' '.$value->phone, 0, 35, "UTF-8")}}...  @endempty</td>
                                    <td>
                                        {{$value->created_at}}
                                    </td>
                                    <td>
                                        {{$value->updated_at}}
                                    </td>
                                    <td>
                                        <a href="{{$page_url}}/{{$value->id}}/edit" class="mr-3 text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>
                                        <a href="{{$page_url}}/indexPDF/{{$value->id}}" target="_blank" class="mr-3 text-defult" data-toggle="tooltip" data-placement="top" title="" data-original-title="PDF"><i class="bx bxs-file-pdf font-size-18"></i></a>
                                        {{-- <a href="javascript: void(0);" onclick="deleteFromTable({{$value->id}})" class="text-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="mdi mdi-delete font-size-18"></i></a> --}}
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
        window.location.href = "{{url('shipping/excel')}}/"+id;
    }
</script>
        <!-- Magnific Popup-->
        <script src="{{ URL::asset('assets/libs/magnific-popup/jquery.magnific-popup.min.js')}}"></script>

        <!-- lightbox init js-->
        <script src="{{ URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
@endsection