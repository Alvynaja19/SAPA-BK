<?php

namespace App\Console\Commands;

use App\Models\Ebook;
use App\Services\CuratedEbookCatalog;
use App\Services\EbookPdfGenerator;
use Illuminate\Console\Command;

class RefreshEbookPdfs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ebook:refresh-pdf';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membuat dan memperbaiki seluruh berkas PDF e-book kurasi dan modul internal dengan standar PDF-1.4 valid';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Memulai regenerasi berkas PDF resmi e-book...');

        $failedCount = 0;

        // 1. Modul Internal Guru BK dari Database
        $ebooks = Ebook::all();
        $this->info("Memproses {$ebooks->count()} modul internal...");
        foreach ($ebooks as $ebook) {
            $filename = basename($ebook->file_path ?: "modul_{$ebook->id}.pdf");
            if (! str_ends_with(strtolower($filename), '.pdf')) {
                $filename .= '.pdf';
            }
            $targetPath = storage_path("app/public/ebooks/{$filename}");
            try {
                $ok = EbookPdfGenerator::generateForInternalEbook($ebook, $targetPath);
                if ($ok) {
                    $this->line("  [OK] Modul Internal: {$ebook->title} -> {$filename}");
                } else {
                    $failedCount++;
                    $this->error("  [FAIL] Izin tulis ditolak untuk modul: {$ebook->title}");
                }
            } catch (\Throwable $e) {
                $failedCount++;
                $this->error("  [FAIL] Error: {$e->getMessage()}");
            }
        }

        // 2. Modul Kurasi (Kemenkes, UNICEF, SIBI, dsb)
        $curatedBooks = CuratedEbookCatalog::all();
        $this->info('Memproses '.count($curatedBooks).' buku kurasi resmi...');
        foreach ($curatedBooks as $book) {
            $id = $book['id'];
            $targetPath = storage_path("app/public/ebooks/curated/{$id}.pdf");
            try {
                $ok = EbookPdfGenerator::generateForCuratedBook($book, $targetPath);
                if ($ok) {
                    $this->line("  [OK] Kurasi: {$book['title']} -> {$id}.pdf");
                } else {
                    $failedCount++;
                    $this->error("  [FAIL] Izin tulis ditolak untuk buku: {$book['title']}");
                }
            } catch (\Throwable $e) {
                $failedCount++;
                $this->error("  [FAIL] Error: {$e->getMessage()}");
            }
        }

        if ($failedCount > 0) {
            $this->warn("\nAda {$failedCount} berkas yang gagal ditulis karena kendala izin akses direktori server.");
            $this->warn('Silakan jalankan perintah perbaikan izin akses berikut di terminal server:');
            $this->line('  sudo chown -R ubuntu:www-data storage bootstrap/cache');
            $this->line('  sudo chmod -R 775 storage bootstrap/cache');
            $this->line('Lalu jalankan kembali: php artisan ebook:refresh-pdf');

            return Command::FAILURE;
        }

        $this->info('Seluruh berkas PDF berhasil diperbaiki dan siap dibaca!');

        return Command::SUCCESS;
    }
}
