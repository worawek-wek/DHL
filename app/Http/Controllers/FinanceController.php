<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Finance;
use App\Customer;

DB::beginTransaction();
class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page'] = 'การเงิน';
        $data['page_url'] = 'finance';
        $results = Finance::orderBy('id','DESC')->paginate(10);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();

        $dataPaginate = $results->toArray();

        $data['num'] = $dataPaginate['from'];
        return view('finance/index',$data);
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

            DB::commit();
            return redirect('finance')->with('message', 'Insert product "'.$request->deduct_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
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
            $finance->save();

            DB::commit();
            return response($finance->id);
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
        $data['page_before'] = 'การเงิน';
        $data['page'] = 'Add';
        $data['page_url'] = 'finance';
        $data['action'] = "/finance/$id/update";
        $data['method'] = "PUT";
        
        $data['customer'] = Customer::get();
        $data['finance'] = Finance::find($id);

        return view('finance/add',$data);
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

            DB::commit();
            return redirect('finance')->with('message', 'Insert product "'.$request->deduct_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function updateAjax(Request $request, $id)
    {
        try{
            $finance = Finance::find($id);
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
            $finance->save();

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
