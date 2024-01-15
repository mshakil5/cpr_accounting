<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TicketSale;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TicketSaleController extends Controller
{
    public function index()
    {
        $data = TicketSale::orderby('id','DESC')->get();
        $accounts = Account::where('branch','Resort')->orderby('id','ASC')->get();
        return view('admin.ticketsale.index', compact('data','accounts'));
    }

    public function store(Request $request)
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

        
        if(empty($request->account_id)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Payment Receive Method \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        
        if(empty($request->price_per_unit)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Ticket Price \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->number)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Number of ticket \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        $data = new TicketSale;
        $data->date = $request->date;
        $data->number = $request->number;
        $data->price_per_unit = $request->price_per_unit;
        $data->amount = $request->amount;
        $data->account_id = $request->account_id;
        $data->created_by = Auth::user()->id;
        if ($data->save()) {

            $account = Account::find($request->account_id);
            $account->balance = $account->balance + $request->amount;
            $account->save();

            $tran = new Transaction();
            $tran->date = $request->date;
            $tran->account_id = $request->account_id;
            $tran->table_type = "Income";
            $tran->tran_title = "Ticket Sale";
            $tran->transaction_type = "Current";
            $tran->amount = $request->amount;
            $tran->save();


            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Create Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function edit($id)
    {
        $where = [
            'id'=>$id
        ];
        $info = TicketSale::where($where)->get()->first();
        return response()->json($info);
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
        if(empty($request->account_id)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Payment Receive Method \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->price_per_unit)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Ticket Price \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->number)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Number of ticket \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        $data = TicketSale::find($request->codeid);
        $data->date = $request->date;
        $data->number = $request->number;
        $data->price_per_unit = $request->price_per_unit;
        $data->amount = $request->amount;
        $data->account_id = $request->account_id;
        $data->updated_by = Auth::user()->id;
        if ($data->save()) {

            $account = Account::find($request->account_id);
            $account->balance = $account->balance + $request->amount;
            $account->save();

            $tran = new Transaction();
            $tran->date = $request->date;
            $tran->account_id = $request->account_id;
            $tran->table_type = "Income";
            $tran->tran_title = "Ticket Sale";
            $tran->transaction_type = "Current";
            $tran->amount = $request->amount;
            $tran->save();




            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }
        else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        } 
    }
}
