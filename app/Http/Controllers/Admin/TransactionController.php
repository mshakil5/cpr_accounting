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
        $data = Transaction::where('table_type', 'Expense')->orderby('id','DESC')->get();
        $accounts = Account::where('status', '1')->get();
        $coa = ChartOfAccount::where('account_head','Expenses')->get();
        return view('admin.transaction.expense', compact('data','accounts','coa'));
    }

    public function getIncome()
    {
        $data = Transaction::where('table_type', 'Income')->orderby('id','DESC')->get();
        $accounts = Account::where('status', '1')->get();
        $coa = ChartOfAccount::where('account_head','Income')->get();
        return view('admin.transaction.income', compact('data','accounts','coa'));
    }

    public function getAsset()
    {
        $data = Transaction::where('table_type', 'Assets')->orderby('id','DESC')->get();
        $accounts = Account::where('status', '1')->get();
        $coa = ChartOfAccount::where('account_head','Assets')->get();
        return view('admin.transaction.asset', compact('data','accounts','coa'));
    }

    public function getLiabilities()
    {
        $data = Transaction::where('table_type', 'Liabilities')->orderby('id','DESC')->get();
        $accounts = Account::where('status', '1')->get();
        $coa = ChartOfAccount::where('account_head','Liabilities')->get();
        return view('admin.transaction.liabilities', compact('data','accounts','coa'));
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

    public function edit($id)
    {
        $where = [
            'id'=>$id
        ];
        $info = Transaction::where($where)->get()->first();
        return response()->json($info);
    }
}
