<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index()
    {
        $products = \App\Models\Product::with('category')->where('stock', '>', 0)->get();
        $categories = \App\Models\Category::all();
        return view('pos.index', compact('products', 'categories'));
    }

    public function checkout(Request $request)
    {
        try {
            $request->validate([
                'cart' => 'required|array',
                'pay' => 'required|numeric',
            ]);

            $subtotal = 0;
            foreach ($request->cart as $item) {
                $product = \App\Models\Product::findOrFail($item['id']);
                $subtotal += $product->price * $item['qty'];
            }

            // Calculate total with 10% tax
            $total_price = $subtotal * 1.1;
            $change = $request->pay - $total_price;

            if ($change < 0) {
                return response()->json(['message' => 'Payment not enough. Need: Rp ' . number_format($total_price, 0, ',', '.')], 400);
            }

            \DB::beginTransaction();

            $transaction = \App\Models\Transaction::create([
                'user_id' => auth()->id(),
                'invoice_number' => 'INV-' . time() . '-' . rand(100, 999),
                'total_price' => $total_price,
                'pay' => $request->pay,
                'change' => $change,
                'transaction_date' => now(),
            ]);

            foreach ($request->cart as $item) {
                \App\Models\TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['id'],
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['qty'],
                ]);

                // Reduce stock
                $product = \App\Models\Product::find($item['id']);
                $product->decrement('stock', $item['qty']);
            }

            \DB::commit();

            return response()->json(['message' => 'Transaction success', 'transaction_id' => $transaction->id]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
