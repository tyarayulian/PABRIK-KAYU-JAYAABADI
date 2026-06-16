<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ChartOfAccount;
use App\Models\ProductStock;
use App\Http\Requests\Master\ProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $products = Product::with(['salesAccount', 'hppAccount', 'inventoryAccount', 'stockHistory', 'salesTransactions', 'purchaseTransactions'])
            ->orderBy('wood_type')
            ->orderBy('product_category')
            ->orderBy('size')
            ->get();
            
        foreach ($products as $product) {
            $product->syncStock();
        }

        // Grouping for the UI - Only show products with wood_type
        $groupedProducts = $products->whereNotNull('wood_type')->where('wood_type', '!=', '')->groupBy('wood_type')->map(function ($woodGroup) {
            return $woodGroup->groupBy(function($item) {
                return $item->product_category ?: 'Umum';
            });
        });

        return view('master.produk-dan-stok.index', [
            'groupedProducts' => $groupedProducts,
            'products' => $products,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
    }

    public function create()
    {
        return view('master.produk-dan-stok.produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'wood_type' => 'required|string|max:100',
            'products' => 'required|array',
            'products.*.category' => 'required|string',
            'products.*.items' => 'required|array',
            'products.*.items.*.size' => 'required|string',
            'products.*.items.*.cubic_content' => 'nullable|integer',
            'products.*.items.*.cost' => 'required',
            'products.*.items.*.stock' => 'nullable|numeric',
        ]);

        $salesAccount = ChartOfAccount::where('code', '4100')->first();
        $hppAccount = ChartOfAccount::where('code', '5100')->first();
        $inventoryAccount = ChartOfAccount::where('code', '1105')->first() 
            ?? ChartOfAccount::where('name', 'like', '%Bahan Baku%')->where('type', 'asset')->first()
            ?? ChartOfAccount::where('code', '1200')->first() 
            ?? ChartOfAccount::where('type', 'asset')->first();
        $finishedGoodsAccount = ChartOfAccount::where('code', '1130')->first()
            ?? ChartOfAccount::where('name', 'like', '%Produk Jadi%')->where('type', 'asset')->first()
            ?? $inventoryAccount;

        \DB::beginTransaction();
        try {
            foreach ($request->products as $categoryData) {
                $category = $categoryData['category'];
                
                foreach ($categoryData['items'] as $item) {
                    $hpp = (int) str_replace(['Rp', '.', ' '], '', $item['cost']);
                    $stokBaru = (float) ($item['stock'] ?? 0);
                    
                    $woodType = $request->wood_type;
                    $size = $item['size'];
                    
                    // Cek apakah produk dengan spesifikasi ini sudah ada
                    $product = Product::where('wood_type', $woodType)
                        ->where('product_category', $category)
                        ->where('size', $size)
                        ->first();

                    if ($product) {
                        // Jika sudah ada, tambahkan sebagai history stok (Stok Masuk)
                        if ($stokBaru > 0) {
                            ProductStock::create([
                                'product_id' => $product->id,
                                'date' => now(),
                                'quantity' => $stokBaru,
                                'price' => $hpp,
                                'description' => 'Stok Masuk',
                            ]);
                        }
                    } else {
                        // Jika belum ada, buat produk baru (ini akan jadi Stok Awal)
                        $fullName = "Kayu {$woodType} {$category} {$size}";
                        Product::create([
                            'name' => $fullName,
                            'wood_type' => $woodType,
                            'product_category' => $category,
                            'size' => $size,
                            'cubic_content' => $item['cubic_content'],
                            'unit' => 'kubik',
                            'cost' => $hpp,
                            'stock' => $stokBaru,
                            'initial_stock' => $stokBaru,
                            'sales_account_id' => $salesAccount->id ?? null,
                            'hpp_account_id' => $hppAccount->id ?? null,
                            'inventory_account_id' => $inventoryAccount->id,
                            'finished_goods_account_id' => $finishedGoodsAccount->id ?? null,
                            'is_active' => true,
                        ]);
                    }
                }
            }

            \DB::commit();
            return redirect()->route('master.products.index')->with('success', 'Produk berhasil ditambahkan secara massal');
        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan produk: ' . $e->getMessage());
        }
    }

    public function edit(Product $product)
    {
        return view('master.produk-dan-stok.produk.edit', compact('product'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        $salesAccount = ChartOfAccount::where('code', '4100')->first();
        $hppAccount = ChartOfAccount::where('code', '5100')->first();
        $inventoryAccount = ChartOfAccount::where('code', '1200')->first() ?? ChartOfAccount::where('type', 'asset')->first();

        $oldWoodType = $product->wood_type;
        $newWoodType = $validated['wood_type'];

        \DB::beginTransaction();
        try {
            // Update semua produk dalam wood_type ini
            foreach ($request->products as $categoryData) {
                $categoryName = $categoryData['category'];

                // Skip kategori yang tidak punya items (panel tidak aktif/dicentang)
                if (empty($categoryData['items'])) {
                    continue;
                }

                foreach ($categoryData['items'] as $item) {
                    // Skip baris kosong
                    if (empty($item['size'])) {
                        continue;
                    }

                    $productId = $item['product_id'] ?? null;

                    if ($productId) {
                        // Update produk existing
                        $p = Product::find($productId);
                        if ($p) {
                            $prefix = str_starts_with(strtolower($newWoodType), 'kayu') ? '' : 'Kayu ';
                            $newName = $prefix . $newWoodType . ' ' . $categoryName . ' ' . $item['size'];
                            $p->update([
                                'name'             => $newName,
                                'wood_type'        => $newWoodType,
                                'product_category' => $categoryName,
                                'size'             => $item['size'],
                                'cubic_content'    => $item['cubic_content'] ?? null,
                                'unit'             => $p->unit,
                                'sales_account_id' => $salesAccount->id ?? $p->sales_account_id,
                                'hpp_account_id'   => $hppAccount->id ?? $p->hpp_account_id,
                                'inventory_account_id' => $inventoryAccount->id ?? $p->inventory_account_id,
                            ]);
                            $p->syncStock();
                        }
                    } else {
                        // Produk baru yang ditambah dari form edit
                        $prefix = str_starts_with(strtolower($newWoodType), 'kayu') ? '' : 'Kayu ';
                        $newName = $prefix . $newWoodType . ' ' . $categoryName . ' ' . $item['size'];
                        Product::create([
                            'name'             => $newName,
                            'wood_type'        => $newWoodType,
                            'product_category' => $categoryName,
                            'size'             => $item['size'],
                            'cubic_content'    => $item['cubic_content'] ?? null,
                            'unit'             => 'kubik',
                            'cost'             => $product->cost,
                            'stock'            => 0,
                            'initial_stock'    => 0,
                            'sales_account_id' => $salesAccount->id ?? null,
                            'hpp_account_id'   => $hppAccount->id ?? null,
                            'inventory_account_id' => $inventoryAccount->id ?? null,
                            'is_active'        => true,
                        ]);
                    }
                }
            }

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }

        return redirect()->route('master.products.index', [
            'wood' => \Str::slug($newWoodType ?: 'lain-lain'),
        ])->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(Product $product)
    {
        // Check if product is used in any transactions
        $usedInKasMasuk = \App\Models\KasMasuk::where('product_id', $product->id)->exists();
        $usedInKasKeluar = \App\Models\KasKeluar::where('product_id', $product->id)->exists();
        $usedInSalesReturn = \App\Models\SalesReturn::where('product_id', $product->id)->exists();
        
        if ($usedInKasMasuk || $usedInKasKeluar || $usedInSalesReturn) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak dapat dihapus karena masih digunakan dalam transaksi'
                ], 400);
            }
            
            return redirect()->route('master.products.index')
                ->with('error', 'Produk tidak dapat dihapus karena masih digunakan dalam transaksi');
        }
        
        $wood = $product->wood_type;
        $cat = $product->product_category;
        $product->delete();
        
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dihapus'
            ]);
        }
        
        return redirect()->route('master.products.index', [
            'wood' => \Str::slug($wood ?: 'lain-lain'),
            'cat' => \Str::slug(($wood ?: 'lain-lain') . '-' . ($cat ?: 'umum')),
        ])->with('success', 'Produk berhasil dihapus');
    }

    public function addStock(Product $product)
    {
        return view('master.produk-dan-stok.stok.create', compact('product'));
    }

    public function storeStock(Request $request, Product $product)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'date'        => 'required|date',
            'quantity'    => 'required',
            'price'       => 'required',
        ]);

        $price = (float) preg_replace('/[^0-9]/', '', $request->price);
        $quantity = (float) str_replace(',', '.', $request->quantity);
        
        \DB::beginTransaction();
        try {
            ProductStock::create([
                'product_id'  => $product->id,
                'date'        => $request->date,
                'quantity'    => $quantity,
                'price'       => $price,
                'description' => $request->description,
            ]);

            // Update cost produk sesuai HPP yang diinput agar jurnal sinkron
            if ($price > 0) {
                $product->update(['cost' => $price]);
            }

            $product->syncStock();
            \DB::commit();
            return redirect()->route('master.products.index', [
                'wood' => \Str::slug($product->wood_type ?: 'lain-lain'),
                'cat' => \Str::slug(($product->wood_type ?: 'lain-lain') . '-' . ($product->product_category ?: 'umum')),
                'scroll_to' => 'product-' . $product->id
            ])->with('success', 'Stok berhasil ditambahkan');
        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->with('error', 'Gagal menambahkan stok: ' . $e->getMessage());
        }
    }

    public function editInitialStock(Product $product)
    {
        return view('master.produk-dan-stok.stok.edit-initial', compact('product'));
    }

    public function updateInitialStock(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:0',
            'price'    => 'required',
        ]);

        $price    = (float) preg_replace('/[^0-9]/', '', $request->price);
        $quantity = (float) str_replace(',', '.', $request->quantity);

        \DB::beginTransaction();
        try {
            $product->update([
                'initial_stock' => $quantity,
                'cost'          => $price,
            ]);
            $product->syncStock();
            \DB::commit();

            return redirect()->route('master.products.index', [
                'wood'      => \Str::slug($product->wood_type ?: 'lain-lain'),
                'cat'       => \Str::slug(($product->wood_type ?: 'lain-lain') . '-' . ($product->product_category ?: 'umum')),
                'scroll_to' => 'product-' . $product->id,
            ])->with('success', 'Stok awal berhasil diperbarui');
        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->with('error', 'Gagal memperbarui stok awal: ' . $e->getMessage());
        }
    }

    public function editStock($id)
    {
        $stock = ProductStock::findOrFail($id);
        $product = $stock->product;
        return view('master.produk-dan-stok.stok.edit', compact('stock', 'product'));
    }

    public function updateStock(Request $request, $id)
    {
        $stock = ProductStock::findOrFail($id);
        $request->validate([
            'description' => 'required|string|max:255',
            'date'        => 'required|date',
            'quantity'    => 'required',
            'price'       => 'required',
        ]);

        $price = (float) preg_replace('/[^0-9]/', '', $request->price);
        $quantity = (float) str_replace(',', '.', $request->quantity);

        \DB::beginTransaction();
        try {
            $stock->update([
                'date'        => $request->date,
                'quantity'    => $quantity,
                'price'       => $price,
                'description' => $request->description,
            ]);

            $product = $stock->product;

            // Update products.cost dari HPP stok terbaru agar jurnal sinkron
            $latestStockPrice = \App\Models\ProductStock::where('product_id', $product->id)
                ->where('price', '>', 0)
                ->orderBy('id', 'desc')
                ->value('price');
            if ($latestStockPrice && $latestStockPrice != $product->cost) {
                $product->update(['cost' => $latestStockPrice]);
            }

            $product->syncStock();

            \DB::commit();
            return redirect()->route('master.products.index', [
                'wood' => \Str::slug($product->wood_type ?: 'lain-lain'),
                'cat' => \Str::slug(($product->wood_type ?: 'lain-lain') . '-' . ($product->product_category ?: 'umum')),
                'scroll_to' => 'product-' . $product->id
            ])->with('success', 'History stok berhasil diperbarui');
        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->with('error', 'Gagal memperbarui stok: ' . $e->getMessage());
        }
    }

    public function destroyStock($id)
    {
        $stock = ProductStock::findOrFail($id);
        $product = $stock->product;

        // Cek apakah produk ini masih digunakan di transaksi
        $usedInKasMasuk    = \App\Models\KasMasuk::where('product_id', $product->id)->exists();
        $usedInKasKeluar   = \App\Models\KasKeluar::where('product_id', $product->id)->exists();
        $usedInSalesReturn = \App\Models\SalesReturn::where('product_id', $product->id)->exists();

        if ($usedInKasMasuk || $usedInKasKeluar || $usedInSalesReturn) {
            $usedIn = collect([
                $usedInKasMasuk    ? 'transaksi penjualan' : null,
                $usedInKasKeluar   ? 'transaksi pembelian' : null,
                $usedInSalesReturn ? 'retur penjualan'     : null,
            ])->filter()->implode(', ');

            $message = "Produk \"$product->name\" masih dipakai di $usedIn, tidak bisa dihapus.";

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => $message], 400);
            }
            return back()->with('error', $message);
        }

        \DB::beginTransaction();
        try {
            $stock->delete();
            $product->syncStock();
            \DB::commit();

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'History stok berhasil dihapus']);
            }

            return redirect()->route('master.products.index', [
                'wood' => \Str::slug($product->wood_type ?: 'lain-lain'),
                'cat'  => \Str::slug(($product->wood_type ?: 'lain-lain') . '-' . ($product->product_category ?: 'umum')),
            ])->with('success', 'History stok berhasil dihapus');
        } catch (\Exception $e) {
            \DB::rollBack();

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Gagal menghapus stok: ' . $e->getMessage()], 500);
            }

            return back()->with('error', 'Gagal menghapus stok: ' . $e->getMessage());
        }
    }
}
