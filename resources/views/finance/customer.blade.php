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
                        <?php if(isset($page_before)){echo "<li class='breadcrumb-item active'>$page_before</li>";}?>
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
                        <div class="col-sm-8">
                            <form method="GET" action="/{{@$page_url}}/{{$customer_id}}/customer">
                                    {{-- <div class="col-sm-1 mb-2 d-inline-block">
                                        แก้ไข
                                    </div> --}}
                                    <div class="col-sm-4 mb-2 d-inline-block">
                                        <input type="text" name="month_year" id="month_year" class="form-control" autocomplete="off" data-provide="datepicker" placeholder="เดือน" data-date-format="mm yyyy" data-date-min-view-mode="1" value="{{@$query['month_year']}}" required>
                                    </div>
                                        <button style="background-color: #556ee6; color:white;top:-1px" class="btn waves-effect waves-light" type="submit"><i class='bx bx-search-alt'></i>&nbsp; ค้นหา</button>
                            </form>
                        </div><!-- end col-->
                        <div class="col-sm-4" align="right">
                            <button onclick="pdf()" type="button" class="btn btn-dark waves-effect waves-light"><i class="far fa-file-pdf"></i> PDF 53 PND</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap">
                            <thead class="thead-light">
                                <tr align="center">
                                    <th>#</th>
                                    <th width='15%'>AWB No.</th>
                                    <th width='25%'>จำนวนเงินที่จ่าย</th>
                                    <th width='25%'>ภาษีที่หักและนำส่งไว้</th>
                                    <th width='25%'>รวมเงินภาษีที่หักนำส่ง</th>
                                    {{-- <th width='25%'>รวมยอดภาษีที่นำส่งทั้งสิ้น และเงินเพิ่ม (2. + 3.)</th> --}}
                                    <th>สร้าง</th>
                                    <th>แก้ไข</th>
                                    <th>ดำเนินการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_data as $value)
                                
                                <tr align="center">
                                    <td>{{$num++}}</td>
                                    <td>{{$value->awb_no}}</td>
                                    <td>{{$value->pay_price}}</td>
                                    <td>{{$value->pay_tax}}</td>
                                    <td>{{$value->pay_tax_text}}</td>
                                    {{-- <td>{{$value->total_tax}}</td> --}}
                                    <td>
                                        {{$value->created_at}}
                                    </td>
                                    <td>
                                        {{$value->updated_at}}
                                    </td>
                                    <td>
                                    @if (!Auth::user()->isBilling())
                                        <a href="/{{$page_url}}/{{$value->id}}/edit" class="mr-3 text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>
                                    @endif
                                        {{-- <a href="{{$page_url}}/indexPDF/{{$value->id}}" target="_blank" class="mr-3 text-defult" data-toggle="tooltip" data-placement="top" title="" data-original-title="PDF"><i class="bx bxs-file-pdf font-size-18"></i></a> --}}
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
        window.location.href = "{{url($page_url.'/excel')}}/"+id;
    }
    function pdf(){
        var searchMonth = '{{@$query['month_year']}}';
        var ex = searchMonth.split(" ")
        // window.location.href = "{{url('shipping/excel')}}/"+id;
        window.open("{{url($page_url.'/pdf/'.$customer_id)}}/"+ex[0]+"/"+ex[1], '_blank')
    }
</script>
        <!-- Magnific Popup-->
        <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/magnific-popup/jquery.magnific-popup.min.js')}}"></script>

        <!-- lightbox init js-->
        <script src="{{ URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
@endsection