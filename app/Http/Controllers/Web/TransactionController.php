<?php

namespace App\Http\Controllers\Web;

use App\Exports\TransactionExport;
use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class TransactionController extends Controller
{
    public function index(Request $request) {
        $role = auth()->user()->role_id;
        $trxs = new Transaction();

        if($role === 2) $trxs = Transaction::where('type', 2) // Buying
            ->where('receiver_id', auth()->id());
        if($role === 3) $trxs = Transaction::where('type', 1); // Topup
        if($role === 4) $trxs = Transaction::where('sender_id', auth()->id())
            ->orWhere('receiver_id', auth()->id());

        $trxs = $trxs->fastPaginate($request);

        return view('pages.all.transactions.index', ['transactions' => $trxs]);
    }


    public function topup(Request $request) {
        try{
            Transaction::fastTopup($request, $request->user_id);
            Alert::success('Success', 'Topup created successfully');
            return back();
        }catch(Exception $err) {
            Alert::error('Failed', $err->getMessage());
            return back();
        }
    }
    
    
    public function approve($transactionId) {
        try{
            Transaction::fastApprove($transactionId);
            Alert::success('Success', 'Topup approved successfully');
            return back();
        }catch(Exception $err) {
            Alert::error('Failed', $err->getMessage());
            return back();
        }
    }
    
    
    public function reject($transactionId) {
        try{
            Transaction::fastReject($transactionId);
            Alert::success('Success', 'Topup rejected successfully');
            return back();
        }catch(Exception $err) {
            Alert::error('Failed', $err->getMessage());
            return back();
        }
    }

    public function export() {
        try{
            return Excel::download(new TransactionExport, 'transactions.xlsx');
        }catch(Exception $err) {
            Alert::error('Failed', $err->getMessage());
            return back();
        }
    }

    
    public function buy(Request $request, Item $item) {
        try{
            Transaction::fastBuy($item);
            Alert::success('Success', 'Buying successfully');
            return back();
        }catch(Exception $err) {
            Alert::error('Failed', $err->getMessage());
            return back();
        }
    }


    public function approveBuy($transactionId) {
        try{
            Transaction::fastApproveBuy($transactionId);
            Alert::success('Success', 'Transaction approved successfully');
            return back();
        }catch(Exception $err) {
            Alert::error('Failed', $err->getMessage());
            return back();
        }
    }
    
    
    public function rejectBuy($transactionId) {
        try{
            Transaction::fastRejectBuy($transactionId);
            Alert::success('Success', 'Transaction rejected successfully');
            return back();
        }catch(Exception $err) {
            Alert::error('Failed', $err->getMessage());
            return back();
        }
    }
}
