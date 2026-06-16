<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Http\Requests\KasMasukRequest;
use App\Models\Category;
use App\Models\ChartOfAccount;
use App\Models\KasMasuk;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KasMasukController extends Controller
{
    public function index()
    {
        $cashIns = KasMasuk::with(['category', 'category.account', 'product'])->orderBy('id', 'desc')->get();
        $categories = Category::where('is_active', true)
            ->where('is_product', false)
            ->with('account')
            ->orderBy('name')->get();
        $accounts = ChartOfAccount::where('is_active', true)
            ->where(function ($query) {
                $query->where('type', '!=', 'expense');
            })
            ->orderBy('code')->get();

        return view('transaksi-kas.kas_masuk_index', compact('cashIns', 'categories', 'accounts'));
    }

    public function create(Request $request)
    {
        $categories = Category::where('is_active', true)
            ->where('transaction_type', 'penjualan')
            ->with('account')
            ->orderBy('is_product', 'desc')
            ->orderBy('name')->get();
        $products = Product::where('is_active', true)
            ->orderBy('name')
            ->get()
            ->groupBy(function($p) {
                return $p->wood_type . '|' . $p->product_category . '|' . $p->size;
            })
            ->map(function ($group) {
                $first = $group->first();
                $totalStock = $group->sum(function($p) {
                    $p->syncStock();
                    return $p->current_stock;
                });
                
                $first->calculated_stock = $totalStock;
                return $first;
            })
            ->values();
        $chartOfAccounts = ChartOfAccount::where('is_active', true)->orderBy('code')->get();
        
        $cashAccounts = ChartOfAccount::where('is_active', true)
            ->where('type', 'asset')
            ->where(function($q) {
                $q->where('name', 'like', '%Kas%')
                  ->orWhere('name', 'like', '%Bank%');
            })
            ->orderBy('code')->get();

        $selectedProductId = $request->get('product_id');

        return view('transaksi-produk.penjualan.create', compact('categories', 'products', 'chartOfAccounts', 'selectedProductId', 'cashAccounts'));
    }

    public function edit(KasMasuk $kasMasuk)
    {
        $categories = Category::where('is_active', true)
            ->where('transaction_type', 'penjualan')
            ->with('account')
            ->orderBy('is_product', 'desc')
            ->orderBy('name')->get();
        $products = Product::where('is_active', true)
            ->orderBy('name')
            ->get()
            ->groupBy(function($p) {
                return $p->wood_type . '|' . $p->product_category . '|' . $p->size;
            })
            ->map(function ($group) {
                $first = $group->first();
                $totalStock = $group->sum(function($p) {
                    $p->syncStock();
                    return $p->current_stock;
                });
                
                $first->calculated_stock = $totalStock;
                return $first;
            })
            ->values();
        $chartOfAccounts = ChartOfAccount::where('is_active', true)->orderBy('code')->get();

        $cashAccounts = ChartOfAccount::where('is_active', true)
            ->where('type', 'asset')
            ->where(function($q) {
                $q->where('name', 'like', '%Kas%')
                  ->orWhere('name', 'like', '%Bank%');
            })
            ->orderBy('code')->get();

        return view('transaksi-produk.penjualan.edit', compact('kasMasuk', 'categories', 'products', 'chartOfAccounts', 'cashAccounts'));
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
                ->get(['id', 'name as text', 'price as price', 'unit']);
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
    public function store(KasMasukRequest $request)
    {
        \DB::beginTransaction();
        try {
            $validated = $request->validated();

            // Ensure numeric values
            $validated['amount'] = (float) $validated['amount'];
            $validated['quantity'] = ! empty($validated['quantity']) ? (int) round((float) $validated['quantity']) : 0;
            $validated['price'] = ! empty($validated['price']) ? (float) $validated['price'] : 0;
            $validated['category_id'] = ! empty($validated['category_id']) ? $validated['category_id'] : null;

            // Validasi stok jika transaksi melibatkan produk
            if (!empty($validated['product_id']) && $validated['quantity'] > 0) {
                $product = Product::find($validated['product_id']);
                if ($product) {
                    $product->syncStock();
                    if ($validated['quantity'] > $product->stock) {
                        \DB::rollBack();
                        $msg = "Stok tidak cukup. Sisa stok: {$product->stock} {$product->unit}, diminta: {$validated['quantity']} {$product->unit}.";
                        if ($request->ajax()) {
                            return response()->json(['success' => false, 'message' => $msg], 422);
                        }
                        return back()->with('error', $msg)->withInput();
                    }
                }
            }

            $now = \Carbon\Carbon::now();
            $validated['date'] = \Carbon\Carbon::parse($validated['date'])
                ->setHour($now->hour)
                ->setMinute($now->minute)
                ->setSecond($now->second);

            if ($request->hasFile('file')) {
                $category = Category::find($validated['category_id']);
                $isPenjualan = ($category && $category->transaction_type === 'penjualan') || ! empty($validated['product_id']);
                $prefix = $isPenjualan ? 'Penjualan' : 'KasMasuk';

                $file = $request->file('file');
                $fileName = $prefix.'_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                $filePath = $file->storeAs('transactions/kas-masuk', $fileName, 'public');
                $validated['file_path'] = $filePath;
            }

            KasMasuk::create($validated);

            \DB::commit();

            $category = Category::find($validated['category_id']);
            $isPenjualan = ($category && $category->transaction_type === 'penjualan') || ! empty($validated['product_id']);
            $entityName = $isPenjualan ? 'Penjualan' : 'Kas Masuk';

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => "$entityName berhasil ditambahkan"]);
            }

            $redirectRoute = $isPenjualan ? 'transaksi.index' : 'cash.index';

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
    public function show(KasMasuk $kasMasuk)
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $kasMasuk->id,
                    'date' => $kasMasuk->date->format('Y-m-d H:i:s'),
                    'category_id' => $kasMasuk->category_id,
                    'category_name' => $kasMasuk->category->name ?? 'N/A',
                    'description' => $kasMasuk->description,
                    'amount' => $kasMasuk->amount,
                    'file_path' => $kasMasuk->file_path,
                    'file_url' => $kasMasuk->file_path ? Storage::url($kasMasuk->file_path) : null,
                ],
            ]);
        }

        return view('transaksi-produk.penjualan.show', compact('kasMasuk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KasMasukRequest $request, KasMasuk $kasMasuk)
    {
        \DB::beginTransaction();
        try {
            $validated = $request->validated();

            // Ensure numeric values
            $validated['amount'] = (float) $validated['amount'];
            $validated['quantity'] = ! empty($validated['quantity']) ? (int) round((float) $validated['quantity']) : 0;
            $validated['price'] = ! empty($validated['price']) ? (float) $validated['price'] : 0;
            $validated['category_id'] = ! empty($validated['category_id']) ? $validated['category_id'] : null;

            // Validasi stok jika transaksi melibatkan produk
            if (!empty($validated['product_id']) && $validated['quantity'] > 0) {
                $product = Product::find($validated['product_id']);
                if ($product) {
                    $product->syncStock();
                    // Stok tersedia = stok sekarang + qty lama (karena kita update, qty lama dikembalikan dulu)
                    $oldQty = $kasMasuk->product_id == $validated['product_id'] ? $kasMasuk->quantity : 0;
                    $availableStock = $product->stock + $oldQty;
                    if ($validated['quantity'] > $availableStock) {
                        \DB::rollBack();
                        $msg = "Stok tidak cukup. Stok tersedia: {$availableStock} {$product->unit}, diminta: {$validated['quantity']} {$product->unit}.";
                        if ($request->ajax()) {
                            return response()->json(['success' => false, 'message' => $msg], 422);
                        }
                        return back()->with('error', $msg)->withInput();
                    }
                }
            }

            $inputDate = \Carbon\Carbon::parse($validated['date']);
            if ($inputDate->isSameDay($kasMasuk->date)) {
                // If same day, keep original time to maintain order
                $validated['date'] = $inputDate->setHour($kasMasuk->date->hour)
                    ->setMinute($kasMasuk->date->minute)
                    ->setSecond($kasMasuk->date->second);
            } else {
                // If different day, use current time
                $now = \Carbon\Carbon::now();
                $validated['date'] = $inputDate->setHour($now->hour)
                    ->setMinute($now->minute)
                    ->setSecond($now->second);
            }

            if ($request->hasFile('file')) {
                if ($kasMasuk->file_path) {
                    Storage::disk('public')->delete($kasMasuk->file_path);
                }

                $category = Category::find($validated['category_id']);
                $isPenjualan = ($category && $category->transaction_type === 'penjualan') || ! empty($validated['product_id']);
                $prefix = $isPenjualan ? 'Penjualan' : 'KasMasuk';

                $file = $request->file('file');
                $fileName = $prefix.'_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                $filePath = $file->storeAs('transactions/kas-masuk', $fileName, 'public');
                $validated['file_path'] = $filePath;
            }

            $kasMasuk->update($validated);

            \DB::commit();

            $category = Category::find($validated['category_id']);
            $isPenjualan = ($category && $category->transaction_type === 'penjualan') || ! empty($validated['product_id']);
            $entityName = $isPenjualan ? 'Penjualan' : 'Kas Masuk';

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => "$entityName berhasil diperbarui"]);
            }

            $redirectRoute = $isPenjualan ? 'transaksi.index' : 'cash.index';

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
    public function destroy(KasMasuk $kasMasuk)
    {
        \DB::beginTransaction();
        try {
            // Cek apakah ada retur penjualan yang terkait
            $returCount = \App\Models\SalesReturn::where('kas_masuk_id', $kasMasuk->id)->count();
            if ($returCount > 0) {
                if (request()->ajax() || request()->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => "Transaksi tidak dapat dihapus karena masih memiliki {$returCount} data retur penjualan. Hapus retur terlebih dahulu."
                    ], 422);
                }
                return back()->with('error', "Transaksi tidak dapat dihapus karena masih memiliki {$returCount} data retur penjualan. Hapus retur terlebih dahulu.");
            }
            if ($kasMasuk->file_path) {
                Storage::disk('public')->delete($kasMasuk->file_path);
            }

            $isPenjualan = ($kasMasuk->category && $kasMasuk->category->transaction_type === 'penjualan') || ! empty($kasMasuk->product_id);
            $entityName = $isPenjualan ? 'Penjualan' : 'Kas Masuk';

            $kasMasuk->delete();

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
