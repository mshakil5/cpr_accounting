<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\RestaurantExpDetail;
use App\Models\RestaurantExpense;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;

class RestaurantExpencesController extends Controller
{
    public function index()
    {
        $data = RestaurantExpense::with('expdetail')->orderby('id','DESC')->get();
        return view('admin.restaurant.expenses', compact('data'));
    }

    public function store(Request $request){

        $productname = $request->input('productname');
        
        if($productname == "" ){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill all field.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        
        if(empty($request->grand_total)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please Select a \"Product\" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->supplier_id)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please Select a \"Supplier\" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        

        // new code
        $order = new RestaurantExpense();
        $order->invoiceno = date('Ymd-his');
        $order->date = $request->date;
        $order->supplier_id = $request->supplier_id;
        $order->description = $request->description;
        $order->discount = $request->discount;
        $order->grand_amount = $request->grand_amount + $request->discount;
        $order->net_amount = $request->grand_amount;
        $order->created_by = Auth::user()->id;
        if($order->save()){
            $tamount = 0;
            foreach($request->input('productname') as $key => $value)
            {
                $orderDtl = new RestaurantExpDetail();
                $orderDtl->invoiceno = $order->invoiceno;
                $orderDtl->restaurant_expense_id = $order->id;
                $orderDtl->productname = $request->get('productname')[$key];
                $orderDtl->qty = $request->get('qty')[$key];
                $orderDtl->price_per_unit = $request->get('price_per_unit')[$key];
                $orderDtl->price = $request->get('qty')[$key] * $request->get('price_per_unit')[$key];
                $orderDtl->created_by = Auth::user()->id;
                $orderDtl->save();
                $tamount = $orderDtl->price + $tamount;
            }

            $order->grand_amount = $tamount;
            $order->paid_amount = $request->paid_amount;
            $order->due_amount = $tamount - $request->paid_amount;
            $order->net_amount = $tamount - $request->discount;
            $order->save();

            
            $supplier = Supplier::find($request->supplier_id);
            $supplier->due_amount = $supplier->due_amount + $request->due_amount;
            $supplier->total_purchase = $supplier->total_purchase + $order->net_amount;
            $supplier->save();

            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Thank you for this order.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message,'id'=>$order->id]);
        }
        

    }

    public function edit($id)
    {
        $data = RestaurantExpense::where('id', $id)->first();
        return view('admin.restaurant.expedit', compact('data'));
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
        

        $data = RestaurantExpense::find($request->codeid);
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

    
}
