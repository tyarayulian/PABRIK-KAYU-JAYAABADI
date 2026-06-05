<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalesReturnRequest;
use App\Models\ChartOfAccount;
use App\Models\Product;
use App\Models\SalesReturn;
use App\Models\KasMasuk;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
use Carbon\Carbon;

class SalesReturnController extends Controller
{
    public function index()
    {
        $salesReturns = SalesReturn::with(['product', 'account', 'returnAccount', 'kasMasuk'])
            ->orderBy('date', 'desc')
            ->get();
            
        $totalReturnAmount = $salesReturns->sum('amount');
        $totalReturnQty = $salesReturns->sum('quantity');
        $returnCount = $salesReturns->count();

        return view('transaksi.sales-return.index', compact('salesReturns', 'totalReturnAmount', 'totalReturnQty', 'returnCount'));
    }

    public function create(Request $request)
    {
        $saleId = $request->get('sale_id');

        if (!$saleId) {
            // Step 1: Select Sale (KasMasuk with products or category 'penjualan')
            $sales = KasMasuk::with(['product', 'category'])
                ->where(function($q) {
                    $q->whereNotNull('product_id')
                      ->orWhereHas('category', function($qc) {
                          $qc->where('transaction_type', 'penjualan');
                      });
                })
                ->orderBy('date', 'desc')
                ->get();

            return view('transaksi.sales-return.select-sale', compact('sales'));
        }

        // Step 2: Fill Return Details
        $sale = KasMasuk::with(['product', 'category'])->findOrFail($saleId);
        
        // Find existing returns for this sale to calculate remaining quantity
        $existingReturnsQty = SalesReturn::where('kas_masuk_id', $saleId)->sum('quantity');
        $maxQty = $sale->quantity - $existingReturnsQty;

        return view('transaksi.sales-return.create', compact('sale', 'maxQty'));
    }

    public function store(SalesReturnRequest $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validated();
            $saleId = $request->get('kas_masuk_id');
            $sale = KasMasuk::findOrFail($saleId);

            // Validation: Cannot return more than original quantity
            $existingReturnsQty = SalesReturn::where('kas_masuk_id', $saleId)->sum('quantity');
            $maxQty = $sale->quantity - $existingReturnsQty;

            if ($validated['quantity'] > $maxQty) {
                return back()->with('error', 'Jumlah retur melebihi sisa kuantitas penjualan (Maks: ' . $maxQty . ')')->withInput();
            }
            
            $now = Carbon::now();
            $validated['date'] = Carbon::parse($validated['date'])
                ->setHour($now->hour)
                ->setMinute($now->minute)
                ->setSecond($now->second);
            
            $validated['kas_masuk_id'] = $saleId;
            $validated['product_id'] = $sale->product_id;

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = 'SalesReturn_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                $filePath = $file->storeAs('transactions/sales-return', $fileName, 'public');
                $validated['file_path'] = $filePath;
            }

            SalesReturn::create($validated);

            DB::commit();
            return redirect()->route('sales-return.index')->with('success', 'Retur penjualan berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(SalesReturn $salesReturn)
    {
        $sale = $salesReturn->kasMasuk;
        
        // Calculate max quantity (original sale qty - other returns for this sale)
        $otherReturnsQty = SalesReturn::where('kas_masuk_id', $salesReturn->kas_masuk_id)
            ->where('id', '!=', $salesReturn->id)
            ->sum('quantity');
        $maxQty = $sale ? ($sale->quantity - $otherReturnsQty) : $salesReturn->quantity;

        return view('transaksi.sales-return.edit', compact('salesReturn', 'sale', 'maxQty'));
    }

    public function update(SalesReturnRequest $request, SalesReturn $salesReturn)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validated();
            $sale = $salesReturn->kasMasuk;

            if ($sale) {
                $otherReturnsQty = SalesReturn::where('kas_masuk_id', $salesReturn->kas_masuk_id)
                    ->where('id', '!=', $salesReturn->id)
                    ->sum('quantity');
                $maxQty = $sale->quantity - $otherReturnsQty;

                if ($validated['quantity'] > $maxQty) {
                    return back()->with('error', 'Jumlah retur melebihi sisa kuantitas penjualan (Maks: ' . $maxQty . ')')->withInput();
                }
            }
            
            $inputDate = Carbon::parse($validated['date']);
            if ($inputDate->isSameDay($salesReturn->date)) {
                $validated['date'] = $inputDate->setHour($salesReturn->date->hour)
                    ->setMinute($salesReturn->date->minute)
                    ->setSecond($salesReturn->date->second);
            } else {
                $now = Carbon::now();
                $validated['date'] = $inputDate->setHour($now->hour)
                    ->setMinute($now->minute)
                    ->setSecond($now->second);
            }

            if ($request->hasFile('file')) {
                if ($salesReturn->file_path) {
                    Storage::disk('public')->delete($salesReturn->file_path);
                }
                $file = $request->file('file');
                $fileName = 'SalesReturn_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                $filePath = $file->storeAs('transactions/sales-return', $fileName, 'public');
                $validated['file_path'] = $filePath;
            }

            $salesReturn->update($validated);

            DB::commit();
            return redirect()->route('sales-return.index')->with('success', 'Retur penjualan berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(SalesReturn $salesReturn)
    {
        DB::beginTransaction();
        try {
            if ($salesReturn->file_path) {
                Storage::disk('public')->delete($salesReturn->file_path);
            }
            $salesReturn->delete();
            DB::commit();
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Retur penjualan berhasil dihapus'
                ]);
            }
            
            return redirect()->route('sales-return.index')->with('success', 'Retur penjualan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}
