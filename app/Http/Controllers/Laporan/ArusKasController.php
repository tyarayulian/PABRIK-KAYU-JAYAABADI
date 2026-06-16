<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\ChartOfAccount;
use App\Models\GeneralJournal;
use App\Models\KasKeluar;
use App\Models\KasMasuk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArusKasController extends Controller
{
    public function index()
    {
        return redirect()->route('transaksi.index');
    }

    public function reportIndex()
    {
        // Auto-sync before displaying
        GeneralJournal::syncAll();

        $monthInput = request('month');
        $yearInput = request('year');
        $filterType = request('filter_type', 'per_bulan'); // Default to per_bulan
        $startDateInput = request('start_date');
        $endDateInput = request('end_date');
        $search = request('search');

        // We focus on Cash/Asset accounts to track flow
        $cashAccountIds = ChartOfAccount::where('type', 'asset')
            ->where(function ($q) {
                $q->where('code', 'like', '11%') // Common cash/bank prefix
                    ->orWhere('name', 'like', '%Kas%')
                    ->orWhere('name', 'like', '%Bank%');
            })->pluck('id');

        $query = GeneralJournal::with(['account', 'account.journals'])
            ->whereIn('account_id', $cashAccountIds);

        if ($search) {
            $query->where('description', 'like', "%{$search}%");
        }

        $month = null;
        $year = $yearInput ?: date('Y');
        $startDate = null;
        $endDate = null;

        if ($filterType === 'per_bulan') {
            if ($monthInput) {
                $date = Carbon::parse($monthInput);
                $month = $date->month;
                $year = $date->year;
            } else {
                $month = date('n');
                $year = date('Y');
            }
            $query->whereYear('journal_date', $year)->whereMonth('journal_date', $month);
        } elseif ($filterType === 'per_tahun') {
            $query->whereYear('journal_date', $year);
        } elseif ($filterType === 'custom' && $startDateInput && $endDateInput) {
            $startDate = Carbon::parse($startDateInput)->startOfDay();
            $endDate = Carbon::parse($endDateInput)->endOfDay();
            $query->whereBetween('journal_date', [$startDate, $endDate]);
        }

        $journals = $query->get();

        // Net flow only, removing opening balance as requested
        $openingBalance = 0;
        $cashInflows = $journals->where('type', 'debit');
        $cashOutflows = $journals->where('type', 'credit');

        $totalIn = $cashInflows->sum('amount');
        $totalOut = $cashOutflows->sum('amount');
        $closingBalance = $totalIn - $totalOut;

        // Group by Counter Account (Standard for Cash Flow)
        $inByAccount = collect();
        foreach ($cashInflows as $in) {
            $other = GeneralJournal::where('reference', $in->reference)
                ->where('id', '!=', $in->id)
                ->with('account')
                ->first();

            if (! $other) {
                $other = GeneralJournal::where('journal_date', $in->journal_date)
                    ->where('description', $in->description)
                    ->where('id', '!=', $in->id)
                    ->with('account')
                    ->first();
            }

            $name = $other ? ($other->account->name ?? 'Lain-lain') : 'Penerimaan';
            $inByAccount[$name] = ($inByAccount[$name] ?? 0) + $in->amount;
        }

        $outByAccount = collect();
        foreach ($cashOutflows as $out) {
            $other = GeneralJournal::where('reference', $out->reference)
                ->where('id', '!=', $out->id)
                ->with('account')
                ->first();

            if (! $other) {
                $other = GeneralJournal::where('journal_date', $out->journal_date)
                    ->where('description', $out->description)
                    ->where('id', '!=', $out->id)
                    ->with('account')
                    ->first();
            }

            $name = $other ? ($other->account->name ?? 'Lain-lain') : 'Pengeluaran';
            $outByAccount[$name] = ($outByAccount[$name] ?? 0) + $out->amount;
        }

        $monthView = $month ? sprintf('%04d-%02d', $year, $month) : ($monthInput ?: date('Y-m'));

        return view('report.arus_kas.index', [
            'inByAccount' => $inByAccount,
            'outByAccount' => $outByAccount,
            'totalIn' => $totalIn,
            'totalOut' => $totalOut,
            'openingBalance' => $openingBalance,
            'closingBalance' => $closingBalance,
            'month' => $monthView,
            'year' => $year,
            'filterType' => $filterType,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }

    public function exportExcel()
    {
        // Auto-sync before exporting
        GeneralJournal::syncAll();
        $monthInput = request('month');
        $yearInput = request('year');
        $filterType = request('filter_type', 'per_bulan');
        $startDateInput = request('start_date');
        $endDateInput = request('end_date');
        $search = request('search');

        $cashAccountIds = ChartOfAccount::where('type', 'asset')
            ->where(function ($q) {
                $q->where('code', 'like', '11%')
                    ->orWhere('name', 'like', '%Kas%')
                    ->orWhere('name', 'like', '%Bank%');
            })->pluck('id');

        $query = GeneralJournal::with(['account'])
            ->whereIn('account_id', $cashAccountIds);

        if ($search) {
            $query->where('description', 'like', "%{$search}%");
        }

        $year = $yearInput ?: date('Y');
        if ($filterType === 'per_bulan') {
            if ($monthInput) {
                $date = Carbon::parse($monthInput);
                $query->whereYear('journal_date', $date->year)->whereMonth('journal_date', $date->month);
            }
        } elseif ($filterType === 'per_tahun') {
            $query->whereYear('journal_date', $year);
        } elseif ($filterType === 'custom' && $startDateInput && $endDateInput) {
            $startDate = Carbon::parse($startDateInput)->startOfDay();
            $endDate = Carbon::parse($endDateInput)->endOfDay();
            $query->whereBetween('journal_date', [$startDate, $endDate]);
        }

        $journals = $query->get();

        // Net flow only, removing opening balance as requested
        $openingBalance = 0;

        $cashInflows = $journals->where('type', 'debit');
        $cashOutflows = $journals->where('type', 'credit');

        $totalIn = $cashInflows->sum('amount');
        $totalOut = $cashOutflows->sum('amount');
        $closingBalance = $totalIn - $totalOut;

        $inByAccount = collect();
        foreach ($cashInflows as $in) {
            $other = GeneralJournal::where('reference', $in->reference)
                ->where('id', '!=', $in->id)
                ->with('account')
                ->first();

            if (! $other) {
                $other = GeneralJournal::where('journal_date', $in->journal_date)
                    ->where('description', $in->description)
                    ->where('id', '!=', $in->id)
                    ->with('account')
                    ->first();
            }

            $name = $other ? ($other->account->name ?? 'Lain-lain') : 'Penerimaan';
            $inByAccount[$name] = ($inByAccount[$name] ?? 0) + $in->amount;
        }

        $outByAccount = collect();
        foreach ($cashOutflows as $out) {
            $other = GeneralJournal::where('reference', $out->reference)
                ->where('id', '!=', $out->id)
                ->with('account')
                ->first();

            if (! $other) {
                $other = GeneralJournal::where('journal_date', $out->journal_date)
                    ->where('description', $out->description)
                    ->where('id', '!=', $out->id)
                    ->with('account')
                    ->first();
            }

            $name = $other ? ($other->account->name ?? 'Lain-lain') : 'Pengeluaran';
            $outByAccount[$name] = ($outByAccount[$name] ?? 0) + $out->amount;
        }

        $fileName = 'Laporan_Arus_Kas_'.date('Ymd_His').'.csv';

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($inByAccount, $outByAccount, $totalIn, $totalOut, $closingBalance, $filterType, $monthInput, $yearInput, $startDateInput, $endDateInput) {
            $file = fopen('php://output', 'w');
            fwrite($file, (chr(0xEF).chr(0xBB).chr(0xBF)));

            fputcsv($file, ['PABRIK KAYU JAYA ABADI']);
            fputcsv($file, ['Laporan Arus Kas']);

            $periode = 'Semua Data';
            if ($filterType === 'per_bulan' && $monthInput) {
                $periode = 'Periode: '.Carbon::parse($monthInput)->translatedFormat('F Y');
            } elseif ($filterType === 'per_tahun') {
                $periode = 'Tahun: '.$yearInput;
            } elseif ($filterType === 'custom' && $startDate && $endDate) {
                $periode = 'Periode: '.$startDate->format('d/m/Y').' s/d '.$endDate->format('d/m/Y');
            }
            fputcsv($file, [$periode]);
            fputcsv($file, []);

            fputcsv($file, ['URAIAN LAPORAN', 'JUMLAH (Rp)']);
            fputcsv($file, []);

            fputcsv($file, ['ARUS KAS MASUK']);
            foreach ($inByAccount as $name => $amount) {
                fputcsv($file, ['  '.$name, $amount]);
            }
            fputcsv($file, ['Total Pemasukan', $totalIn]);
            fputcsv($file, []);

            fputcsv($file, ['ARUS KAS KELUAR']);
            foreach ($outByAccount as $name => $amount) {
                fputcsv($file, ['  '.$name, -$amount]);
            }
            fputcsv($file, ['Total Pengeluaran', -$totalOut]);
            fputcsv($file, []);

            fputcsv($file, ['KENAIKAN / (PENURUNAN) KAS BERSIH', ($totalIn - $totalOut)]);
            fputcsv($file, ['TOTAL SALDO KAS BERSIH', $closingBalance]);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function reportCash()
    {
        // Auto-sync before displaying
        GeneralJournal::syncAll();

        $monthInput = request('month');
        $yearInput = request('year');
        $filterType = request('filter_type', 'per_bulan');
        $startDate = request('start_date');
        $endDate = request('end_date');
        $search = request('search');

        $cashAccountIds = ChartOfAccount::where('type', 'asset')
            ->where(function ($q) {
                $q->where('code', 'like', '11%')
                    ->orWhere('name', 'like', '%Kas%')
                    ->orWhere('name', 'like', '%Bank%');
            })->pluck('id');

        $query = GeneralJournal::with(['account'])
            ->whereIn('account_id', $cashAccountIds);

        if ($search) {
            $query->where('description', 'like', "%{$search}%");
        }

        if ($filterType === 'per_bulan') {
            $date = $monthInput ? Carbon::parse($monthInput) : Carbon::now();
            $query->whereYear('journal_date', $date->year)->whereMonth('journal_date', $date->month);
        } elseif ($filterType === 'per_tahun') {
            $query->whereYear('journal_date', $yearInput ?: date('Y'));
        } elseif ($filterType === 'custom' && $startDate && $endDate) {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
            $query->whereBetween('journal_date', [$startDate, $endDate]);
        }

        $journals = $query->orderBy('id', 'desc')->get();

        $totalIn = $journals->where('type', 'debit')->sum('amount');
        $totalOut = $journals->where('type', 'credit')->sum('amount');
        $netBalance = $totalIn - $totalOut;

        $groupedTransactions = [];
        foreach ($journals as $j) {
            $other = GeneralJournal::where('reference', $j->reference)
                ->where('id', '!=', $j->id)
                ->with('account')
                ->first();
            $categoryName = $other ? ($other->account->name ?? 'Lain-lain') : 'Transaksi';

            if (! isset($groupedTransactions[$categoryName])) {
                $groupedTransactions[$categoryName] = [
                    'category' => $categoryName,
                    'total_debit' => 0,
                    'total_credit' => 0,
                    'transactions' => [],
                ];
            }

            $isDebit = $j->type === 'debit';
            $groupedTransactions[$categoryName]['total_debit'] += $isDebit ? $j->amount : 0;
            $groupedTransactions[$categoryName]['total_credit'] += ! $isDebit ? $j->amount : 0;
            $groupedTransactions[$categoryName]['transactions'][] = [
                'id' => $j->id,
                'date' => $j->journal_date,
                'category' => $categoryName,
                'description' => $j->description,
                'type' => $isDebit ? 'in' : 'out',
                'debit' => $isDebit ? $j->amount : 0,
                'credit' => ! $isDebit ? $j->amount : 0,
            ];
        }

        return view('report.buku_kas.index', [
            'totalIn' => $totalIn,
            'totalOut' => $totalOut,
            'netBalance' => $netBalance,
            'groupedTransactions' => collect(array_values($groupedTransactions)),
            'month' => $monthInput,
            'year' => $yearInput ?: date('Y'),
            'filterType' => $filterType,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }

    public function exportCashExcel()
    {
        // Auto-sync before exporting
        GeneralJournal::syncAll();
        $monthInput = request('month');
        $yearInput = request('year');
        $filterType = request('filter_type', 'all');
        $startDate = request('start_date');
        $endDate = request('end_date');
        $search = request('search');

        $cashAccountIds = ChartOfAccount::where('type', 'asset')
            ->where(function ($q) {
                $q->where('code', 'like', '11%')
                    ->orWhere('name', 'like', '%Kas%')
                    ->orWhere('name', 'like', '%Bank%');
            })->pluck('id');

        $query = GeneralJournal::with(['account'])
            ->whereIn('account_id', $cashAccountIds);

        if ($search) {
            $query->where('description', 'like', "%{$search}%");
        }

        if ($filterType === 'per_bulan') {
            $date = $monthInput ? Carbon::parse($monthInput) : Carbon::now();
            $query->whereYear('journal_date', $date->year)->whereMonth('journal_date', $date->month);
        } elseif ($filterType === 'per_tahun') {
            $query->whereYear('journal_date', $yearInput ?: date('Y'));
        } elseif ($filterType === 'custom' && $startDate && $endDate) {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
            $query->whereBetween('journal_date', [$startDate, $endDate]);
        }

        $journals = $query->orderBy('id', 'desc')->get();

        $totalIn = $journals->where('type', 'debit')->sum('amount');
        $totalOut = $journals->where('type', 'credit')->sum('amount');

        $transactions = $journals->map(function ($j) {
            $other = GeneralJournal::where('reference', $j->reference)
                ->where('id', '!=', $j->id)
                ->with('account')
                ->first();
            $categoryName = $other ? ($other->account->name ?? 'Lain-lain') : 'Transaksi';

            $isDebit = $j->type === 'debit';

            return [
                'date' => $j->journal_date,
                'category' => $categoryName,
                'description' => $j->description,
                'type' => $isDebit ? 'Masuk' : 'Keluar',
                'debit' => $isDebit ? $j->amount : 0,
                'credit' => ! $isDebit ? $j->amount : 0,
            ];
        });

        $fileName = 'Laporan_Detail_Kas_'.date('Ymd_His').'.csv';

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($transactions, $totalIn, $totalOut, $filterType, $monthInput, $yearInput, $startDate, $endDate) {
            $file = fopen('php://output', 'w');
            fwrite($file, (chr(0xEF).chr(0xBB).chr(0xBF)));

            fputcsv($file, ['PABRIK KAYU JAYA ABADI']);
            fputcsv($file, ['Laporan Detail Kas (Pemasukan & Pengeluaran)']);

            $periode = 'Semua Data';
            if ($filterType === 'per_bulan') {
                $periode = 'Periode: '.Carbon::parse($monthInput)->translatedFormat('F Y');
            } elseif ($filterType === 'per_tahun') {
                $periode = 'Tahun: '.$yearInput;
            } elseif ($filterType === 'custom') {
                $periode = 'Periode: '.($startDate ? $startDate->format('d/m/Y') : '').' s/d '.($endDate ? $endDate->format('d/m/Y') : '');
            }
            fputcsv($file, [$periode]);
            fputcsv($file, []);

            fputcsv($file, ['Tanggal', 'Kategori', 'Keterangan', 'Jenis', 'Debit (Rp)', 'Kredit (Rp)']);

            foreach ($transactions as $t) {
                $cleanDescription = preg_replace('/Kas (Masuk|Keluar) \((.*?)\)/', '$2', $t['description'] ?? '-');
                fputcsv($file, [
                    Carbon::parse($t['date'])->format('d/m/Y'),
                    $t['category'],
                    $cleanDescription,
                    $t['type'],
                    $t['debit'] ?: 0,
                    $t['credit'] ?: 0,
                ]);
            }

            fputcsv($file, []);
            fputcsv($file, ['', '', '', 'TOTAL', $totalIn, $totalOut]);
            fputcsv($file, ['', '', '', 'SALDO BERSIH', ($totalIn - $totalOut)]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function apiCashFlow()
    {
        $cashIns = KasMasuk::with('category.account')->orderBy('id', 'desc')->get();
        $cashOuts = KasKeluar::with('category.account')->orderBy('id', 'desc')->get();

        $totalIn = $cashIns->sum('amount');
        $totalOut = $cashOuts->sum('amount');
        $totalBalance = $totalIn - $totalOut;

        $transactions = collect()
            ->merge($cashIns->map(fn ($t) => ['id' => $t->id, 'date' => $t->date, 'account' => $t->category->name ?? 'N/A', 'amount' => $t->amount, 'type' => 'in', 'description' => $t->description]))
            ->merge($cashOuts->map(fn ($t) => ['id' => $t->id, 'date' => $t->date, 'account' => $t->category->name ?? 'N/A', 'amount' => $t->amount, 'type' => 'out', 'description' => $t->description]))
            ->sort(function ($a, $b) {
                // Return newest first based on date or ID
                return $b['id'] <=> $a['id'];
            })
            ->take(10)
            ->values()
            ->toArray();

        return response()->json([
            'totalIn' => number_format($totalIn, 0, ',', '.'),
            'totalOut' => number_format($totalOut, 0, ',', '.'),
            'totalBalance' => number_format($totalBalance, 0, ',', '.'),
            'transactions' => $transactions,
            'timestamp' => now()->format('Y-m-d H:i:s'),
        ]);
    }

    public function apiCashReport()
    {
        $monthInput = request('month');
        $yearInput = request('year');
        $filterType = request('filter_type', 'all');

        $query = KasMasuk::with('category.account');
        $queryOut = KasKeluar::with('category.account');

        if ($filterType === 'all') {
            // All data
        } elseif ($monthInput) {
            $date = Carbon::parse($monthInput);
            $query->whereYear('date', $date->year)->whereMonth('date', $date->month);
            $queryOut->whereYear('date', $date->year)->whereMonth('date', $date->month);
        } elseif ($yearInput) {
            $query->whereYear('date', $yearInput);
            $queryOut->whereYear('date', $yearInput);
        } else {
            // Default to current month if specifically requested but no inputs,
            // but since filter_type defaults to all, this block is for cases
            // where filter_type is set to something else but missing values.
            $query->whereYear('date', date('Y'))->whereMonth('date', date('n'));
            $queryOut->whereYear('date', date('Y'))->whereMonth('date', date('n'));
        }

        $cashIns = $query->get();
        $cashOuts = $queryOut->get();

        $totalIn = $cashIns->sum('amount');
        $totalOut = $cashOuts->sum('amount');
        $netBalance = $totalIn - $totalOut;

        return response()->json([
            'totalIn' => number_format($totalIn, 0, ',', '.'),
            'totalOut' => number_format($totalOut, 0, ',', '.'),
            'netBalance' => number_format($netBalance, 0, ',', '.'),
            'timestamp' => now()->format('Y-m-d H:i:s'),
        ]);
    }

    public function getTransactionDetail($type, $id)
    {
        try {
            if ($type === 'income') {
                $transaction = KasMasuk::with(['category.account', 'product'])->findOrFail($id);
                $accountName = $transaction->product->name ?? ($transaction->category->name ?? 'N/A');
                $data = [
                    'id' => $transaction->id,
                    'type' => 'income',
                    'date' => $transaction->date,
                    'account_name' => $accountName,
                    'hutan' => $transaction->hutan ?? null,
                    'description' => $transaction->description,
                    'amount' => $transaction->amount,
                    'file_path' => $transaction->file_path,
                    'file_url' => $transaction->file_path ? Storage::url($transaction->file_path) : null,
                ];
            } else {
                $transaction = KasKeluar::with(['category.account', 'product'])->findOrFail($id);
                $accountName = (isset($transaction->product) && $transaction->product) 
                    ? "Kayu " . $transaction->product->wood_type 
                    : ($transaction->category->name ?? 'N/A');
                $data = [
                    'id' => $transaction->id,
                    'type' => 'expense',
                    'date' => $transaction->date,
                    'account_name' => $accountName,
                    'hutan' => $transaction->hutan ?? null,
                    'description' => $transaction->description,
                    'amount' => $transaction->amount,
                    'file_path' => $transaction->file_path,
                    'file_url' => $transaction->file_path ? Storage::url($transaction->file_path) : null,
                ];
            }

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found',
            ], 404);
        }
    }

    public function printCashFlow(Request $request)
    {
        $filterType = $request->input('filter_type', 'all');
        $month = $request->input('month');
        $year = $request->input('year', date('Y'));
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $cashAccountIds = ChartOfAccount::where('type', 'asset')
            ->where(function ($q) {
                $q->where('code', 'like', '11%')
                    ->orWhere('name', 'like', '%Kas%')
                    ->orWhere('name', 'like', '%Bank%');
            })->pluck('id');

        $queryIn = GeneralJournal::whereIn('account_id', $cashAccountIds);
        $queryOut = GeneralJournal::whereIn('account_id', $cashAccountIds);

        if ($filterType === 'per_bulan' && $month) {
            $date = \Carbon\Carbon::parse($month);
            $queryIn->whereYear('journal_date', $date->year)->whereMonth('journal_date', $date->month)->where('type', 'debit');
            $queryOut->whereYear('journal_date', $date->year)->whereMonth('journal_date', $date->month)->where('type', 'credit');
        } elseif ($filterType === 'per_tahun' && $year) {
            $queryIn->whereYear('journal_date', $year)->where('type', 'debit');
            $queryOut->whereYear('journal_date', $year)->where('type', 'credit');
        } elseif ($filterType === 'custom' && $startDate && $endDate) {
            $queryIn->whereBetween('journal_date', [$startDate, $endDate])->where('type', 'debit');
            $queryOut->whereBetween('journal_date', [$startDate, $endDate])->where('type', 'credit');
        }

        $cashIn = $queryIn->get();
        $cashOut = $queryOut->get();

        $inByAccount = [];
        foreach ($cashIn as $item) {
            $accountName = $item->account ? $item->account->name : 'Penerimaan Kas';
            $inByAccount[$accountName] = ($inByAccount[$accountName] ?? 0) + $item->amount;
        }

        $outByAccount = [];
        foreach ($cashOut as $item) {
            $accountName = $item->account ? $item->account->name : 'Pengeluaran Kas';
            $outByAccount[$accountName] = ($outByAccount[$accountName] ?? 0) + $item->amount;
        }

        $totalIn = array_sum($inByAccount);
        $totalOut = array_sum($outByAccount);

        return view('report.arus_kas.print', compact('inByAccount', 'outByAccount', 'totalIn', 'totalOut'));
    }

    public function destroyBulk(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'Tidak ada transaksi yang dipilih untuk dihapus');
        }

        try {
            $deletedCount = 0;
            foreach ($ids as $id) {
                $kasMasuk = KasMasuk::find($id);
                if ($kasMasuk) {
                    $kasMasuk->delete();
                    $deletedCount++;
                } else {
                    $kasKeluar = KasKeluar::find($id);
                    if ($kasKeluar) {
                        $kasKeluar->delete();
                        $deletedCount++;
                    }
                }
            }

            return redirect()->back()->with('success', $deletedCount.' transaksi berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus transaksi: '.$e->getMessage());
        }
    }
}
