<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\ChartOfAccount;
use App\Models\GeneralJournal;
use Carbon\Carbon;

class IncomeStatementController extends Controller
{
    public function index()
    {
        // Auto-sync before displaying
        GeneralJournal::syncAll();
        
        $filterType = request('filter_type', 'per_bulan');
        $monthInput = request('month');
        $yearInput = request('year');
        $startDateInput = request('start_date');
        $endDateInput = request('end_date');

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
        } elseif ($filterType === 'per_tahun') {
            $year = $yearInput ?: date('Y');
        } elseif ($filterType === 'custom') {
            if ($startDateInput) {
                $startDate = Carbon::parse($startDateInput)->startOfDay();
            }
            if ($endDateInput) {
                $endDate = Carbon::parse($endDateInput)->endOfDay();
            }
        }

        $data = $this->calculateIncomeStatement($month, $year, $startDate, $endDate);

        if (request('export') === 'excel') {
            return $this->exportCSV($data, $filterType, $month, $year, $startDate, $endDate);
        }

        return view('report.income-statement', array_merge($data, [
            'month' => $month,
            'year' => $year,
            'filterType' => $filterType,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'monthInput' => $monthInput,
            'yearInput' => $yearInput,
        ]));
    }

    private function exportCSV($data, $filterType, $month, $year, $startDate, $endDate)
    {
        $fileName = 'Laporan_Laba_Rugi_'.date('Ymd_His').'.csv';

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($data, $filterType, $month, $year, $startDate, $endDate) {
            $file = fopen('php://output', 'w');
            fwrite($file, (chr(0xEF).chr(0xBB).chr(0xBF)));

            fputcsv($file, ['PABRIK KAYU JAYA ABADI']);
            fputcsv($file, ['Laporan Laba Rugi (Metode Perpetual)']);

            $months = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
            ];

            $periode = 'Semua Data';
            if ($filterType === 'per_bulan') {
                $periode = 'Periode: '.($months[$month] ?? '').' '.$year;
            } elseif ($filterType === 'per_tahun') {
                $periode = 'Tahun: '.$year;
            } elseif ($filterType === 'custom') {
                if ($startDate && $endDate) {
                    $periode = 'Periode: '.date('d/m/Y', strtotime($startDate)).' s/d '.date('d/m/Y', strtotime($endDate));
                } elseif ($startDate) {
                    $periode = 'Dari: '.date('d/m/Y', strtotime($startDate));
                } elseif ($endDate) {
                    $periode = 'Hingga: '.date('d/m/Y', strtotime($endDate));
                }
            }
            fputcsv($file, [$periode]);
            fputcsv($file, []);

            // Pendapatan
            fputcsv($file, ['PENDAPATAN']);
            foreach ($data['revenue_details'] as $item) {
                fputcsv($file, [$item['name'], $item['amount']]);
            }
            fputcsv($file, ['TOTAL PENDAPATAN', $data['total_revenue']]);
            fputcsv($file, []);

            // HPP
            fputcsv($file, ['HARGA POKOK PENJUALAN (HPP)']);
            foreach ($data['hpp_details'] as $item) {
                fputcsv($file, [$item['name'], $item['amount']]);
            }
            fputcsv($file, ['TOTAL HPP', $data['total_hpp']]);
            fputcsv($file, []);

            fputcsv($file, ['LABA KOTOR', $data['gross_profit']]);
            fputcsv($file, []);

            // Biaya Usaha
            fputcsv($file, ['BIAYA OPERASIONAL']);
            foreach ($data['expense_details'] as $item) {
                fputcsv($file, [$item['name'], $item['amount']]);
            }
            fputcsv($file, ['TOTAL BIAYA OPERASIONAL', $data['total_expenses']]);
            fputcsv($file, []);

            fputcsv($file, ['LABA BERSIH', $data['net_income']]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function calculateIncomeStatement($month = null, $year = null, $startDate = null, $endDate = null)
    {
        $query = GeneralJournal::with('account');

        if ($startDate && $endDate) {
            $query->whereBetween('journal_date', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->where('journal_date', '>=', $startDate);
        } elseif ($endDate) {
            $query->where('journal_date', '<=', $endDate);
        } elseif ($month && $year) {
            $query->whereYear('journal_date', $year)->whereMonth('journal_date', $month);
        } elseif ($year) {
            $query->whereYear('journal_date', $year);
        }

        $journals = $query->get();

        $revenue_details = [];
        $hpp_details = [];
        $expense_details = [];

        foreach ($journals as $journal) {
            $account = $journal->account;
            if (!$account) continue;

            $amount = $journal->amount;
            $type = $account->type;
            $name = $account->name;
            $code = $account->code;
            $key = $code . ' - ' . $name;

            if ($type === 'revenue') {
                // Revenue usually normal credit. If debit, it reduces revenue (like Retur)
                $val = ($journal->type === 'credit') ? $amount : -$amount;
                $revenue_details[$key] = ($revenue_details[$key] ?? 0) + $val;
            } elseif ($type === 'cogs') {
                // HPP usually normal debit. If credit, it reduces HPP (like Retur adjustment)
                $val = ($journal->type === 'debit') ? $amount : -$amount;
                $hpp_details[$key] = ($hpp_details[$key] ?? 0) + $val;
            } elseif ($type === 'expense') {
                // Expense normal debit.
                $val = ($journal->type === 'debit') ? $amount : -$amount;
                $expense_details[$key] = ($expense_details[$key] ?? 0) + $val;
            }
        }

        // Format for view
        $formatDetails = function($data) {
            $result = [];
            foreach ($data as $name => $amount) {
                if ($amount != 0) {
                    $result[] = ['name' => $name, 'amount' => $amount];
                }
            }
            return $result;
        };

        $revenue_list = $formatDetails($revenue_details);
        $hpp_list = $formatDetails($hpp_details);
        $expense_list = $formatDetails($expense_details);

        $total_revenue = array_sum(array_column($revenue_list, 'amount'));
        $total_hpp = array_sum(array_column($hpp_list, 'amount'));
        $total_expenses = array_sum(array_column($expense_list, 'amount'));

        $gross_profit = $total_revenue - $total_hpp;
        $net_income = $gross_profit - $total_expenses;

        return [
            'revenue_details' => $revenue_list,
            'hpp_details' => $hpp_list,
            'expense_details' => $expense_list,
            'total_revenue' => $total_revenue,
            'total_hpp' => $total_hpp,
            'total_expenses' => $total_expenses,
            'gross_profit' => $gross_profit,
            'net_income' => $net_income,
        ];
    }

}
