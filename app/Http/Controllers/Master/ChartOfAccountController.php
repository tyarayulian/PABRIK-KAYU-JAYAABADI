<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChartOfAccount;
use App\Models\GeneralJournal;
use App\Models\GeneralLedger;
use Illuminate\Http\Request;

class ChartOfAccountController extends Controller
{
    public function index()
    {
        $accounts = ChartOfAccount::orderBy('code')->get();

        return view('master.accounts', compact('accounts'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'code' => 'required|unique:akun_coa,code',
                'name' => 'required|string',
                'type' => 'required|in:asset,liability,equity,revenue,expense',
            ]);

            ChartOfAccount::create([
                'code' => $validated['code'],
                'name' => $validated['name'],
                'type' => $validated['type'],
                'is_active' => true,
            ]);

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Akun berhasil ditambahkan']);
            }

            return redirect()->route('master.accounts')->with('success', 'Akun berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ada kesalahan validasi',
                    'errors' => $e->errors(),
                ], 422);
            }
            throw $e;
        }
    }

    public function update(Request $request, ChartOfAccount $account)
    {
        try {
            $validated = $request->validate([
                'code' => 'required|unique:akun_coa,code,'.$account->id,
                'name' => 'required|string',
                'type' => 'required|in:asset,liability,equity,revenue,expense',
            ]);

            $account->update([
                'code' => $validated['code'],
                'name' => $validated['name'],
                'type' => $validated['type'],
            ]);

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Akun berhasil diperbarui']);
            }

            return redirect()->route('master.accounts')->with('success', 'Akun berhasil diperbarui');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ada kesalahan validasi',
                    'errors' => $e->errors(),
                ], 422);
            }
            throw $e;
        }
    }

    public function destroy(ChartOfAccount $account)
    {
        if ($this->isAccountInUse($account->id)) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Akun tidak dapat dihapus karena sudah memiliki transaksi']);
            }

            return redirect()->route('master.accounts')->with('error', 'Akun tidak dapat dihapus karena sudah memiliki transaksi');
        }

        \DB::beginTransaction();
        try {
            // Unlink from categories
            Category::where('account_id', $account->id)->update(['account_id' => null]);

            // Delete ledger record if exists
            GeneralLedger::where('account_id', $account->id)->delete();

            $account->delete();
            \DB::commit();

            if (request()->ajax()) {
                return response()->json(['success' => true, 'message' => 'Akun berhasil dihapus']);
            }

            return redirect()->route('master.accounts')->with('success', 'Akun berhasil dihapus');
        } catch (\Exception $e) {
            \DB::rollBack();
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal menghapus akun: '.$e->getMessage()]);
            }

            return redirect()->route('master.accounts')->with('error', 'Gagal menghapus akun');
        }
    }

    public function destroyBulk(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Pilih minimal satu akun untuk dihapus']);
            }

            return redirect()->route('master.accounts')->with('error', 'Pilih minimal satu akun untuk dihapus');
        }

        $inUseIds = [];
        $deletableIds = [];

        foreach ($ids as $id) {
            if ($this->isAccountInUse($id)) {
                $inUseIds[] = $id;
            } else {
                $deletableIds[] = $id;
            }
        }

        if (! empty($deletableIds)) {
            \DB::beginTransaction();
            try {
                // Unlink from categories
                Category::whereIn('account_id', $deletableIds)->update(['account_id' => null]);

                // Delete ledger records
                GeneralLedger::whereIn('account_id', $deletableIds)->delete();

                ChartOfAccount::whereIn('id', $deletableIds)->delete();
                \DB::commit();
            } catch (\Exception $e) {
                \DB::rollBack();
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Gagal menghapus beberapa akun']);
                }

                return redirect()->route('master.accounts')->with('error', 'Gagal menghapus beberapa akun');
            }
        }

        if (! empty($inUseIds)) {
            $msg = count($inUseIds).' akun tidak dapat dihapus karena sudah memiliki transaksi.';
            if (! empty($deletableIds)) {
                $msg = count($deletableIds).' akun berhasil dihapus, namun '.$msg;
            }
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $msg]);
            }

            return redirect()->route('master.accounts')->with('error', $msg);
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => count($ids).' akun berhasil dihapus']);
        }

        return redirect()->route('master.accounts')->with('success', count($ids).' akun berhasil dihapus');
    }

    public function toggleStatus(ChartOfAccount $account)
    {
        $account->update(['is_active' => ! $account->is_active]);
        $status = $account->is_active ? 'diaktifkan' : 'dinonaktifkan';

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => "Akun berhasil $status"]);
        }

        return redirect()->route('master.accounts')->with('success', "Akun berhasil $status");
    }

    private function isAccountInUse($id)
    {
        // Account is in use only if it has journal entries
        return GeneralJournal::where('account_id', $id)->exists();
    }
}
