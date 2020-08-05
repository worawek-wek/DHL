<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Finance;

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
        $data['page'] = 'Finance';
        $data['page_url'] = 'finance';
        // $results = Finance::orderBy('id','DESC')->paginate(10);

        // $data['list_data'] = $results->appends(request()->query());
        // $data['query'] = request()->query();

        // $dataPaginate = $results->toArray();

        // $data['num'] = $dataPaginate['from'];
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
        $data['page_before'] = 'Finance';
        $data['page'] = 'Add';
        $data['page_url'] = 'finance';
        $data['action'] = '/finance';
        $data['method'] = "POST";
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
            $product = new Finance;
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
            $product->number = $request->number;
            $product->date_current = $request->date_current;
            $product->pay_price = $request->pay_price;
            $product->pay_tax = $request->pay_tax;
            $product->pay_tax_text = $request->pay_tax_text;
            $product->who_pay = '$request->who_pay';
            $product->save();

            DB::commit();
            return redirect('finance')->with('message', 'Insert product "'.$request->deduct_name.'" success');
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
        $data['page_before'] = 'Finance';
        $data['page'] = 'Add';
        $data['page_url'] = 'finance';
        $data['action'] = "/finance/$id/update";
        $data['method'] = "PUT";
        
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
            $product = Finance::find($id);
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
            $product->number = $request->number;
            $product->date_current = $request->date_current;
            $product->pay_price = $request->pay_price;
            $product->pay_tax = $request->pay_tax;
            $product->pay_tax_text = $request->pay_tax_text;
            $product->who_pay = '$request->who_pay';
            $product->save();

            DB::commit();
            return redirect('finance')->with('message', 'Insert product "'.$request->deduct_name.'" success');
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
