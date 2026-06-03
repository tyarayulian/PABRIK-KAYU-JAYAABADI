<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\ChartOfAccount;
use App\Models\GeneralJournal;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NeracaController extends Controller
{
    public function index(Request $request)
    {
        // Auto-sync before displaying
        GeneralJournal::syncAll();

        $endDateInput = $request->input('end_date');
        $endDate = $endDateInput ? Carbon::parse($endDateInput)->endOfDay() : Carbon::now()->endOfDay();

        // Assets
        $assets = $this->getAccountBalances('asset', $endDate);
        $totalAssets = $assets->sum('balance');

        // Liabilities
        $liabilities = $this->getAccountBalances('liability', $endDate);
        $totalLiabilities = $liabilities->sum('balance');

        // Equity
        $equity = $this->getAccountBalances('equity', $endDate);
        $totalEquityWithoutProfit = $equity->sum('balance');

        // Laba Tahun Berjalan (Current Year Profit)
        // Calculated from Revenue - (COGS + Expense) for the current year until $endDate
        $currentYear = $endDate->year;
        $startOfYear = Carbon::create($currentYear, 1, 1)->startOfDay();

        $profitData = $this->calculateProfit($startOfYear, $endDate);
        $currentYearProfit = $profitData['netIncome'];

        $totalEquity = $totalEquityWithoutProfit + $currentYearProfit;
        $totalLiabilitiesAndEquity = $totalLiabilities + $totalEquity;

        return view('report.neraca', compact(
            'assets', 'totalAssets',
            'liabilities', 'totalLiabilities',
            'equity', 'totalEquityWithoutProfit',
            'currentYearProfit', 'totalEquity',
            'totalLiabilitiesAndEquity', 'endDate'
        ));
    }

    private function getAccountBalances($type, $endDate)
    {
        $accounts = ChartOfAccount::where('type', $type)
            ->where('is_active', true)
            ->get();

        $balances = collect();

        foreach ($accounts as $account) {
            $debit = GeneralJournal::where('account_id', $account->id)
                ->where('journal_date', '<=', $endDate)
                ->where('type', 'debit')
                ->sum('amount');

            $credit = GeneralJournal::where('account_id', $account->id)
                ->where('journal_date', '<=', $endDate)
                ->where('type', 'credit')
                ->sum('amount');

            $balance = 0;
            if (in_array($type, ['asset', 'expense', 'cogs'])) {
                $balance = $debit - $credit;
            } else {
                $balance = $credit - $debit;
            }

            if ($balance != 0) {
                $balances->push([
                    'code' => $account->code,
                    'name' => $account->name,
                    'balance' => $balance,
                ]);
            }
        }

        return $balances;
    }

    private function calculateProfit($startDate, $endDate)
    {
        $revenueIds = ChartOfAccount::where('type', 'revenue')->pluck('id');
        $cogsIds = ChartOfAccount::where('type', 'cogs')->pluck('id');
        $expenseIds = ChartOfAccount::where('type', 'expense')->pluck('id');

        $revenue = GeneralJournal::whereIn('account_id', $revenueIds)
            ->whereBetween('journal_date', [$startDate, $endDate])
            ->where('type', 'credit')
            ->sum('amount') -
            GeneralJournal::whereIn('account_id', $revenueIds)
                ->whereBetween('journal_date', [$startDate, $endDate])
                ->where('type', 'debit')
                ->sum('amount');

        $cogs = GeneralJournal::whereIn('account_id', $cogsIds)
            ->whereBetween('journal_date', [$startDate, $endDate])
            ->where('type', 'debit')
            ->sum('amount') -
            GeneralJournal::whereIn('account_id', $cogsIds)
                ->whereBetween('journal_date', [$startDate, $endDate])
                ->where('type', 'credit')
                ->sum('amount');

        $expense = GeneralJournal::whereIn('account_id', $expenseIds)
            ->whereBetween('journal_date', [$startDate, $endDate])
            ->where('type', 'debit')
            ->sum('amount') -
            GeneralJournal::whereIn('account_id', $expenseIds)
                ->whereBetween('journal_date', [$startDate, $endDate])
                ->where('type', 'credit')
                ->sum('amount');

        $netIncome = $revenue - ($cogs + $expense);

        return [
            'netIncome' => $netIncome,
        ];
    }

    public function exportExcel(Request $request)
    {
        // Similar logic for CSV export
        GeneralJournal::syncAll();

        $endDateInput = $request->input('end_date');
        $endDate = $endDateInput ? Carbon::parse($endDateInput)->endOfDay() : Carbon::now()->endOfDay();

        $assets = $this->getAccountBalances('asset', $endDate);
        $totalAssets = $assets->sum('balance');

        $liabilities = $this->getAccountBalances('liability', $endDate);
        $totalLiabilities = $liabilities->sum('balance');

        $equity = $this->getAccountBalances('equity', $endDate);
        $totalEquityWithoutProfit = $equity->sum('balance');

        $currentYear = $endDate->year;
        $startOfYear = Carbon::create($currentYear, 1, 1)->startOfDay();
        $profitData = $this->calculateProfit($startOfYear, $endDate);
        $currentYearProfit = $profitData['netIncome'];

        $totalEquity = $totalEquityWithoutProfit + $currentYearProfit;
        $totalLiabilitiesAndEquity = $totalLiabilities + $totalEquity;

        $fileName = 'Neraca_'.$endDate->format('Ymd').'.csv';

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($assets, $totalAssets, $liabilities, $totalLiabilities, $equity, $currentYearProfit, $totalEquity, $totalLiabilitiesAndEquity, $endDate) {
            $file = fopen('php://output', 'w');
            fwrite($file, (chr(0xEF).chr(0xBB).chr(0xBF)));

            fputcsv($file, ['PABRIK KAYU JAYA ABADI']);
            fputcsv($file, ['Laporan Neraca']);
            fputcsv($file, ['Per Tanggal: '.$endDate->format('d/m/Y')]);
            fputcsv($file, []);

            fputcsv($file, ['AKTIVA']);
            fputcsv($file, ['Kode', 'Nama Akun', 'Saldo']);
            foreach ($assets as $asset) {
                fputcsv($file, [$asset['code'], $asset['name'], $asset['balance']]);
            }
            fputcsv($file, ['', 'TOTAL AKTIVA', $totalAssets]);
            fputcsv($file, []);

            fputcsv($file, ['KEWAJIBAN & EKUITAS']);
            fputcsv($file, ['KEWAJIBAN']);
            foreach ($liabilities as $liability) {
                fputcsv($file, [$liability['code'], $liability['name'], $liability['balance']]);
            }
            fputcsv($file, ['', 'TOTAL KEWAJIBAN', $totalLiabilities]);
            fputcsv($file, []);

            fputcsv($file, ['EKUITAS']);
            foreach ($equity as $eq) {
                fputcsv($file, [$eq['code'], $eq['name'], $eq['balance']]);
            }
            fputcsv($file, ['', 'Laba Tahun Berjalan', $currentYearProfit]);
            fputcsv($file, ['', 'TOTAL EKUITAS', $totalEquity]);
            fputcsv($file, []);
            fputcsv($file, ['', 'TOTAL KEWAJIBAN & EKUITAS', $totalLiabilitiesAndEquity]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
