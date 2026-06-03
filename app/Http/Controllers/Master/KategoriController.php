<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChartOfAccount;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        // Get all active categories in a single list
        $categories = Category::where('is_active', true)
            ->with('account')
            ->orderBy('name')
            ->paginate(15);

        return view('master.categories', compact('categories'));
    }

    public function create()
    {
        // Get all master accounts for form
        $allAccounts = ChartOfAccount::where('is_active', true)
            ->orderBy('type')
            ->orderBy('code')
            ->get();

        return view('master.categories.create', compact('allAccounts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:cash_in,cash_out',
            'account_id' => 'nullable|exists:akun_coa,id',
        ]);

        // Auto-generate code for category - using numeric sort
        $lastCategory = Category::orderByRaw('CAST(code AS UNSIGNED) DESC')->first();
        if ($lastCategory) {
            $lastCode = intval($lastCategory->code);
            $newCode = strval($lastCode + 1);
        } else {
            $newCode = '1000';
        }

        Category::create([
            'code' => $newCode,
            'name' => $validated['name'],
            'type' => $validated['type'],
            'account_id' => $validated['account_id'],
            'is_active' => true,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Kategori berhasil ditambahkan']);
        }

        return redirect()->route('master.categories')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $allAccounts = ChartOfAccount::where('is_active', true)
            ->orderBy('type')
            ->orderBy('code')
            ->get();

        return view('master.categories.edit', compact('category', 'allAccounts'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:cash_in,cash_out',
            'account_id' => 'nullable|exists:akun_coa,id',
        ]);

        try {
            $category = Category::findOrFail($id);
            $category->update([
                'name' => $validated['name'],
                'type' => $validated['type'],
                'account_id' => $validated['account_id'],
            ]);

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Kategori berhasil diperbarui']);
            }

            return redirect()->route('master.categories')->with('success', 'Kategori berhasil diperbarui');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal memperbarui kategori'], 500);
            }

            return back()->with('error', 'Gagal memperbarui kategori')->withInput();
        }
    }

    public function getCategoriesByType($type)
    {
        $coaType = $type === 'cash_in' ? 'revenue' : 'expense';
        $categories = ChartOfAccount::where('type', $coaType)->where('is_active', true)->get();

        return response()->json($categories);
    }

    public function destroy($id)
    {
        try {
            Category::findOrFail($id)->delete();

            return response()->json(['success' => true, 'message' => 'Kategori berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus kategori'], 500);
        }
    }

    public function destroyBulk(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'Pilih minimal satu kategori untuk dihapus'], 400);
        }

        try {
            Category::whereIn('id', $ids)->delete();

            return response()->json(['success' => true, 'message' => count($ids).' kategori berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus kategori terpilih'], 500);
        }
    }
}
