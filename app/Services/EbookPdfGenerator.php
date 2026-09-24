<?php

namespace App\Services;

use App\Models\Ebook;

class EbookPdfGenerator
{
    /**
     * Membuat dokumen PDF resmi berstandar PDF-1.4 dengan tabel xref yang valid secara matematis.
     *
     * @param  array<string, mixed>  $data
     */
    public static function generate(array $data): string
    {
        $title = $data['title'] ?? 'Modul Bimbingan Konseling';
        $subtitle = $data['subtitle'] ?? ($data['subject'] ?? 'Pustaka Edukasi Digital');
        $authors = is_array($data['authors'] ?? null)
            ? implode(', ', $data['authors'])
            : ($data['authors'] ?? 'Tim Konselor SMAN 4 Jember');
        $publisher = $data['publisher'] ?? 'SMAN 4 Jember';
        $year = $data['published_year'] ?? date('Y');
        $category = $data['category'] ?? 'Bimbingan Konseling';
        $classLevel = $data['class_level'] ?? 'Semua Jenjang';
        $source = $data['source'] ?? 'SAPA BK SMAN 4 Jember';
        $description = $data['description'] ?? 'Modul pembelajaran bimbingan konseling dan pengayaan diri bagi siswa SMA.';

        // Sanitasi teks agar aman untuk WinAnsiEncoding PDF
        $clean = fn (string $str, int $max = 120): string => substr(trim(preg_replace('/[^a-zA-Z0-9 .,!?()_:\-\/]/', ' ', $str)), 0, $max);
        $esc = fn (string $str): string => str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $str);

        $safeTitle = $clean($title, 80);
        $safeSubtitle = $clean($subtitle, 85);
        $safeAuthors = $clean($authors, 90);
        $safePublisher = $clean($publisher, 75);
        $safeSource = $clean($source, 60);

        // Bungkus deskripsi menjadi beberapa baris yang rapi (word wrapping)
        $words = explode(' ', preg_replace('/[^a-zA-Z0-9 .,!?()_:\-\/]/', ' ', $description));
        $descLines = [];
        $curLine = '';
        foreach ($words as $word) {
            if ($word === '') {
                continue;
            }
            if (strlen($curLine.' '.$word) > 82) {
                $descLines[] = trim($curLine);
                $curLine = $word;
            } else {
                $curLine .= ' '.$word;
            }
        }
        if (trim($curLine) !== '') {
            $descLines[] = trim($curLine);
        }

        // Susun stream grafis dan teks PDF (Ukuran Halaman A4: 595 x 842 pt)
        $stream = "q\n";

        // 1. Header Banner Atas (Hijau Khas SAPA BK: #15803d -> RGB 0.082 0.502 0.239)
        $stream .= "0.082 0.502 0.239 rg 0 740 595 102 re f\n";

        // Garis pemanis emas di bawah banner
        $stream .= "0.85 0.65 0.13 rg 0 736 595 4 re f\n";

        // Teks Header Banner
        $stream .= "BT\n";
        $stream .= "/F1 9 Tf\n";
        $stream .= "0.85 0.98 0.88 rg\n";
        $stream .= "42 812 Td\n";
        $stream .= '('.$esc('SAPA BK - PERPUSTAKAAN DIGITAL SMA NEGERI 4 JEMBER').") Tj\n";

        $stream .= "/F1 16 Tf\n";
        $stream .= "1 1 1 rg\n";
        $stream .= "0 -24 Td\n";
        $stream .= '('.$esc($safeTitle).") Tj\n";

        $stream .= "/F2 10.5 Tf\n";
        $stream .= "0.92 0.96 0.93 rg\n";
        $stream .= "0 -18 Td\n";
        $stream .= '('.$esc($safeSubtitle.' | '.$safeSource).") Tj\n";
        $stream .= "ET\n";

        // 2. Kotak Metadata Informasi Buku
        $stream .= "0.96 0.98 0.96 rg 40 615 515 95 re f\n";
        $stream .= "0.80 0.88 0.82 RG 1 w 40 615 515 95 re S\n";

        $stream .= "BT\n";
        $stream .= "/F1 10 Tf\n";
        $stream .= "0.082 0.502 0.239 rg\n";
        $stream .= "55 690 Td\n";
        $stream .= '('.$esc('Informasi Dokumen & Penerbit Resmi:').") Tj\n";

        $stream .= "/F2 9.5 Tf\n";
        $stream .= "0.15 0.15 0.15 rg\n";
        $stream .= "0 -16 Td\n";
        $stream .= '('.$esc('Penyusun / Penulis : '.$safeAuthors).") Tj\n";
        $stream .= "0 -15 Td\n";
        $stream .= '('.$esc('Penerbit Resmi     : '.$safePublisher.' (Tahun '.$year.')').") Tj\n";
        $stream .= "0 -15 Td\n";
        $stream .= '('.$esc('Jenjang & Bidang   : '.$clean($classLevel, 30).' | '.$clean($category, 45)).") Tj\n";
        $stream .= "ET\n";

        // 3. Pokok Bahasan & Sinopsis Materi
        $stream .= "BT\n";
        $stream .= "/F1 12 Tf\n";
        $stream .= "0.10 0.15 0.12 rg\n";
        $stream .= "42 575 Td\n";
        $stream .= '('.$esc('Sinopsis & Pokok Bahasan Modul:').") Tj\n";

        $stream .= "/F2 10 Tf\n";
        $stream .= "0.22 0.22 0.22 rg\n";
        $yDelta = -20;
        foreach (array_slice($descLines, 0, 11) as $line) {
            $stream .= "0 {$yDelta} Td\n";
            $stream .= '('.$esc($line).") Tj\n";
            $yDelta = -16;
        }
        $stream .= "ET\n";

        // 4. Kotak Bimbingan & Konseling Sekolah
        $stream .= "0.94 0.97 0.99 rg 40 160 515 115 re f\n";
        $stream .= "0.20 0.45 0.75 RG 1.2 w 40 160 515 115 re S\n";

        $stream .= "BT\n";
        $stream .= "/F1 11 Tf\n";
        $stream .= "0.12 0.35 0.65 rg\n";
        $stream .= "55 252 Td\n";
        $stream .= '('.$esc('Layanan Bimbingan Konseling SMAN 4 Jember:').") Tj\n";

        $stream .= "/F2 9.5 Tf\n";
        $stream .= "0.18 0.18 0.18 rg\n";
        $stream .= "0 -18 Td\n";
        $stream .= '('.$esc('1. Modul pembelajaran ini disediakan secara resmi sebagai bahan pengayaan siswa.').") Tj\n";
        $stream .= "0 -16 Td\n";
        $stream .= '('.$esc('2. Siswa dapat berdiskusi mengenai topik modul ini bersama Guru BK di sekolah.').") Tj\n";
        $stream .= "0 -16 Td\n";
        $stream .= '('.$esc('3. Gunakan fitur Live Chat Konseling di aplikasi SAPA BK untuk konsultasi pribadi.').") Tj\n";
        $stream .= "0 -16 Td\n";
        $stream .= '('.$esc('4. Ruang Konseling SMAN 4 Jember senantiasa terbuka mendampingi proses belajar Anda.').") Tj\n";
        $stream .= "ET\n";

        // 5. Footer Dokumen
        $stream .= "0.85 0.85 0.85 RG 0.8 w 40 85 515 0.1 re S\n";
        $stream .= "BT\n";
        $stream .= "/F2 8.5 Tf\n";
        $stream .= "0.45 0.45 0.45 rg\n";
        $stream .= "42 68 Td\n";
        $stream .= '('.$esc('Dokumen Resmi SAPA BK - Sistem Administrasi & Pelayanan Konseling SMAN 4 Jember').") Tj\n";
        $stream .= "400 0 Td\n";
        $stream .= '('.$esc('Halaman 1 dari 1').") Tj\n";
        $stream .= "ET\n";

        $stream .= "Q\n";

        $streamLen = strlen($stream);

        // Bangun objek-objek PDF dan hitung offset byte secara presisi
        $objects = [
            1 => '<< /Type /Catalog /Pages 2 0 R >>',
            2 => '<< /Type /Pages /Kids [3 0 R] /Count 1 >>',
            3 => '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Contents 4 0 R /Resources << /Font << /F1 5 0 R /F2 6 0 R >> >> >>',
            4 => "<< /Length {$streamLen} >>\nstream\n{$stream}\nendstream",
            5 => '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold /Encoding /WinAnsiEncoding >>',
            6 => '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica /Encoding /WinAnsiEncoding >>',
        ];

        $out = "%PDF-1.4\n%\xe2\xe3\xcf\xd3\n";
        $offsets = [];

        foreach ($objects as $id => $obj) {
            $offsets[$id] = strlen($out);
            $out .= "{$id} 0 obj\n{$obj}\nendobj\n";
        }

        $xrefStart = strlen($out);
        $totalObjs = count($objects) + 1;

        $out .= "xref\n0 {$totalObjs}\n";
        $out .= "0000000000 65535 f \n";
        for ($i = 1; $i <= count($objects); $i++) {
            $out .= sprintf("%010d 00000 n \n", $offsets[$i]);
        }

        $out .= "trailer\n<< /Size {$totalObjs} /Root 1 0 R >>\n";
        $out .= "startxref\n{$xrefStart}\n%%EOF\n";

        return $out;
    }

    /**
     * Membangun berkas PDF untuk model internal Ebook database.
     */
    public static function generateForInternalEbook(Ebook $ebook, string $targetPath): bool
    {
        $dir = dirname($targetPath);
        if (! is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        @chmod($dir, 0775);

        $pdfContent = self::generate([
            'title' => $ebook->title ?? 'Modul Bimbingan Guru BK',
            'subtitle' => 'Modul Layanan Bimbingan & Konseling Siswa',
            'authors' => 'Tim Guru BK SMAN 4 Jember',
            'publisher' => 'SMAN 4 Jember',
            'published_year' => $ebook->created_at ? $ebook->created_at->format('Y') : date('Y'),
            'category' => 'Modul Internal Konseling',
            'class_level' => 'Semua Siswa SMAN 4 Jember',
            'source' => 'Guru BK SMAN 4 Jember',
            'description' => $ebook->description ?? 'Modul bimbingan konseling untuk pendampingan akademik, sosial, dan karir peserta didik.',
        ]);

        try {
            return @file_put_contents($targetPath, $pdfContent) !== false;
        } catch (\Throwable) {
            return false;
        }
    }
}
