<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Transaction::sum('total_price');
        $totalOrders = Transaction::count();
        $totalProducts = Product::count();
        $lowStockProducts = Product::where('stock', '<', 10)->count();
        
        $recentTransactions = Transaction::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalRevenue', 
            'totalOrders', 
            'totalProducts', 
            'lowStockProducts',
            'recentTransactions'
        ));
    }
}
