<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DaybookController extends Controller
{
    public function daybook()
    {
        $data = Transaction::whereNotNull('account_id')->orderby('id','DESC')->get();
        return view('admin.daybook.index', compact('data'));
    }
}
