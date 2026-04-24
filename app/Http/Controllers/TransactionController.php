<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = \App\Models\Transaction::with(['user', 'details.product' => function($q) {
            $q->withTrashed();
        }])->latest()->get();
        return view('transactions.index', compact('transactions'));
    }

    public function receipt(\App\Models\Transaction $transaction)
    {
        $transaction->load(['details.product' => function($q) {
            $q->withTrashed();
        }, 'user']);
        return view('transactions.receipt', compact('transaction'));
    }

    public function export()
    {
        $transactions = \App\Models\Transaction::with('user')->latest()->get();
        $filename = "Laporan_Transaksi_" . date('Y-m-d') . ".csv";
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($transactions) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8 compatibility with Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Use semicolon as delimiter for better Excel compatibility in most regions
            fputcsv($file, ['Invoice', 'Tanggal', 'Kasir', 'Total Harga', 'Bayar', 'Kembalian'], ';');

            foreach ($transactions as $tr) {
                fputcsv($file, [
                    $tr->invoice_number,
                    $tr->transaction_date,
                    $tr->user->name,
                    number_format($tr->total_price, 0, '', ''), // Raw number for Excel
                    number_format($tr->pay, 0, '', ''),
                    number_format($tr->change, 0, '', '')
                ], ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
