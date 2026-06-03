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
    public function menu()
    {
        $products = Product::orderBy('wood_type')->orderBy('product_category')->orderBy('size')->get();
        
        $menuData = $products->groupBy('wood_type')->map(function ($woodGroup, $woodType) {
            return [
                'wood_type' => $woodType ?: 'LAIN-LAIN',
                'categories' => $woodGroup->groupBy('product_category')->map(function ($catGroup, $catName) {
                    return [
                        'name' => strtoupper($catName ?: 'UMUM'),
                        'price' => $catGroup->first()->cost ?? 0,
                        'items' => $catGroup->groupBy('size')->map(function ($sizeGroup, $size) {
                            $p = $sizeGroup->first();
                            return [
                                'size' => $size ?: $p->name,
                                'quantity' => $p->cubic_content ?: 0,
                                'unit' => strtoupper($p->unit)
                            ];
                        })->values()
                    ];
                })->values()
            ];
        })->values();

        return view('master.products.menu', compact('menuData'));
    }

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

        return view('master.products.index', [
            'groupedProducts' => $groupedProducts,
            'products' => $products,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
    }

    public function create()
    {
        return view('master.products.create');
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
        $inventoryAccount = ChartOfAccount::where('code', '1200')->first() ?? ChartOfAccount::where('type', 'asset')->first();

        if (!$inventoryAccount) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Akun inventory belum dikonfigurasi.']);
        }

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
        return view('master.products.edit', compact('product'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        $salesAccount = ChartOfAccount::where('code', '4100')->first();
        $hppAccount = ChartOfAccount::where('code', '5100')->first();
        $inventoryAccount = ChartOfAccount::where('code', '1200')->first() ?? ChartOfAccount::where('type', 'asset')->first();

        $product->update([
            'name' => $validated['name'],
            'wood_type' => $validated['wood_type'],
            'product_category' => $validated['product_category'],
            'size' => $validated['size'],
            'cubic_content' => $validated['cubic_content'],
            'unit' => $validated['unit'],
            'cost' => $validated['cost'],
            'initial_stock' => $validated['stock'] ?? 0,
            'sales_account_id' => $salesAccount->id ?? null,
            'hpp_account_id' => $hppAccount->id ?? null,
            'inventory_account_id' => $inventoryAccount->id,
        ]);

        $product->syncStock();

        return redirect()->route('master.products.index', [
            'wood' => \Str::slug($product->wood_type ?: 'lain-lain'),
            'cat' => \Str::slug(($product->wood_type ?: 'lain-lain') . '-' . ($product->product_category ?: 'umum')),
            'scroll_to' => 'product-' . $product->id
        ])->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(Product $product)
    {
        $wood = $product->wood_type;
        $cat = $product->product_category;
        $product->delete();
        
        return redirect()->route('master.products.index', [
            'wood' => \Str::slug($wood ?: 'lain-lain'),
            'cat' => \Str::slug(($wood ?: 'lain-lain') . '-' . ($cat ?: 'umum')),
        ])->with('success', 'Produk berhasil dihapus');
    }

    public function addStock(Product $product)
    {
        return view('master.products.stock_create', compact('product'));
    }

    public function storeStock(Request $request, Product $product)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'quantity' => 'required',
            'price' => 'required',
        ]);

        $price = (float) preg_replace('/[^0-9]/', '', $request->price);
        $quantity = (float) str_replace(',', '.', $request->quantity);
        
        \DB::beginTransaction();
        try {
            ProductStock::create([
                'product_id' => $product->id,
                'date' => now(),
                'quantity' => $quantity,
                'price' => $price,
                'description' => $request->description,
            ]);

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

    public function editStock($id)
    {
        $stock = ProductStock::findOrFail($id);
        $product = $stock->product;
        return view('master.products.stock_edit', compact('stock', 'product'));
    }

    public function updateStock(Request $request, $id)
    {
        $stock = ProductStock::findOrFail($id);
        $request->validate([
            'description' => 'required|string|max:255',
            'quantity' => 'required',
            'price' => 'required',
        ]);

        $price = (float) preg_replace('/[^0-9]/', '', $request->price);
        $quantity = (float) str_replace(',', '.', $request->quantity);

        \DB::beginTransaction();
        try {
            $stock->update([
                'quantity' => $quantity,
                'price' => $price,
                'description' => $request->description,
            ]);

            $product = $stock->product;
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
        \DB::beginTransaction();
        try {
            $stock->delete();
            $product->syncStock();
            \DB::commit();
            return redirect()->route('master.products.index', [
                'wood' => \Str::slug($product->wood_type ?: 'lain-lain'),
                'cat' => \Str::slug(($product->wood_type ?: 'lain-lain') . '-' . ($product->product_category ?: 'umum')),
            ])->with('success', 'History stok berhasil dihapus');
        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->with('error', 'Gagal menghapus stok: ' . $e->getMessage());
        }
    }
}
