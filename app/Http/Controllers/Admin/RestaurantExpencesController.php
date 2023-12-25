<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\SaleDetail;
use App\Models\RestaurantExpense;
use Illuminate\Support\Facades\Auth;

class RestaurantExpencesController extends Controller
{
    public function index()
    {
        $data = RestaurantExpense::orderby('id','DESC')->get();
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

        $invoiceId = date('Ymd-his');

        $tamount = 0;
        foreach($request->input('productname') as $key => $value)
        {
            $data = new RestaurantExpense();
            $data->invoiceno = $invoiceId;
            $data->description = $request->description;
            $data->date = $request->date;
            $data->productname = $request->get('productname')[$key];
            $data->qty = $request->get('qty')[$key];
            $data->price_per_unit = $request->get('price_per_unit')[$key];
            $data->price = $request->get('qty')[$key] * $request->get('price_per_unit')[$key];
            $data->created_by = Auth::user()->id;
            $data->save();
            $tamount = $data->price + $tamount;
        }

        $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Expense create successfully..</b></div>";
        return response()->json(['status'=> 300,'message'=>$message]);
        

    }

    public function edit($id)
    {
        $foods = Product::all();
        $data = RestaurantExpense::with('saledetail')->where('id', $id)->first();
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
