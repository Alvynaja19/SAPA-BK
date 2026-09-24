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

        // 1. Modul Internal Guru BK dari Database
        $ebooks = Ebook::all();
        $this->info("Memproses {$ebooks->count()} modul internal...");
        foreach ($ebooks as $ebook) {
            $filename = basename($ebook->file_path ?: "modul_{$ebook->id}.pdf");
            if (! str_ends_with(strtolower($filename), '.pdf')) {
                $filename .= '.pdf';
            }
            $targetPath = storage_path("app/public/ebooks/{$filename}");
            $ok = EbookPdfGenerator::generateForInternalEbook($ebook, $targetPath);
            if ($ok) {
                $this->line("  [OK] Modul Internal: {$ebook->title} -> {$filename}");
            } else {
                $this->error("  [FAIL] Gagal membuat modul internal: {$ebook->title}");
            }
        }

        // 2. Modul Kurasi (Kemenkes, UNICEF, SIBI, dsb)
        $curatedBooks = CuratedEbookCatalog::all();
        $this->info('Memproses '.count($curatedBooks).' buku kurasi resmi...');
        foreach ($curatedBooks as $book) {
            $id = $book['id'];
            $targetPath = storage_path("app/public/ebooks/curated/{$id}.pdf");
            $ok = EbookPdfGenerator::generateForCuratedBook($book, $targetPath);
            if ($ok) {
                $this->line("  [OK] Kurasi: {$book['title']} -> {$id}.pdf");
            } else {
                $this->error("  [FAIL] Gagal membuat buku kurasi: {$id}");
            }
        }

        $this->info('Seluruh berkas PDF berhasil diperbaiki dan siap dibaca!');

        return Command::SUCCESS;
    }
}
