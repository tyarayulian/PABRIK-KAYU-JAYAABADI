<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\GeneralJournal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class JurnalUmumController extends Controller
{
    public function index(Request $request)
    {
        // Auto-sync before displaying
        GeneralJournal::syncAll();

        $filterType = $request->input('filter_type', 'per_bulan');
        $year = $request->input('year', Carbon::now()->year);
        $monthInput = $request->input('month');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($startDate) {
            $startDate = Carbon::parse($startDate)->startOfDay();
        }
        if ($endDate) {
            $endDate = Carbon::parse($endDate)->endOfDay();
        }
        $search = $request->input('search');

        $month = null;
        if ($filterType === 'per_bulan') {
            if ($monthInput) {
                $date = Carbon::parse($monthInput);
                $month = $date->month;
                $year = $date->year;
            } else {
                $month = Carbon::now()->month;
                $year = Carbon::now()->year;
            }
        }

        $query = GeneralJournal::with('account');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('account', function ($qa) use ($search) {
                    $qa->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            });
        }

        if ($filterType === 'per_bulan') {
            $query->whereYear('journal_date', $year)
                ->whereMonth('journal_date', $month);
        } elseif ($filterType === 'per_tahun') {
            $query->whereYear('journal_date', $year);
        } elseif ($filterType === 'custom' && $startDate && $endDate) {
            $query->whereBetween('journal_date', [$startDate, $endDate]);
        }

        $journals = $query->orderBy('journal_date', 'asc')->orderBy('id', 'asc')->get();

        $totalDebit = $journals->where('type', 'debit')->sum('amount');
        $totalCredit = $journals->where('type', 'credit')->sum('amount');

        // Build lookup: reference -> all entries (for counter account codes)
        $refEntries = [];
        foreach ($journals as $journal) {
            $key = $journal->reference ?? ($journal->journal_date->format('Y-m-d H:i:s').'|'.$journal->source_id.'|'.$journal->id);
            $refEntries[$key][] = $journal;
        }

        $groupedJournalsRaw = [];
        foreach ($journals as $journal) {
            $key = $journal->reference ?? ($journal->journal_date->format('Y-m-d H:i:s').'|'.$journal->source_id.'|'.$journal->id);

            if (! isset($groupedJournalsRaw[$key])) {
                $groupedJournalsRaw[$key] = [
                    'id' => $journal->source_id ?? null,
                    'date' => $journal->journal_date,
                    'description' => $journal->description,
                    'reference' => $journal->reference,
                    'entries' => [],
                ];
            }

            $groupedJournalsRaw[$key]['entries'][] = $journal;
        }

        // Sort entries in each group (debit before credit)
        foreach ($groupedJournalsRaw as &$group) {
            usort($group['entries'], function ($a, $b) {
                if ($a->type === $b->type) {
                    return 0;
                }
                return $a->type === 'debit' ? -1 : 1;
            });

            // Ref = nomor akun sendiri (standar akuntansi)
            foreach ($group['entries'] as &$entry) {
                $entry->ref_display = $entry->account->code ?? '-';
            }
            unset($entry);
        }
        unset($group);

        // Convert to collection for pagination
        $groupedCollection = collect(array_values($groupedJournalsRaw));

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $currentPageItems = $groupedCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $journals = new LengthAwarePaginator(
            $currentPageItems,
            $groupedCollection->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $years = range(Carbon::now()->year - 5, Carbon::now()->year + 1);
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        return view('report.jurnal_umum.index', compact('journals', 'totalDebit', 'totalCredit', 'year', 'month', 'years', 'months', 'filterType', 'startDate', 'endDate', 'search'));
    }

    public function sync()
    {
        if (GeneralJournal::syncAll()) {
            return redirect()->back()->with('success', 'Data jurnal dan buku besar berhasil disinkronkan.');
        } else {
            return redirect()->back()->with('error', 'Gagal sinkronisasi data.');
        }
    }

    public function print(Request $request)
    {
        // Auto-sync before displaying
        GeneralJournal::syncAll();

        $filterType = $request->input('filter_type', 'per_bulan');
        $year = $request->input('year', Carbon::now()->year);
        $monthInput = $request->input('month');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($startDate) {
            $startDate = Carbon::parse($startDate)->startOfDay();
        }
        if ($endDate) {
            $endDate = Carbon::parse($endDate)->endOfDay();
        }

        $month = null;
        if ($filterType === 'per_bulan') {
            if ($monthInput) {
                $date = Carbon::parse($monthInput);
                $month = $date->month;
                $year = $date->year;
            } else {
                $month = Carbon::now()->month;
                $year = Carbon::now()->year;
            }
        }

        $query = GeneralJournal::with('account');

        if ($filterType === 'per_bulan') {
            $query->whereYear('journal_date', $year)
                ->whereMonth('journal_date', $month);
        } elseif ($filterType === 'per_tahun') {
            $query->whereYear('journal_date', $year);
        } elseif ($filterType === 'custom' && $startDate && $endDate) {
            $query->whereBetween('journal_date', [$startDate, $endDate]);
        }

        $journals = $query->orderBy('journal_date', 'asc')->orderBy('id', 'asc')->get();

        $totalDebit = $journals->where('type', 'debit')->sum('amount');
        $totalCredit = $journals->where('type', 'credit')->sum('amount');

        $groupedJournalsRaw = [];
        foreach ($journals as $journal) {
            $key = $journal->reference ?? ($journal->journal_date->format('Y-m-d H:i:s').'|'.$journal->source_id.'|'.$journal->id);

            if (! isset($groupedJournalsRaw[$key])) {
                $groupedJournalsRaw[$key] = [
                    'id' => $journal->source_id ?? null,
                    'date' => $journal->journal_date,
                    'description' => $journal->description,
                    'reference' => $journal->reference,
                    'entries' => [],
                ];
            }

            $groupedJournalsRaw[$key]['entries'][] = $journal;
        }

        // Sort entries in each group (debit before credit) & attach ref_display
        foreach ($groupedJournalsRaw as &$group) {
            usort($group['entries'], function ($a, $b) {
                if ($a->type === $b->type) return 0;
                return $a->type === 'debit' ? -1 : 1;
            });

            // Ref = nomor akun sendiri (standar akuntansi)
            foreach ($group['entries'] as &$entry) {
                $entry->ref_display = $entry->account->code ?? '-';
            }
            unset($entry);
        }
        unset($group);

        // Convert to collection WITHOUT pagination for print
        $groupedCollection = collect(array_values($groupedJournalsRaw));

        // Create fake paginator for compatibility with view
        $journals = new LengthAwarePaginator(
            $groupedCollection->all(),
            $groupedCollection->count(),
            $groupedCollection->count(), // Show all items
            1, // Always page 1
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('report.jurnal_umum.print', compact('journals', 'totalDebit', 'totalCredit', 'year', 'month', 'filterType', 'startDate', 'endDate'));
    }

    public function exportExcel(Request $request)
    {
        // Auto-sync before exporting
        GeneralJournal::syncAll();
        $filterType = $request->input('filter_type', 'per_bulan');
        $year = $request->input('year', Carbon::now()->year);
        $monthInput = $request->input('month');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($startDate) {
            $startDate = Carbon::parse($startDate)->startOfDay();
        }
        if ($endDate) {
            $endDate = Carbon::parse($endDate)->endOfDay();
        }
        $search = $request->input('search');

        $month = null;
        if ($filterType === 'per_bulan') {
            if ($monthInput) {
                $date = Carbon::parse($monthInput);
                $month = $date->month;
                $year = $date->year;
            }
        }

        $query = GeneralJournal::with('account');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('account', function ($qa) use ($search) {
                    $qa->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            });
        }

        if ($filterType === 'per_bulan') {
            $query->whereYear('journal_date', $year)
                ->whereMonth('journal_date', $month);
        } elseif ($filterType === 'per_tahun') {
            $query->whereYear('journal_date', $year);
        } elseif ($filterType === 'custom' && $startDate && $endDate) {
            $query->whereBetween('journal_date', [$startDate, $endDate]);
        }

        $journals = $query->orderBy('journal_date', 'asc')->orderBy('id', 'asc')->get();

        // Group journals and attach ref_display (same as index/print)
        $groupedJournalsRaw = [];
        foreach ($journals as $journal) {
            $key = $journal->reference ?? ($journal->journal_date->format('Y-m-d H:i:s').'|'.$journal->source_id.'|'.$journal->id);

            if (! isset($groupedJournalsRaw[$key])) {
                $groupedJournalsRaw[$key] = [
                    'id' => $journal->source_id ?? null,
                    'date' => $journal->journal_date,
                    'description' => $journal->description,
                    'reference' => $journal->reference,
                    'entries' => [],
                ];
            }

            $groupedJournalsRaw[$key]['entries'][] = $journal;
        }

        // Sort entries and attach ref_display
        foreach ($groupedJournalsRaw as &$group) {
            usort($group['entries'], function ($a, $b) {
                if ($a->type === $b->type) return 0;
                return $a->type === 'debit' ? -1 : 1;
            });

            // Ref = nomor akun sendiri (standar akuntansi)
            foreach ($group['entries'] as &$entry) {
                $entry->ref_display = $entry->account->code ?? '-';
            }
            unset($entry);
        }
        unset($group);

        // Flatten back to collection for CSV export
        $journalsFlat = collect();
        foreach ($groupedJournalsRaw as $group) {
            foreach ($group['entries'] as $entry) {
                $journalsFlat->push($entry);
            }
        }
        $journals = $journalsFlat;

        $fileName = 'Jurnal_Umum_'.date('Ymd_His').'.csv';

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($journals, $filterType, $month, $year, $startDate, $endDate) {
            $file = fopen('php://output', 'w');
            fwrite($file, (chr(0xEF).chr(0xBB).chr(0xBF)));

            fputcsv($file, ['PABRIK KAYU JAYA ABADI']);
            fputcsv($file, ['Jurnal Umum']);

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
                $periode = 'Periode: '.($startDate ? $startDate->format('d/m/Y') : '').' s/d '.($endDate ? $endDate->format('d/m/Y') : '');
            }
            fputcsv($file, [$periode]);
            fputcsv($file, []);

            fputcsv($file, ['No', 'Tanggal', 'Kode Akun', 'Nama Akun', 'Ref', 'Debit (Rp)', 'Kredit (Rp)']);

            $totalDebit = 0;
            $totalCredit = 0;
            $no = 1;
            $lastRef = null;

            foreach ($journals as $j) {
                $debit = $j->type === 'debit' ? $j->amount : 0;
                $credit = $j->type === 'credit' ? $j->amount : 0;

                $currentRef = $j->reference ?? ($j->journal_date->format('Y-m-d H:i:s').'|'.$j->source_id.'|'.$j->id);
                $isNewTransaction = ($currentRef !== $lastRef);

                fputcsv($file, [
                    $isNewTransaction ? $no++ : '',
                    $isNewTransaction ? $j->journal_date->format('d/m/Y') : '',
                    $j->account->code ?? '-',
                    $j->account->name ?? '-',
                    $j->ref_display ?? '-',
                    $debit ?: 0,
                    $credit ?: 0,
                ]);

                $lastRef = $currentRef;
                $totalDebit += $debit;
                $totalCredit += $credit;
            }

            fputcsv($file, []);
            fputcsv($file, ['', '', '', '', '', 'TOTAL', $totalDebit, $totalCredit]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
