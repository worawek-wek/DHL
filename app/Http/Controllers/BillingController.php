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
class BillingController extends Controller
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
        return view('billing/index',$data);
        
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
    public function indexPDF($id)
    {
        $product = Shipping::find($id);
        $mpdf = PDFController::AWB($product)->Output();
        
    }
}
