<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\ChartOfAccount;
use Illuminate\Http\Request;
use App\Models\EmployeeHistory;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function getExpense()
    {
        $data = Transaction::orderby('id','DESC')->get();
        $accounts = Account::where('status', '1')->get();
        $coa = ChartOfAccount::where('account_head','Expenses')->get();
        return view('admin.transaction.expense', compact('data','accounts','coa'));
    }


    public function store(Request $request)
    {
        if(empty($request->account_id)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Name \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->chart_of_account_id)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Account Head \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        $tran_title = ChartOfAccount::where('id', $request->chart_of_account_id)->first()->account_name;

        $data = new Transaction;
        $data->date = $request->date;
        $data->account_id = $request->account_id;
        $data->chart_of_account_id = $request->chart_of_account_id;
        $data->tran_title = $tran_title;
        $data->amount = $request->amount;
        $data->transaction_type = $request->transaction_type;
        $data->table_type = $request->table_type;
        $data->description = $request->description;
        $data->expense_id = $request->expense_id;
        
        $data->created_by = Auth::user()->id;
        if ($data->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Create Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }
}
