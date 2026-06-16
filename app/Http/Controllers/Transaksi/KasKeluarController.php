<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Http\Requests\KasKeluarRequest;
use App\Models\Category;
use App\Models\ChartOfAccount;
use App\Models\KasKeluar;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KasKeluarController extends Controller
{
    public function index()
    {
        $cashOuts = KasKeluar::with(['category', 'category.account', 'product'])->orderBy('id', 'desc')->get();
        $categories = Category::where('is_active', true)
            ->where('is_product', false)
            ->with('account')
            ->orderBy('name')->get();
        $accounts = ChartOfAccount::where('is_active', true)
            ->where(function ($query) {
                $query->where('type', '!=', 'revenue');
            })
            ->orderBy('code')->get();

        return view('transaksi-kas.kas_keluar_index', compact('cashOuts', 'categories', 'accounts'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)
            ->where('transaction_type', 'pembelian')
            ->with('account')
            ->orderBy('is_product', 'desc')
            ->orderBy('name')->get();
        
        // Ambil produk unik berdasarkan jenis kayu untuk pembelian bahan baku
        $products = Product::where('is_active', true)
            ->whereNotNull('wood_type')
            ->select('wood_type')
            ->distinct()
            ->orderBy('wood_type')
            ->get()
            ->map(function ($p) {
                // Cari satu produk representatif untuk ID (karena relasi transaksi butuh product_id)
                $representative = Product::where('wood_type', $p->wood_type)->first();
                $p->id = $representative->id;
                $p->name = $p->wood_type;
                return $p;
            });

        $chartOfAccounts = ChartOfAccount::where('is_active', true)->orderBy('code')->get();

        $cashAccounts = ChartOfAccount::where('is_active', true)
            ->where('type', 'asset')
            ->where(function($q) {
                $q->where('name', 'like', '%Kas%')
                  ->orWhere('name', 'like', '%Bank%');
            })
            ->orderBy('code')->get();

        return view('transaksi-produk.pembelian.create', compact('categories', 'products', 'chartOfAccounts', 'cashAccounts'));
    }

    public function edit(KasKeluar $kasKeluar)
    {
        $categories = Category::where('is_active', true)
            ->where('transaction_type', 'pembelian')
            ->with('account')
            ->orderBy('is_product', 'desc')
            ->orderBy('name')->get();
        $products = Product::where('is_active', true)
            ->orderBy('name')
            ->get()
            ->map(function ($product) {
                $product->syncStock();
                $product->calculated_stock = $product->current_stock;

                return $product;
            });
        $chartOfAccounts = ChartOfAccount::where('is_active', true)->orderBy('code')->get();

        $cashAccounts = ChartOfAccount::where('is_active', true)
            ->where('type', 'asset')
            ->where(function($q) {
                $q->where('name', 'like', '%Kas%')
                  ->orWhere('name', 'like', '%Bank%');
            })
            ->orderBy('code')->get();

        return view('transaksi-produk.pembelian.edit', compact('kasKeluar', 'categories', 'products', 'chartOfAccounts', 'cashAccounts'));
    }

    public function getCategoryItems(Request $request)
    {
        $categoryId = $request->get('category_id');
        $category = Category::find($categoryId);

        if (! $category) {
            return response()->json(['success' => false, 'message' => 'Kategori tidak ditemukan'], 404);
        }

        if ($category->is_product) {
            $items = Product::where('is_active', true)
                ->where('category_id', $categoryId)
                ->orderBy('name')
                ->get(['id', 'name as text', 'cost as cost', 'unit']);
        } else {
            $items = ChartOfAccount::where('is_active', true)
                ->orderBy('code')
                ->get(['id', 'code', 'name as text']);
        }

        return response()->json([
            'success' => true,
            'is_product' => $category->is_product,
            'items' => $items,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KasKeluarRequest $request)
    {
        \DB::beginTransaction();
        try {
            $validated = $request->validated();

            // Ensure numeric values
            $validated['amount'] = (float) $validated['amount'];
            $validated['quantity'] = ! empty($validated['quantity']) ? (int) round((float) $validated['quantity']) : 0;
            $validated['price'] = ! empty($validated['price']) ? (float) $validated['price'] : 0;
            $validated['category_id'] = ! empty($validated['category_id']) ? $validated['category_id'] : null;

            $now = \Carbon\Carbon::now();
            $validated['date'] = \Carbon\Carbon::parse($validated['date'])
                ->setHour($now->hour)
                ->setMinute($now->minute)
                ->setSecond($now->second);

            if ($request->hasFile('file')) {
                $category = Category::find($validated['category_id']);
                $isPembelian = ($category && $category->transaction_type === 'pembelian') || ! empty($validated['product_id']);
                $prefix = $isPembelian ? 'Pembelian' : 'KasKeluar';

                $file = $request->file('file');
                $fileName = $prefix.'_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                $filePath = $file->storeAs('transactions/kas-keluar', $fileName, 'public');
                $validated['file_path'] = $filePath;
            }

            if (!empty($request->hutan)) {
                $validated['hutan'] = $request->hutan;
            }

            KasKeluar::create($validated);

            \DB::commit();

            $category = Category::find($validated['category_id']);
            $isPembelian = ($category && $category->transaction_type === 'pembelian') || ! empty($validated['product_id']);
            $entityName = $isPembelian ? 'Pembelian' : 'Kas Keluar';

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => "$entityName berhasil ditambahkan"]);
            }

            $redirectRoute = $isPembelian ? 'transaksi.index' : 'cash.index';

            return redirect()->route($redirectRoute)->with('success', "$entityName berhasil ditambahkan");
        } catch (\Exception $e) {
            \DB::rollBack();
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal: '.$e->getMessage()], 500);
            }

            return back()->with('error', 'Gagal: '.$e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(KasKeluar $kasKeluar)
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $kasKeluar->id,
                    'date' => $kasKeluar->date->format('Y-m-d H:i:s'),
                    'category_id' => $kasKeluar->category_id,
                    'category_name' => $kasKeluar->category->name ?? 'N/A',
                    'description' => $kasKeluar->description,
                    'amount' => $kasKeluar->amount,
                    'file_path' => $kasKeluar->file_path,
                    'file_url' => $kasKeluar->file_path ? Storage::url($kasKeluar->file_path) : null,
                ],
            ]);
        }

        return view('transaksi-produk.pembelian.show', compact('kasKeluar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KasKeluarRequest $request, KasKeluar $kasKeluar)
    {
        \DB::beginTransaction();
        try {
            $validated = $request->validated();

            // Ensure numeric values
            $validated['amount'] = (float) $validated['amount'];
            $validated['quantity'] = ! empty($validated['quantity']) ? (int) round((float) $validated['quantity']) : 0;
            $validated['price'] = ! empty($validated['price']) ? (float) $validated['price'] : 0;
            $validated['category_id'] = ! empty($validated['category_id']) ? $validated['category_id'] : null;

            $inputDate = \Carbon\Carbon::parse($validated['date']);
            if ($inputDate->isSameDay($kasKeluar->date)) {
                // If same day, keep original time to maintain order
                $validated['date'] = $inputDate->setHour($kasKeluar->date->hour)
                    ->setMinute($kasKeluar->date->minute)
                    ->setSecond($kasKeluar->date->second);
            } else {
                // If different day, use current time
                $now = \Carbon\Carbon::now();
                $validated['date'] = $inputDate->setHour($now->hour)
                    ->setMinute($now->minute)
                    ->setSecond($now->second);
            }

            if ($request->hasFile('file')) {
                if ($kasKeluar->file_path) {
                    Storage::disk('public')->delete($kasKeluar->file_path);
                }

                $category = Category::find($validated['category_id']);
                $isPembelian = ($category && $category->transaction_type === 'pembelian') || ! empty($validated['product_id']);
                $prefix = $isPembelian ? 'Pembelian' : 'KasKeluar';

                $file = $request->file('file');
                $fileName = $prefix.'_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                $filePath = $file->storeAs('transactions/kas-keluar', $fileName, 'public');
                $validated['file_path'] = $filePath;
            }

            if (!empty($request->hutan)) {
                $validated['hutan'] = $request->hutan;
            }

            $kasKeluar->update($validated);

            \DB::commit();

            $category = Category::find($validated['category_id']);
            $isPembelian = ($category && $category->transaction_type === 'pembelian') || ! empty($validated['product_id']);
            $entityName = $isPembelian ? 'Pembelian' : 'Kas Keluar';

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => "$entityName berhasil diperbarui"]);
            }

            $redirectRoute = $isPembelian ? 'transaksi.index' : 'cash.index';

            return redirect()->route($redirectRoute)->with('success', "$entityName berhasil diperbarui");
        } catch (\Exception $e) {
            \DB::rollBack();
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal: '.$e->getMessage()], 500);
            }

            return back()->with('error', 'Gagal: '.$e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KasKeluar $kasKeluar)
    {
        \DB::beginTransaction();
        try {
            if ($kasKeluar->file_path) {
                Storage::disk('public')->delete($kasKeluar->file_path);
            }

            $isPembelian = ($kasKeluar->category && $kasKeluar->category->transaction_type === 'pembelian') || ! empty($kasKeluar->product_id);
            $entityName = $isPembelian ? 'Pembelian' : 'Kas Keluar';

            $kasKeluar->delete();

            \DB::commit();

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['success' => true, 'message' => "$entityName berhasil dihapus"]);
            }

            return redirect()->route('transaksi.index')->with('success', "$entityName berhasil dihapus");
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Gagal: '.$e->getMessage()], 500);
            }

            return back()->with('error', 'Gagal: '.$e->getMessage());
        }
    }
}
