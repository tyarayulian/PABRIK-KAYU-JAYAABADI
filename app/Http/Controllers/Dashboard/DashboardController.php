<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ChartOfAccount;
use App\Models\GeneralJournal;
use App\Models\KasKeluar;
use App\Models\KasMasuk;
use App\Models\SalesReturn;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private function getCashAccountIds()
    {
        return ChartOfAccount::where('type', 'asset')
            ->where(function ($q) {
                $q->where('code', 'like', '11%')
                    ->orWhere('name', 'like', '%Kas%')
                    ->orWhere('name', 'like', '%Bank%');
            })->pluck('id');
    }

    public function apiData()
    {
        GeneralJournal::syncAll();
        $periodType = request('period_type', 'all');
        $periodMonth = request('period_month');
        $startDate = request('start_date');
        $endDate = request('end_date');

        $today = Carbon::today();
        $cashAccountIds = $this->getCashAccountIds();

        $monthStart = null;
        $monthEnd = null;

        if ($periodType === 'month' && $periodMonth) {
            $year = Carbon::now()->year;
            $monthStart = Carbon::createFromDate($year, $periodMonth, 1)->startOfMonth();
            $monthEnd = Carbon::createFromDate($year, $periodMonth, 1)->endOfMonth();
        } elseif ($periodType === 'custom' && $startDate && $endDate) {
            $monthStart = Carbon::parse($startDate)->startOfDay();
            $monthEnd = Carbon::parse($endDate)->endOfDay();
        } elseif ($periodType === 'current_month') {
            $monthStart = Carbon::now()->startOfMonth();
            $monthEnd = Carbon::now()->endOfMonth();
        }

        $cashInToday = KasMasuk::whereDate('date', $today)->sum('amount');
        $cashOutToday = KasKeluar::whereDate('date', $today)->sum('amount') + SalesReturn::whereDate('date', $today)->sum('amount');
        $balanceToday = $cashInToday - $cashOutToday;

        $cashInQuery = KasMasuk::query();
        $cashOutQuery = KasKeluar::query();
        $salesReturnQuery = SalesReturn::query();

        if ($monthStart && $monthEnd) {
            $cashInQuery->whereBetween('date', [$monthStart, $monthEnd]);
            $cashOutQuery->whereBetween('date', [$monthStart, $monthEnd]);
            $salesReturnQuery->whereBetween('date', [$monthStart, $monthEnd]);
        }

        $cashInThisMonth = (clone $cashInQuery)->sum('amount');
        $cashOutThisMonth = (clone $cashOutQuery)->sum('amount') + (clone $salesReturnQuery)->sum('amount');
        $netBalance = $cashInThisMonth - $cashOutThisMonth;

        $latestTransactions = $this->getLatestTransactions($monthStart, $monthEnd);
        $sparklineData = $this->getDailySparklineData($monthStart, $monthEnd);
        $graphData = $this->getMonthComparisonData($periodMonth, $periodType, $startDate, $endDate);
        $transactionsByCategory = $this->getTransactionsByCategory($monthStart, $monthEnd);
        $topProducts = $this->getTopProducts($monthStart, $monthEnd);

        $totalKasMasukAll = KasMasuk::sum('amount');
        $totalKasKeluarAll = KasKeluar::sum('amount') + SalesReturn::sum('amount');
        $runningBalance = $totalKasMasukAll - $totalKasKeluarAll;

        $totalKasMasuk = KasMasuk::sum('amount');
        $totalKasKeluar = KasKeluar::sum('amount') + SalesReturn::sum('amount');

        $grandTotal = $totalKasMasuk + $totalKasKeluar;
        $cashInPercentageTotal = $grandTotal > 0 ? round(($totalKasMasuk / $grandTotal) * 100, 1) : 0;
        $cashOutPercentageTotal = $grandTotal > 0 ? round(($totalKasKeluar / $grandTotal) * 100, 1) : 0;

        $totalTransactionsCount = KasMasuk::count() + KasKeluar::count() + SalesReturn::count();
        if ($monthStart && $monthEnd) {
            $totalTransactionsCount = KasMasuk::whereBetween('date', [$monthStart, $monthEnd])->count() +
                                     KasKeluar::whereBetween('date', [$monthStart, $monthEnd])->count() +
                                     SalesReturn::whereBetween('date', [$monthStart, $monthEnd])->count();
        }
        $totalTransactions = $totalTransactionsCount;

        $periodLabel = $this->getPeriodLabel($periodType, $periodMonth, $startDate, $endDate);

        return response()->json([
            'netBalance' => $netBalance,
            'cashInToday' => $cashInToday,
            'cashOutToday' => $cashOutToday,
            'balanceToday' => $balanceToday,
            'runningBalance' => $runningBalance,
            'cashInThisMonth' => $cashInThisMonth,
            'cashOutThisMonth' => $cashOutThisMonth,
            'totalTransactions' => $totalTransactions,
            'cashInPercentageTotal' => $cashInPercentageTotal,
            'cashOutPercentageTotal' => $cashOutPercentageTotal,
            'latestTransactions' => $latestTransactions,
            'sparklineData' => $sparklineData,
            'graphData' => $graphData,
            'transactionsByCategory' => $transactionsByCategory,
            'topProducts' => $topProducts,
            'periodLabel' => $periodLabel,
            'timestamp' => now()->format('Y-m-d H:i:s'),
        ]);
    }

    public function index()
    {
        GeneralJournal::syncAll();
        $periodType = request('period_type', 'all');
        $periodMonth = request('period_month');
        $startDate = request('start_date');
        $endDate = request('end_date');

        $today = Carbon::today();
        $cashAccountIds = $this->getCashAccountIds();

        $monthStart = null;
        $monthEnd = null;

        if ($periodType === 'month' && $periodMonth) {
            $year = Carbon::now()->year;
            $monthStart = Carbon::createFromDate($year, $periodMonth, 1)->startOfMonth();
            $monthEnd = Carbon::createFromDate($year, $periodMonth, 1)->endOfMonth();
        } elseif ($periodType === 'custom' && $startDate && $endDate) {
            $monthStart = Carbon::parse($startDate)->startOfDay();
            $monthEnd = Carbon::parse($endDate)->endOfDay();
        } elseif ($periodType === 'current_month') {
            $monthStart = Carbon::now()->startOfMonth();
            $monthEnd = Carbon::now()->endOfMonth();
        }

        $cashInToday = KasMasuk::whereDate('date', $today)->sum('amount');
        $cashOutToday = KasKeluar::whereDate('date', $today)->sum('amount') + SalesReturn::whereDate('date', $today)->sum('amount');
        $balanceToday = $cashInToday - $cashOutToday;

        $lastKasMasuk = KasMasuk::whereDate('date', $today)->orderByDesc('date')->orderByDesc('id')->first();
        $lastKasKeluar = KasKeluar::whereDate('date', $today)->orderByDesc('date')->orderByDesc('id')->first();
        $lastSalesReturn = SalesReturn::whereDate('date', $today)->orderByDesc('date')->orderByDesc('id')->first();
        
        $lastTransactionDate = null;
        $dates = collect();
        if ($lastKasMasuk) $dates->push($lastKasMasuk->date);
        if ($lastKasKeluar) $dates->push($lastKasKeluar->date);
        if ($lastSalesReturn) $dates->push($lastSalesReturn->date);
        
        if ($dates->count() > 0) {
            $lastTransactionDate = $dates->max();
        }

        $cashInQuery = KasMasuk::query();
        $cashOutQuery = KasKeluar::query();
        $salesReturnQuery = SalesReturn::query();

        if ($monthStart && $monthEnd) {
            $cashInQuery->whereBetween('date', [$monthStart, $monthEnd]);
            $cashOutQuery->whereBetween('date', [$monthStart, $monthEnd]);
            $salesReturnQuery->whereBetween('date', [$monthStart, $monthEnd]);
        }

        $cashInThisMonth = (clone $cashInQuery)->sum('amount');
        $cashOutThisMonth = (clone $cashOutQuery)->sum('amount') + (clone $salesReturnQuery)->sum('amount');
        $netBalance = $cashInThisMonth - $cashOutThisMonth;

        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();
        $cashInLastMonth = KasMasuk::whereBetween('date', [$lastMonthStart, $lastMonthEnd])->whereNotNull('product_id')->sum('amount');
        $cashOutLastMonth = KasKeluar::whereBetween('date', [$lastMonthStart, $lastMonthEnd])->whereNotNull('product_id')->sum('amount') + 
                           SalesReturn::whereBetween('date', [$lastMonthStart, $lastMonthEnd])->sum('amount');

        $cashInPercentage = $this->calculatePercentageChange($cashInThisMonth, $cashInLastMonth);
        $cashOutPercentage = $this->calculatePercentageChange($cashOutThisMonth, $cashOutLastMonth);
        $cashInChangeType = $this->getChangeType($cashInThisMonth, $cashInLastMonth);
        $cashOutChangeType = $this->getChangeType($cashOutThisMonth, $cashOutLastMonth);

        $totalTransactionsCount = KasMasuk::count() + KasKeluar::count() + SalesReturn::count();
        if ($monthStart && $monthEnd) {
            $totalTransactionsCount = KasMasuk::whereBetween('date', [$monthStart, $monthEnd])->count() +
                                     KasKeluar::whereBetween('date', [$monthStart, $monthEnd])->count() +
                                     SalesReturn::whereBetween('date', [$monthStart, $monthEnd])->count();
        }
        $totalTransactions = $totalTransactionsCount;

        $totalKasMasukAll = KasMasuk::sum('amount');
        $totalKasKeluarAll = KasKeluar::sum('amount') + SalesReturn::sum('amount');
        $runningBalance = $totalKasMasukAll - $totalKasKeluarAll;

        $totalKasMasuk = KasMasuk::sum('amount');
        $totalKasKeluar = KasKeluar::sum('amount') + SalesReturn::sum('amount');

        $grandTotal = $totalKasMasuk + $totalKasKeluar;
        $cashInPercentageTotal = $grandTotal > 0 ? round(($totalKasMasuk / $grandTotal) * 100, 1) : 0;
        $cashOutPercentageTotal = $grandTotal > 0 ? round(($totalKasKeluar / $grandTotal) * 100, 1) : 0;

        $graphData = $this->getMonthComparisonData($periodMonth, $periodType, $startDate, $endDate);

        $transactionsByCategory = $this->getTransactionsByCategory($monthStart, $monthEnd);
        $topProducts = $this->getTopProducts($monthStart, $monthEnd);

        $sparklineData = $this->getDailySparklineData($monthStart, $monthEnd);

        $latestTransactions = $this->getLatestTransactions($monthStart, $monthEnd);

        $chartOfAccounts = ChartOfAccount::where('is_active', true)
            ->whereIn('type', ['revenue', 'expense'])
            ->orderBy('code')
            ->get();

        $filterActive = ! ($periodType === 'current_month' && ! $periodMonth && ! $startDate && ! $endDate);

        $periodLabel = $this->getPeriodLabel($periodType, $periodMonth, $startDate, $endDate);

        return view('dashboard', compact(
            'cashInToday',
            'cashOutToday',
            'cashInThisMonth',
            'cashOutThisMonth',
            'balanceToday',
            'runningBalance',
            'netBalance',
            'cashInPercentage',
            'cashOutPercentage',
            'cashInChangeType',
            'cashOutChangeType',
            'totalTransactions',
            'totalKasMasuk',
            'totalKasKeluar',
            'cashInPercentageTotal',
            'cashOutPercentageTotal',
            'lastTransactionDate',
            'graphData',
            'sparklineData',
            'latestTransactions',
            'transactionsByCategory',
            'topProducts',
            'chartOfAccounts',
            'periodType',
            'periodMonth',
            'startDate',
            'endDate',
            'filterActive',
            'periodLabel'
        ));
    }

    private function getPeriodLabel($periodType, $periodMonth, $startDate, $endDate)
    {
        $monthNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        if ($periodType === 'month' && $periodMonth) {
            return $monthNames[$periodMonth] ?? 'Bulan Ini';
        } elseif ($periodType === 'custom' && $startDate && $endDate) {
            $start = Carbon::parse($startDate)->locale('id')->translatedFormat('d M');
            $end = Carbon::parse($endDate)->locale('id')->translatedFormat('d M Y');

            return "$start - $end";
        } elseif ($periodType === 'current_month') {
            $currentMonth = Carbon::now()->month;

            return $monthNames[$currentMonth];
        } else {
            return 'Semua Data';
        }
    }

    private function getDailySparklineData($startDate, $endDate)
    {
        $dates = [];
        $fullDates = [];
        $cashIn = [];
        $cashOut = [];
        $balances = [];

        $periodType = request('period_type', 'all');

        // Logic to "center" the data or show full month
        if ($periodType === 'all' || (! $startDate && ! $endDate)) {
            // Show last 7 days to match the design in the request
            $startDate = now()->subDays(6)->startOfDay();
            $endDate = now()->endOfDay();
        } elseif ($startDate && $endDate) {
            // If it's a specific month or range, show that full range
            $startDate = $startDate->copy()->startOfDay();
            $endDate = $endDate->copy()->endOfDay();

            // If the range is a full month, maybe it's too many points?
            // No, 30 points is fine for a line chart.
        }

        $cashInByDate = KasMasuk::whereBetween('date', [$startDate->format('Y-m-d 00:00:00'), $endDate->format('Y-m-d 23:59:59')])
            ->select(DB::raw('DATE(date) as date_only'), DB::raw('SUM(amount) as total'))
            ->groupBy(DB::raw('DATE(date)'))
            ->get()
            ->pluck('total', 'date_only')
            ->toArray();

        $cashOutByDate = KasKeluar::whereBetween('date', [$startDate->format('Y-m-d 00:00:00'), $endDate->format('Y-m-d 23:59:59')])
            ->select(DB::raw('DATE(date) as date_only'), DB::raw('SUM(amount) as total'))
            ->groupBy(DB::raw('DATE(date)'))
            ->get()
            ->pluck('total', 'date_only')
            ->toArray();

        $salesReturnByDate = SalesReturn::whereBetween('date', [$startDate->format('Y-m-d 00:00:00'), $endDate->format('Y-m-d 23:59:59')])
            ->select(DB::raw('DATE(date) as date_only'), DB::raw('SUM(amount) as total'))
            ->groupBy(DB::raw('DATE(date)'))
            ->get()
            ->pluck('total', 'date_only')
            ->toArray();

        $current = $startDate->copy();
        while ($current <= $endDate) {
            $dateStr = $current->format('Y-m-d');

            $in = (float) ($cashInByDate[$dateStr] ?? 0);
            $out = (float) ($cashOutByDate[$dateStr] ?? 0) + (float) ($salesReturnByDate[$dateStr] ?? 0);

            $dates[] = $current->translatedFormat('D');
            $fullDates[] = $current->translatedFormat('d M Y');
            $cashIn[] = $in;
            $cashOut[] = $out;
            $balances[] = $in - $out;

            $current->addDay();
        }

        return [
            'dates' => $dates,
            'fullDates' => $fullDates,
            'cashIn' => $cashIn,
            'cashOut' => $cashOut,
            'balances' => $balances,
        ];
    }

    private function calculatePercentageChange($today, $yesterday)
    {
        if ($yesterday == 0) {
            if ($today > 0) {
                return 'new';
            }

            return 'none';
        }

        return round((($today - $yesterday) / $yesterday) * 100, 0);
    }

    private function getChangeType($today, $yesterday)
    {
        if ($yesterday == 0 && $today > 0) {
            return 'new';
        }
        if ($today == 0 && $yesterday == 0) {
            return 'none';
        }

        return 'normal';
    }

    private function getMonthComparisonData($periodMonth = null, $periodType = null, $startDate = null, $endDate = null)
    {
        $dates = [];
        $cashInData = [];
        $cashOutData = [];
        $currentYear = Carbon::now()->year;
        $cashAccountIds = $this->getCashAccountIds();

        if ($periodType === 'month' && $periodMonth) {
            $startMonth = max(1, $periodMonth - 2);
            $endMonth = min(12, $periodMonth + 2);

            for ($month = $startMonth; $month <= $endMonth; $month++) {
                $monthStart = Carbon::createFromDate($currentYear, $month, 1)->startOfMonth();
                $monthEnd = Carbon::createFromDate($currentYear, $month, 1)->endOfMonth();

                $cashIn = KasMasuk::whereBetween('date', [$monthStart, $monthEnd])->sum('amount');
                $cashOut = KasKeluar::whereBetween('date', [$monthStart, $monthEnd])->sum('amount') + SalesReturn::whereBetween('date', [$monthStart, $monthEnd])->sum('amount');

                $dates[] = $monthStart->locale('id')->translatedFormat('M');
                $cashInData[] = (int) $cashIn;
                $cashOutData[] = (int) $cashOut;
            }
        } elseif ($periodType === 'custom' && $startDate && $endDate) {
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $current = $start->copy()->startOfMonth();

            while ($current <= $end) {
                $monthStart = $current->copy()->startOfMonth();
                $monthEnd = $current->copy()->endOfMonth();

                $cashIn = KasMasuk::whereBetween('date', [$monthStart, $monthEnd])->sum('amount');
                $cashOut = KasKeluar::whereBetween('date', [$monthStart, $monthEnd])->sum('amount') + SalesReturn::whereBetween('date', [$monthStart, $monthEnd])->sum('amount');

                $dates[] = $current->locale('id')->translatedFormat('M');
                $cashInData[] = (int) $cashIn;
                $cashOutData[] = (int) $cashOut;

                $current->addMonth();
            }
        } elseif ($periodType === 'current_month') {
            for ($i = 5; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $monthStart = $month->copy()->startOfMonth();
                $monthEnd = $month->copy()->endOfMonth();

                $cashIn = KasMasuk::whereBetween('date', [$monthStart, $monthEnd])->sum('amount');
                $cashOut = KasKeluar::whereBetween('date', [$monthStart, $monthEnd])->sum('amount');

                $dates[] = $month->locale('id')->translatedFormat('M');
                $cashInData[] = (int) $cashIn;
                $cashOutData[] = (int) $cashOut;
            }
        } else {
            // Default to last 12 months for 'all'
            for ($i = 11; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $monthStart = $month->copy()->startOfMonth();
                $monthEnd = $month->copy()->endOfMonth();

                $cashIn = KasMasuk::whereBetween('date', [$monthStart, $monthEnd])->sum('amount');
                $cashOut = KasKeluar::whereBetween('date', [$monthStart, $monthEnd])->sum('amount');

                $dates[] = $month->locale('id')->translatedFormat('M');
                $cashInData[] = (int) $cashIn;
                $cashOutData[] = (int) $cashOut;
            }
        }

        return [
            'dates' => $dates,
            'cashIn' => $cashInData,
            'cashOut' => $cashOutData,
        ];
    }

    private function getLatestTransactions($startDate = null, $endDate = null)
    {
        $cashIns = KasMasuk::with(['category', 'product']);
        $cashOuts = KasKeluar::with(['category', 'product']);
        $returns = SalesReturn::with(['product', 'kasMasuk']);

        if ($startDate && $endDate) {
            $cashIns->whereBetween('date', [$startDate, $endDate]);
            $cashOuts->whereBetween('date', [$startDate, $endDate]);
            $returns->whereBetween('date', [$startDate, $endDate]);
        }

        $ins = $cashIns->orderBy('id', 'desc')->limit(5)->get()->map(fn ($t) => [
            'type' => 'in',
            'amount' => number_format((int) $t->amount, 0, ',', '.'),
            'description' => $t->description ?? 'Penjualan',
            'category' => $t->product->name ?? ($t->category->name ?? 'Penjualan'),
            'qty' => $t->product_id ? ($t->quantity != 0 ? (float) $t->quantity : '-') : '-',
            'notes' => '',
            'date' => $t->date->locale('id')->translatedFormat('d M Y H:i'),
            'raw_date' => $t->date,
        ]);

        $outs = $cashOuts->orderBy('id', 'desc')->limit(5)->get()->map(fn ($t) => [
            'type' => 'out',
            'amount' => number_format((int) $t->amount, 0, ',', '.'),
            'description' => $t->description ?? 'Pembelian',
            'category' => $t->product->name ?? ($t->category->name ?? 'Pembelian'),
            'qty' => $t->product_id ? ($t->quantity != 0 ? (float) $t->quantity : '-') : '-',
            'notes' => '',
            'date' => $t->date->locale('id')->translatedFormat('d M Y H:i'),
            'raw_date' => $t->date,
        ]);

        $rets = $returns->orderBy('id', 'desc')->limit(5)->get()->map(fn ($t) => [
            'type' => 'out', // Return is money out
            'amount' => number_format((int) $t->amount, 0, ',', '.'),
            'description' => $t->description ?? 'Retur Penjualan',
            'category' => $t->product->name ?? 'Retur Penjualan',
            'qty' => $t->quantity != 0 ? (float) $t->quantity : '-',
            'notes' => 'RETUR',
            'date' => $t->date->locale('id')->translatedFormat('d M Y H:i'),
            'raw_date' => $t->date,
        ]);

        return $ins->concat($outs)->concat($rets)->sortByDesc('raw_date')->take(5)->values()->toArray();
    }

    private function getTransactionsByCategory($startDate = null, $endDate = null)
    {
        $cashIns = KasMasuk::with(['category', 'product']);
        $cashOuts = KasKeluar::with(['category', 'product']);
        $returns = SalesReturn::with(['product']);

        if ($startDate && $endDate) {
            $cashIns->whereBetween('date', [$startDate, $endDate]);
            $cashOuts->whereBetween('date', [$startDate, $endDate]);
            $returns->whereBetween('date', [$startDate, $endDate]);
        }

        $categories = collect();

        $cashIns->get()->each(function ($t) use ($categories) {
            $name = $t->product->name ?? ($t->category->name ?? 'Penjualan');
            $categories->put($name, ($categories->get($name, 0) + 1));
        });

        $cashOuts->get()->each(function ($t) use ($categories) {
            $name = $t->product->name ?? ($t->category->name ?? 'Pembelian');
            $categories->put($name, ($categories->get($name, 0) + 1));
        });

        $returns->get()->each(function ($t) use ($categories) {
            $name = 'Retur: ' . ($t->product->name ?? 'Produk');
            $categories->put($name, ($categories->get($name, 0) + 1));
        });

        return $categories->sortDesc();
    }

    private function getTopProducts($startDate = null, $endDate = null)
    {
        $query = KasMasuk::with('product')
            ->whereNotNull('product_id')
            ->select('product_id', DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('product_id');

        $returnQuery = SalesReturn::whereNotNull('product_id')
            ->select('product_id', DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('product_id');

        if ($startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
            $returnQuery->whereBetween('date', [$startDate, $endDate]);
        }

        $sales = $query->get()->pluck('total_qty', 'product_id');
        $returns = $returnQuery->get()->pluck('total_qty', 'product_id');

        $netSales = collect();
        
        // Use products involved in either sales or returns
        $productIds = $sales->keys()->concat($returns->keys())->unique();

        foreach ($productIds as $id) {
            $sold = $sales->get($id, 0);
            $returned = $returns->get($id, 0);
            $net = (float)$sold - (float)$returned;
            
            if ($net > 0) {
                $product = \App\Models\Product::find($id);
                $netSales->push([
                    'name' => $product->name ?? 'Unknown',
                    'total' => $net
                ]);
            }
        }

        return $netSales->sortByDesc('total')->take(15)->values();
    }
}
