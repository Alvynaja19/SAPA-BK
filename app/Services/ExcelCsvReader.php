<?php

namespace App\Services;

use Exception;
use SimpleXMLElement;
use ZipArchive;

class ExcelCsvReader
{
    /**
     * Membaca file CSV atau XLSX dan mengembalikannya sebagai array baris.
     *
     * @return array<int, array<int, string>>
     */
    public function read(string $filePath, ?string $extension = null): array
    {
        $ext = strtolower($extension ?: pathinfo($filePath, PATHINFO_EXTENSION));

        return match ($ext) {
            'xlsx' => $this->readXlsx($filePath),
            'csv', 'txt' => $this->readCsv($filePath),
            default => throw new Exception("Format file '{$ext}' tidak didukung. Harap gunakan file .csv atau .xlsx."),
        };
    }

    /**
     * Membaca file CSV dengan deteksi delimiter otomatis (koma, titik koma, tab).
     *
     * @return array<int, array<int, string>>
     */
    protected function readCsv(string $filePath): array
    {
        $handle = fopen($filePath, 'r');
        if (! $handle) {
            throw new Exception('Gagal membuka file CSV.');
        }

        // Hapus BOM UTF-8 jika ada
        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            rewind($handle);
        }

        $rows = [];
        $delimiter = ',';

        // Deteksi delimiter dari baris pertama
        $firstLine = fgets($handle);
        if ($firstLine !== false) {
            if (substr_count($firstLine, ';') > substr_count($firstLine, ',')) {
                $delimiter = ';';
            } elseif (substr_count($firstLine, "\t") > substr_count($firstLine, ',')) {
                $delimiter = "\t";
            }
            rewind($handle);
            if ($bom === "\xEF\xBB\xBF") {
                fread($handle, 3);
            }
        }

        while (($data = fgetcsv($handle, 2048, $delimiter)) !== false) {
            // Trim setiap cell
            $cleanRow = array_map(fn ($cell) => trim((string) $cell), $data);
            // Abaikan baris yang seluruhnya kosong
            if (count(array_filter($cleanRow, fn ($v) => $v !== '')) > 0) {
                $rows[] = $cleanRow;
            }
        }

        fclose($handle);

        return $rows;
    }

    /**
     * Membaca file XLSX menggunakan ZipArchive dan SimpleXML bawaan PHP tanpa dependensi eksternal.
     *
     * @return array<int, array<int, string>>
     */
    protected function readXlsx(string $filePath): array
    {
        $zip = new ZipArchive;
        if ($zip->open($filePath) !== true) {
            throw new Exception('Gagal membuka file Excel (.xlsx). Pastikan file tidak rusak.');
        }

        // 1. Baca sharedStrings.xml jika ada
        $sharedStrings = [];
        $sharedStringsXml = $zip->getFromName('xl/sharedStrings.xml');
        if ($sharedStringsXml !== false) {
            $xml = new SimpleXMLElement($sharedStringsXml);
            foreach ($xml->si as $si) {
                if (isset($si->t)) {
                    $sharedStrings[] = (string) $si->t;
                } elseif (isset($si->r)) {
                    $text = '';
                    foreach ($si->r as $r) {
                        $text .= (string) $r->t;
                    }
                    $sharedStrings[] = $text;
                } else {
                    $sharedStrings[] = '';
                }
            }
        }

        // 2. Baca sheet1.xml
        $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
        if ($sheetXml === false) {
            $zip->close();
            throw new Exception('Tidak ditemukan worksheet pada file Excel ini.');
        }

        $xml = new SimpleXMLElement($sheetXml);
        $rows = [];

        if (isset($xml->sheetData->row)) {
            foreach ($xml->sheetData->row as $row) {
                $rowData = [];
                $currentIndex = 0;

                foreach ($row->c as $cell) {
                    $cellRef = (string) $cell['r'];
                    $colLetter = preg_replace('/[0-9]/', '', $cellRef);
                    $colIndex = $this->columnLetterToIndex($colLetter);

                    // Isi sel kosong sebelumnya jika dilewati
                    while ($currentIndex < $colIndex) {
                        $rowData[] = '';
                        $currentIndex++;
                    }

                    $val = isset($cell->v) ? (string) $cell->v : '';
                    $type = (string) $cell['t'];

                    if ($type === 's' && isset($sharedStrings[(int) $val])) {
                        $val = $sharedStrings[(int) $val];
                    } elseif ($type === 'inlineStr' && isset($cell->is->t)) {
                        $val = (string) $cell->is->t;
                    }

                    $rowData[] = trim($val);
                    $currentIndex++;
                }

                if (count(array_filter($rowData, fn ($v) => $v !== '')) > 0) {
                    $rows[] = $rowData;
                }
            }
        }

        $zip->close();

        return $rows;
    }

    /**
     * Mengubah huruf kolom Excel (A, B, ..., Z, AA, AB) menjadi indeks integer 0-based.
     */
    protected function columnLetterToIndex(string $letters): int
    {
        $letters = strtoupper($letters);
        $index = 0;
        $len = strlen($letters);

        for ($i = 0; $i < $len; $i++) {
            $index = $index * 26 + (ord($letters[$i]) - 64);
        }

        return max(0, $index - 1);
    }
}
