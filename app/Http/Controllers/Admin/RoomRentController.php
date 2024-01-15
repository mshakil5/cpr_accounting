<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Account;
use App\Models\RoomRent;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class RoomRentController extends Controller
{
    public function index()
    {
        $data = RoomRent::orderby('id','DESC')->get();
        $accounts = Account::where('branch','Resort')->orderby('id','ASC')->get();
        return view('admin.roomrent.index', compact('data','accounts'));
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
        

        $data = new RoomRent;
        $data->date = $request->date;
        $data->amount = $request->amount;
        $data->v_name = $request->v_name;
        $data->v_number = $request->v_number;
        $data->v_address = $request->v_address;
        $data->room_number = $request->room_number;
        $data->account_id = $request->account_id;
        $data->v_nid = $request->v_nid;
        $data->created_by = Auth::user()->id;
        if ($data->save()) {

            $account = Account::find($request->account_id);
            $account->balance = $account->balance + $request->amount;
            $account->save();

            $tran = new Transaction();
            $tran->date = $request->date;
            $tran->account_id = $request->account_id;
            $tran->room_rent_id = $data->id;
            $tran->table_type = "Income";
            $tran->tran_title = "Room Rent";
            $tran->transaction_type = "Current";
            $tran->amount = $request->amount;
            $tran->created_by = Auth::user()->id;
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
        $info = RoomRent::where($where)->get()->first();
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
        

        $data = RoomRent::find($request->codeid);

            $account = Account::find($data->account_id);
            $account->balance = $account->balance - $data->amount;
            $account->save();


        $data->date = $request->date;
        $data->amount = $request->amount;
        $data->v_name = $request->v_name;
        $data->v_number = $request->v_number;
        $data->v_address = $request->v_address;
        $data->account_id = $request->account_id;
        $data->room_number = $request->room_number;
        $data->v_nid = $request->v_nid;
        $data->updated_by = Auth::user()->id;
        if ($data->save()) {


            $upaccount = Account::find($request->account_id);
            $upaccount->balance = $upaccount->balance + $request->amount;
            $upaccount->save();

            $chktranid = Transaction::where('room_rent_id', $request->codeid)->first()->id;
            $tran = Transaction::find($chktranid);
            $tran->date = $request->date;
            $tran->account_id = $request->account_id;
            $tran->amount = $request->amount;
            $tran->updated_by = Auth::user()->id;
            $tran->save();


            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }
        else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        } 
    }
}
