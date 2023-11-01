<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SaleDetail;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function index()
    {
        $foods = Product::all();
        $data = Sale::orderby('id','DESC')->get();
        return view('admin.restaurant.foodsale', compact('data','foods'));
    }

    public function store(Request $request){

        $productIDs = $request->input('product_id');
        $price_per_units = $request->input('price_per_unit');
        $qtys = $request->input('qty');
        
        if($productIDs == "" ){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill Product field.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        
        if(empty($request->grand_total)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please Select a \"Product\" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        
        
        // new code
        $order = new Sale();
        $order->invoiceno = date('Ymd-his');
        $order->date = $request->date;
        $order->description = $request->description;
        $order->discount = $request->discount;
        $order->grand_amount = $request->grand_amount + $request->discount;
        $order->net_amount = $request->grand_amount;
        $order->created_by = Auth::user()->id;
        if($order->save()){
            $tamount = 0;
            foreach($request->input('product_id') as $key => $value)
            {
                $orderDtl = new SaleDetail();
                $orderDtl->invoiceno = $order->invoiceno;
                $orderDtl->sale_id = $order->id;
                $orderDtl->product_id = $request->get('product_id')[$key];
                $orderDtl->qty = $request->get('qty')[$key];
                $orderDtl->price_per_unit = $request->get('price_per_unit')[$key];
                $orderDtl->price = $request->get('qty')[$key] * $request->get('price_per_unit')[$key];
                $orderDtl->created_by = Auth::user()->id;
                $orderDtl->save();
                $tamount = $orderDtl->price + $tamount;
            }

            $order->grand_amount = $tamount;
            $order->net_amount = $tamount - $request->discount;
            $order->save();
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Thank you for this order.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message,'id'=>$order->id]);
        }

    }

    public function edit($id)
    {
        $foods = Product::all();
        $data = Sale::with('saledetail')->where('id', $id)->first();
        return view('admin.restaurant.foodsaleedit', compact('data','foods'));
    }

    public function update(Request $request)
    {

        
        if(empty($request->date)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Date \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->amount)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Amount \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        

        $data = Sale::find($request->codeid);
        $data->date = $request->date;
        $data->amount = $request->amount;
        $data->updated_by = Auth::user()->id;
        if ($data->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }
        else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        } 
    }

    public function getproduct(Request $request)
    {

        $accdtl = Product::where('id', '=', $request->accname)->first();

        if(empty($accdtl)){
            return response()->json(['status'=> 303,'message'=>"No data found"]);
        }else{
                return response()->json(['status'=> 300,'name'=>$accdtl->name,'price'=>$accdtl->price,'product_id'=>$accdtl->id]);
        }
    }
}
