<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Shipping;
use App\Finance;
use App\Customer;
use App\Http\Controllers\PDFController;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
DB::beginTransaction();
class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['page'] = 'การเงิน';
        $data['page_url'] = 'finance';
        $results = Shipping::select("ref_customer_id")->groupBy('ref_customer_id');
        // $results = Shipping::orderBy('id','DESC');
        if(!is_null($request->deduct_tax_identification)){
            $results = $results->Where('deduct_tax_identification','LIKE','%'.$request->deduct_tax_identification.'%');
        }
        if(!is_null($request->deduct_name)){
            $results = $results->Where('deduct_name','LIKE','%'.$request->deduct_name.'%');
        }
        if(!is_null($request->month_year)){
            $month = explode(' ',$request->month_year);
            
            $data['month'] = $month[0];
            $data['year'] = $month[1];

            $results = $results->Where('created_at','LIKE',$month[1].'-'.$month[0].'%');
        }
        $results = $results->paginate(10);
// return $results;
        foreach($results as $row){
            // return $row->ref_customer_id;
            $rowFinance = Shipping::where('ref_customer_id',$row->ref_customer_id)->orderBy('id','DESC')->first();

            $row['deduct_tax_identification'] = $rowFinance['deduct_tax_identification'];
            $row['deduct_name'] = $rowFinance['deduct_name'];
            $row['address_number'] = $rowFinance['address_number'];
            $row['address_moo'] = $rowFinance['address_moo'];
            $row['address_alley'] = $rowFinance['address_alley'];
            $row['address_street'] = $rowFinance['address_street'];
            $row['address_subdistrict'] = $rowFinance['address_subdistrict'];
            $row['address_district'] = $rowFinance['address_district'];
            $row['address_province'] = $rowFinance['address_province'];
            $row['address_zipcode'] = $rowFinance['address_zipcode'];
            $row['phone'] = $rowFinance['phone'];
            $row['created_at'] = $rowFinance['created_at'];
            $row['updated_at'] = $rowFinance['updated_at'];
        }
        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();

        $dataPaginate = $results->toArray();

        $data['num'] = $dataPaginate['from'];
        return view('finance/index',$data);
        //
    }
    public function finaceByCustomer(Request $request, $id)
    {
        $data['page_before'] = 'การเงิน';
        $data['page_url'] = 'finance';
        $data['customer_id'] = $id;
        $row = Shipping::where('ref_customer_id', $id)->first();
        $results = Shipping::orderBy('id','DESC')->where('ref_customer_id', $id);
        if(!is_null($request->month_year)){
            $month = explode(' ',$request->month_year);
            
            $data['month'] = $month[0];
            $data['year'] = $month[1];

            $results = $results->Where('created_at','LIKE',$month[1].'-'.$month[0].'%');
        }
        $results = $results->paginate(10);
        $data['page'] = $row->deduct_name.' '.$row->deduct_tax_identification;

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();

        $dataPaginate = $results->toArray();

        $data['num'] = $dataPaginate['from'];
        return view('finance/customer',$data);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_before'] = 'การเงิน';
        $data['page'] = 'Add';
        $data['page_url'] = 'finance';
        $data['action'] = '/finance';
        $data['method'] = "POST";
        $data['customer'] = Customer::get();
        return view('finance/add',$data);
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
        try{

            PDFController::PND53($request)->Output();

        } catch (QueryException $err) {
        }
    }
    public function storeAjax(Request $request)
    {
        try{
            $finance = new Finance;
            $finance->deduct_tax_identification = $request->deduct_tax_identification;
            $finance->deduct_name = $request->deduct_name;
            $finance->address_number = $request->address_number;
            $finance->address_moo = $request->address_moo;
            $finance->address_alley = $request->address_alley;
            $finance->address_street = $request->address_street;
            $finance->address_subdistrict = $request->address_subdistrict;
            $finance->address_district = $request->address_district;
            $finance->address_province = $request->address_province;
            $finance->address_zipcode = $request->address_zipcode;
            $finance->phone = $request->phone;
            $finance->month_pay = $request->month_pay;
            $finance->year_pay = $request->year_pay;
            $finance->attachment = $request->attachment;
            $finance->media = $request->media;
            $finance->qty_case = $request->qty_case;
            $finance->qty_sheet = $request->qty_sheet;
            $finance->total_amount = $request->total_amount;
            $finance->total_tax = $request->total_tax;
            $finance->extra_money = $request->extra_money;
            $finance->total_tax_delivered = $request->total_tax_delivered;
            $finance->ref_customer_id = $request->customer_id;
            $finance->save();

            DB::commit();
            return response($finance->id);
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function firstCustomer($id)
    {
        $data = Customer::find($id);

        return response($data);
        //
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
        $data['page_before'] = 'การเงิน';
        $data['page'] = 'Add';
        $data['page_url'] = 'finance';
        $data['action'] = "/finance/$id/update";
        $data['method'] = "PUT";
        
        $data['customer'] = Customer::get();
        $data['shipping'] = Shipping::find($id);

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
        try{
            $product = Shipping::find($id);
            $product->deduct_tax_identification = $request->deduct_tax_identification;
            $product->deduct_name = $request->deduct_name;
            // $product->deduct_address = $request->deduct_address;
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
            $product->address_number = $request->address_number;
            $product->address_moo = $request->address_moo;
            $product->address_alley = $request->address_alley;
            $product->address_street = $request->address_street;
            $product->address_subdistrict = $request->address_subdistrict;
            $product->address_district = $request->address_district;
            $product->address_province = $request->address_province;
            $product->address_zipcode = $request->address_zipcode;
            $product->phone = $request->phone;
            $product->save();

            DB::commit();
            return redirect("finance/$request->customer_id/customer");
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function updateAjax(Request $request, $id)
    {
        try{
            DB::commit();
            return response($id);
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }

    public function pdfFinance($id,$month,$year){  
        
        $results = Shipping::selectRaw("ref_customer_id,SUM(pay_price) as total_amount,SUM(pay_tax) as total_tax,SUM(pay_price)+SUM(pay_tax) as total_tax_delivered")
                            ->groupBy('ref_customer_id')->whereIn('ref_customer_id', explode(',',$id))->where('created_at','LIKE', $year.'-'.$month.'%')->orderBy('id','DESC')->get();
        if(count($results)>0){
            $mpdf = new \Mpdf\Mpdf([
                'default_font_size' => 16,
                'default_font' => 'sarabun'
            ]);
    
            foreach($results as $row){
                $shipping = Shipping::where('ref_customer_id',$row->ref_customer_id)->first();
                
                $row['deduct_tax_identification'] = $shipping['deduct_tax_identification'];
                $row['deduct_name'] = $shipping['deduct_name'];
                $row['address_number'] = $shipping['address_number'];
                $row['address_moo'] = $shipping['address_moo'];
                $row['address_alley'] = $shipping['address_alley'];
                $row['address_street'] = $shipping['address_street'];
                $row['address_subdistrict'] = $shipping['address_subdistrict'];
                $row['address_district'] = $shipping['address_district'];
                $row['address_province'] = $shipping['address_province'];
                $row['address_zipcode'] = $shipping['address_zipcode'];
                $row['phone'] = $shipping['phone'];
    
                $mpdf = PDFController::PND53($row, $month, $year, $mpdf);
            }
            $mpdf->Output();
        }
    }
    // public function indexPDF($id,$month,$year)
    // {
    //     $product = Shipping::find($id);
    //     // return $product;

    //     $mpdf = PDFController::PND53($product,$month,$year)->Output();
        
    // }
    public function excelFinance($id){
        // return $id;
        $results = Shipping::whereIn('id', explode(',',$id))->orderBy('id','DESC')->get();
        $data[] = [
                'เลขประจำตัวผู้เสียภาษีอากร',
                'ชื่อ', 
                'ที่อยู่',
                'โทรศัพท์',
                'เดือนที่จ่ายเงินได้พึงประเมิน',
                'รายการที่แนบ',
                'ราย',
                'แผ่น',
                'รวมยอดเงินได้ทั้งสิ้น',
                'รวมยอดภาษีที่นำส่งทั้งสิ้น',
                'เงินเพิ่ม(ถ้ามี)',
                'รวมยอดภาษีที่นำส่งทั้งสิ้น และเงินเพิ่ม',
                'ยื่นวันที่'
            ];
        foreach($results as $row){
        $address = $row->address_number.' '.$row->address_moo.' '.$row->address_alley.' '.$row->address_street.' '.$row->address_subdistrict.' '.$row->address_district.' '.$row->address_province.' '.$row->address_zipcode;
        $attachment = $row->attachment == 1 ?'ใบแนบ ภ.ง.ด.53':'สื่อบันทึกในคอมพิวเตอร์';
        $data[] = [
                $row->deduct_tax_identification,
                $row->deduct_name,
                $address,
                $row->phone,
                $row->month_pay,
                $attachment,
                $row->qty_case,
                $row->qty_sheet,
                // date("d/m/Y",strtotime($row->date_current)),
                number_format($row->total_amount,2),
                number_format($row->total_tax,2),
                number_format($row->extra_money,2),
                number_format($row->total_tax_delivered,2),
                $row->created_at,
            ];
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray($data);

        $writer = new Xlsx($spreadsheet);
        $writer->save('excel/PND53.xlsx');
        return redirect('excel/PND53.xlsx');
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
