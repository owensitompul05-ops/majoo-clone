<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Employee; // <-- 1. IMPORT MODEL EMPLOYEE DI SINI
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // =========================================================================
    // MODUL 1: MANAJEMEN PRODUK (CRUD)
    // =========================================================================

    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sku' => 'required|unique:products,sku',
            'name' => 'required',
            'price_buy' => 'required|numeric',
            'price_sell' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        Product::create($validated);
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'sku' => 'required|unique:products,sku,' . $product->id,
            'name' => 'required',
            'price_buy' => 'required|numeric',
            'price_sell' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        $product->update($validated);
        return redirect()->route('products.index')->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Products berhasil dihapus!');
    }

    // =========================================================================
    // MODUL 2: TRANSAKSI MESIN KASIR (POS MULTI-PRODUK + EMPLOYEE)
    // =========================================================================

    public function posIndex()
    {
        $products = Product::where('stock', '>', 0)->get();
        
        // 2. AMBIL DATA KARYAWAN AGAR BISA DIPILIH DI VIEW
        $employees = Employee::all(); 
        
        $recentTransactions = Transaction::with('employee')->latest()->take(5)->get();

        // 3. PASANG VARIABEL EMPLOYEES KE COMPACT
        return view('products.pos', compact('products', 'employees', 'recentTransactions'));
    }

    public function posStore(Request $request)
    {
        // Validasi input array termasuk wajib memilih kasir bertugas
        $request->validate([
            'employee_id' => 'required|exists:employees,id', // <-- VALIDASI KASIR
            'cart' => 'required|array|min:1',
            'cart.*.product_id' => 'required|exists:products,id',
            'cart.*.qty' => 'required|numeric|min:1',
            'total_accepted' => 'required|numeric',
        ]);

        $total_price = 0;
        $itemsToProcess = [];

        DB::beginTransaction();

        try {
            // Validasi semua produk di keranjang & hitung total tagihan keseluruhan
            foreach ($request->cart as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->stock < $item['qty']) {
                    return redirect()->back()->with('error', 'Stok produk ' . $product->name . ' tidak mencukupi!');
                }

                $subtotal = $product->price_sell * $item['qty'];
                $total_price += $subtotal;

                $itemsToProcess[] = [
                    'product' => $product,
                    'qty' => $item['qty'],
                    'price' => $product->price_sell,
                    'subtotal' => $subtotal
                ];
            }

            // Cek apakah uang bayar cukup
            $total_return = $request->total_accepted - $total_price;
            if ($total_return < 0) {
                return redirect()->back()->with('error', 'Uang tunai yang dibayarkan kurang!');
            }

            // 4. SIMPAN DATA TRANSAKSI DENGAN EMPLOYEE_ID
            $transaction = Transaction::create([
                'invoice_number' => 'INV-' . date('YmdHis'),
                'employee_id' => $request->employee_id, // <-- REKAM ID KARYAWAN
                'total_price' => $total_price,
                'total_accepted' => $request->total_accepted,
                'total_return' => $total_return,
            ]);

            // Looping untuk simpan detail item & potong stok masing-masing produk
            foreach ($itemsToProcess as $item) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product']->id,
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);

                // POTONG STOK PRODUK MASING-MASING
                $item['product']->decrement('stock', $item['qty']);
            }

            DB::commit();

            return redirect()->route('transactions.index')->with([
                'success' => 'Transaksi Berhasil disimpan! Kembalian: Rp ' . number_format($total_return, 0, ',', '.'),
                'print_id' => $transaction->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    // =========================================================================
    // MODUL 3: PRINT STRUK & LAPORAN PENJUALAN
    // =========================================================================

    public function posPrint($id)
    {
        $transaction = Transaction::with(['details.product', 'employee'])->findOrFail($id);
        return view('products.print', compact('transaction'));
    }

    public function reportIndex()
    {
        $totalOmset = Transaction::sum('total_price');
        $totalTerjual = TransactionDetail::sum('qty');

        $allDetails = TransactionDetail::with('product')->get();
        $totalProfit = 0;

        foreach ($allDetails as $detail) {
            if ($detail->product) {
                $profitPerItem = ($detail->price - $detail->product->price_buy) * $detail->qty;
                $totalProfit += $profitPerItem;
            }
        }

        $allTransactions = Transaction::with(['details.product', 'employee'])->latest()->get();
        return view('products.report', compact('totalOmset', 'totalTerjual', 'totalProfit', 'allTransactions'));
    }
}