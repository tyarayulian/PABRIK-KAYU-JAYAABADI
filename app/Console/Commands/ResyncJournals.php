<?php

namespace App\Console\Commands;

use App\Models\KasKeluar;
use App\Models\KasMasuk;
use Illuminate\Console\Command;

class ResyncJournals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:resync-journals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resync all journal entries for kas_masuk and kas_keluar';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting journal resync...');

        $this->info('Re-syncing all kas_masuk entries...');
        $kasMasuk = KasMasuk::all();
        foreach ($kasMasuk as $km) {
            try {
                $km->syncJournalEntry();
                $this->info("✓ KM-{$km->id}");
            } catch (\Exception $e) {
                $this->error("✗ KM-{$km->id}: {$e->getMessage()}");
            }
        }

        $this->info('Re-syncing all kas_keluar entries...');
        $kasKeluar = KasKeluar::all();
        foreach ($kasKeluar as $kk) {
            try {
                $kk->syncJournalEntry();
                $this->info("✓ KK-{$kk->id}");
            } catch (\Exception $e) {
                $this->error("✗ KK-{$kk->id}: {$e->getMessage()}");
            }
        }

        $this->info('Journal resync completed!');
    }
}
