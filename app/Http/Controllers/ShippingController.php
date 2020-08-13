<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Shipping;
use App\Customer;
use App\Http\Controllers\PDFController;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

DB::beginTransaction();
class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['page'] = 'รายการย้ายคลัง';
        $data['page_url'] = 'shipping';
        $results = Shipping::orderBy('id','DESC');
        if(!is_null($request->deduct_tax_identification)){
            $results = $results->Where('deduct_tax_identification','LIKE','%'.$request->deduct_tax_identification.'%');
        }
        if(!is_null($request->awb_no)){
            $results = $results->Where('awb_no','LIKE','%'.$request->awb_no.'%');
        }
        if(!is_null($request->updated_at)){
            $results = $results->Where('updated_at','LIKE',$request->updated_at.'%');
        }
        if(!is_null($request->dec_no)){
            $results = $results->Where('dec_no','LIKE','%'.$request->dec_no.'%');
        }
        if(!is_null($request->deduct_name)){
            $results = $results->Where('deduct_name','LIKE','%'.$request->deduct_name.'%');
        }
        if(!is_null($request->created_at)){
            $results = $results->Where('created_at','LIKE',$request->created_at.'%');
        }
        $results = $results->paginate(10);
        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();

        $dataPaginate = $results->toArray();

        $data['num'] = $dataPaginate['from'];
        return view('shipping/index',$data);
        
    }
    public function excelShipping($id){
        // return $id;
        $results = Shipping::whereIn('id', explode(',',$id))->orderBy('id','DESC')->get();
        $data[] = [
                'เลขประจำตัวผู้เสียภาษีอากร',
                'ชื่อ', 
                'ที่อยู่',
                'เลขประจำตัวผู้เสียภาษีอากร(การกระทำการแทน)',
                'โดยตัวแทน',
                'ที่อยู่(การกระทำการแทน)',
                'เลขประจำตัวผู้เสียภาษีอากร(ผู้ถูกหักภาษี ณ ที่จ่าย)',
                'ชื่อ',
                'ที่อยู่(ผู้ถูกหักภาษี ณ ที่จ่าย)',
                'AWB No.',
                'ลำดับที่',
                'วัน เดือน หรือ ปีภาษีที่จ่าย',
                'จำนวนเงินที่จ่าย',
                'ภาษีที่หักและนำส่งไว้',
                'รวมเงินภาษีที่หักนำส่ง'
            ];
        foreach($results as $row){
            $data[] = [
                $row->deduct_tax_identification,
                $row->deduct_name,
                $row->deduct_address,
                $row->represent_tax_identification,
                $row->represent_name,
                $row->represent_address,
                $row->pay_tax_identification,
                $row->pay_name,
                $row->pay_address,
                $row->awb_no,
                $row->number,
                date("d/m/Y",strtotime($row->date_current)),
                $row->pay_price,
                $row->pay_tax,
                $row->pay_tax_text,
            ];
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray($data);

        $writer = new Xlsx($spreadsheet);
        $writer->save('excel/helloworld.xlsx');
        return redirect('excel/helloworld.xlsx');
    }
    public function pdfShipping($id){  
        $results = Shipping::whereIn('id', explode(',',$id))->orderBy('id','DESC')->get();
        
        $mpdf = new \Mpdf\Mpdf([
            'default_font_size' => 16,
            'default_font' => 'sarabun'
        ]);

        foreach($results as $row){

            $mpdf = PDFController::AWB($row, $mpdf);
        }
        $mpdf->Output();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_before'] = 'การส่งสินค้า';
        $data['page'] = 'Add';
        $data['page_url'] = 'shipping';
        $data['action'] = '/shipping';
        $data['method'] = "POST";
        $data['shipping'] = [
                                'represent_tax_identification'=>'0105533022910',
                                'represent_name'=>'บริษัท ดีเอชแอล เอ๊กเพรส (ประเทศไทย) จำกัด',
                                'represent_address'=>'อาคารบีเอฟเอส คาร์โก้ เทอร์มินอล ห้องเลขที่ ดี 202 เลขที่ 777 หมู่ 7 ต.ราชาเทวะ อ.บางพลี จ.สมุทรปราการ 10540"',
                                'pay_tax_identification'=>'0105547017506',
                                'pay_name'=>'บริษัท ดับบลิวเอฟเอสพีจีคาร์โก้ จำกัด',
                                'pay_address'=>'777 หมู่ 7 ต.ราชาเทวะ อ.บางพลี จ.สมุทรปราการ 10540',
                                'number'=>7,
                                'date_current'=>date('d/m/Y')
                        ];
        $data['customer'] = Customer::get();

        // $data['shipping']->represent_tax_identification = 
        return view('shipping/add',$data);
        //
    }
    public function firstCustomer($id)
    {
        $data = Customer::find($id);

        return response($data);
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mpdf = PDFController::AWB($request);
        $mpdf->Output();

    }
    public function storeAjax(Request $request)
    {
        try{
            $product = new Shipping;
            $product->deduct_tax_identification = $request->deduct_tax_identification;
            $product->deduct_name = $request->deduct_name;
            $product->deduct_address = $request->deduct_address;
            $product->represent_tax_identification = $request->represent_tax_identification;
            $product->represent_name = $request->represent_name;
            $product->represent_address = $request->represent_address;
            $product->pay_tax_identification = $request->pay_tax_identification;
            $product->pay_name = $request->pay_name;
            $product->pay_address = $request->pay_address;
            $product->awb_no = $request->awb_no;
            $product->number = 7;
            $product->date_current = $request->date_current;
            $product->pay_price = $request->pay_price;
            $product->pay_tax = $request->pay_tax;
            $product->pay_tax_text = $request->pay_tax_text;
            $product->who_pay = '$request->who_pay';
            $product->ref_customer_id = $request->customer_id;
            $product->save();

            DB::commit();
            return response($product->id);
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['page_before'] = 'การส่งสินค้า';
        $data['page'] = 'Add';
        $data['page_url'] = 'shipping';
        $data['action'] = "/shipping/$id/update";
        $data['method'] = "PUT";
        
        $data['shipping'] = Shipping::find($id);
        $data['customer'] = Customer::get();

        return view('shipping/add',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $mpdf = PDFController::AWB($request);
        $mpdf->Output();
    }
    public function indexPDF($id)
    {
        $product = Shipping::find($id);
        $mpdf = PDFController::AWB($product);
        $mpdf->Output();
    }
    public function updateAjax(Request $request, $id)
    {
        try{
            $product = Shipping::find($id);
            $product->deduct_tax_identification = $request->deduct_tax_identification;
            $product->deduct_name = $request->deduct_name;
            $product->deduct_address = $request->deduct_address;
            $product->represent_tax_identification = $request->represent_tax_identification;
            $product->represent_name = $request->represent_name;
            $product->represent_address = $request->represent_address;
            $product->pay_tax_identification = $request->pay_tax_identification;
            $product->pay_name = $request->pay_name;
            $product->pay_address = $request->pay_address;
            $product->awb_no = $request->awb_no;
            // $product->number = $request->number;
            $product->date_current = $request->date_current;
            $product->pay_price = $request->pay_price;
            $product->pay_tax = $request->pay_tax;
            $product->pay_tax_text = $request->pay_tax_text;
            $product->who_pay = '$request->who_pay';
            $product->ref_customer_id = $request->customer_id;
            $product->save();

            DB::commit();
            return response($id);
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
