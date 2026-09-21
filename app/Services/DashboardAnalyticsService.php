<?php

namespace App\Services;

use App\Models\ChatMessage;
use App\Models\ChatSession;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class DashboardAnalyticsService
{
    /**
     * Mengambil data tren konsultasi harian, mingguan, dan bulanan (Chatbot AI vs Live Chat Guru BK).
     *
     * @param  int|null  $teacherId  Jika diset, dapat memfilter live chat khusus guru bersangkutan
     * @return array<string, mixed>
     */
    public function getTrendData(?int $teacherId = null): array
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();
        $daysInMonth = $now->daysInMonth;

        // Ambil semua sesi dalam 2 bulan terakhir (bulan ini dan bulan lalu)
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();

        $currentMonthSessions = ChatSession::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->when($teacherId, function ($q) use ($teacherId) {
                $q->where(function ($sub) use ($teacherId) {
                    $sub->where('mode', '!=', 'guru_bk')
                        ->orWhereNull('mode')
                        ->orWhere('teacher_id', $teacherId);
                });
            })
            ->get();

        $lastMonthSessions = ChatSession::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->when($teacherId, function ($q) use ($teacherId) {
                $q->where(function ($sub) use ($teacherId) {
                    $sub->where('mode', '!=', 'guru_bk')
                        ->orWhereNull('mode')
                        ->orWhere('teacher_id', $teacherId);
                });
            })
            ->get();

        // 1. Data Mode Bulanan (Bulan ini per hari 1..daysInMonth)
        $monthDays = [];
        $aiMonthData = [];
        $liveMonthData = [];
        $lastMonthAiData = [];
        $lastMonthLiveData = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $monthDays[] = (string) $day;
            $aiMonthData[] = 0;
            $liveMonthData[] = 0;
            $lastMonthAiData[] = 0;
            $lastMonthLiveData[] = 0;
        }

        foreach ($currentMonthSessions as $session) {
            $dayIndex = (int) $session->created_at->format('j') - 1;
            if ($dayIndex >= 0 && $dayIndex < $daysInMonth) {
                if ($session->mode === 'guru_bk') {
                    $liveMonthData[$dayIndex]++;
                } else {
                    $aiMonthData[$dayIndex]++;
                }
            }
        }

        foreach ($lastMonthSessions as $session) {
            $dayIndex = (int) $session->created_at->format('j') - 1;
            if ($dayIndex >= 0 && $dayIndex < $daysInMonth) {
                if ($session->mode === 'guru_bk') {
                    $lastMonthLiveData[$dayIndex]++;
                } else {
                    $lastMonthAiData[$dayIndex]++;
                }
            }
        }

        // 2. Data Mode Mingguan (7 Hari Terakhir)
        $weekDays = [];
        $aiWeekData = [];
        $liveWeekData = [];

        $startOfWeek = $now->copy()->subDays(6)->startOfDay();
        $recent7DaysSessions = ChatSession::where('created_at', '>=', $startOfWeek)
            ->when($teacherId, function ($q) use ($teacherId) {
                $q->where(function ($sub) use ($teacherId) {
                    $sub->where('mode', '!=', 'guru_bk')
                        ->orWhereNull('mode')
                        ->orWhere('teacher_id', $teacherId);
                });
            })
            ->get();

        for ($i = 6; $i >= 0; $i--) {
            $targetDate = $now->copy()->subDays($i);
            $dayKey = $targetDate->format('Y-m-d');
            $weekDays[] = $targetDate->translatedFormat('D, d M');

            $aiCount = $recent7DaysSessions->filter(function ($s) use ($dayKey) {
                return $s->created_at->format('Y-m-d') === $dayKey && $s->mode !== 'guru_bk';
            })->count();

            $liveCount = $recent7DaysSessions->filter(function ($s) use ($dayKey) {
                return $s->created_at->format('Y-m-d') === $dayKey && $s->mode === 'guru_bk';
            })->count();

            $aiWeekData[] = $aiCount;
            $liveWeekData[] = $liveCount;
        }

        // 3. Data Mode Tahunan (12 Bulan Tahun Berjalan)
        $yearMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $aiYearData = array_fill(0, 12, 0);
        $liveYearData = array_fill(0, 12, 0);

        $currentYearSessions = ChatSession::whereYear('created_at', $now->year)
            ->when($teacherId, function ($q) use ($teacherId) {
                $q->where(function ($sub) use ($teacherId) {
                    $sub->where('mode', '!=', 'guru_bk')
                        ->orWhereNull('mode')
                        ->orWhere('teacher_id', $teacherId);
                });
            })
            ->get();

        foreach ($currentYearSessions as $session) {
            $monthIndex = (int) $session->created_at->format('n') - 1;
            if ($monthIndex >= 0 && $monthIndex < 12) {
                if ($session->mode === 'guru_bk') {
                    $liveYearData[$monthIndex]++;
                } else {
                    $aiYearData[$monthIndex]++;
                }
            }
        }

        // Perhitungan Perbandingan Bulan Ini vs Bulan Lalu
        $totalCurrentMonth = $currentMonthSessions->count();
        $totalLastMonth = $lastMonthSessions->count();
        $diffFromLastMonth = $totalCurrentMonth - $totalLastMonth;
        $pctChange = $totalLastMonth > 0
            ? round((($totalCurrentMonth - $totalLastMonth) / $totalLastMonth) * 100)
            : ($totalCurrentMonth > 0 ? 100 : 0);

        return [
            'month' => [
                'labels' => $monthDays,
                'ai' => $aiMonthData,
                'live' => $liveMonthData,
            ],
            'week' => [
                'labels' => $weekDays,
                'ai' => $aiWeekData,
                'live' => $liveWeekData,
            ],
            'year' => [
                'labels' => $yearMonths,
                'ai' => $aiYearData,
                'live' => $liveYearData,
            ],
            'summary' => [
                'total_current_month' => $totalCurrentMonth,
                'total_last_month' => $totalLastMonth,
                'diff' => $diffFromLastMonth,
                'pct_change' => $pctChange,
                'current_month_name' => $now->translatedFormat('F Y'),
            ],
        ];
    }

    /**
     * Menganalisis topik konseling siswa yang paling sering dibahas.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getPopularTopics(): array
    {
        $userMessages = ChatMessage::where('role', 'user')->pluck('content');
        $totalMessages = $userMessages->count();

        $categories = [
            'Akademik & Studi Lanjut' => [
                'keywords' => ['kuliah', 'snbt', 'snbp', 'jurusan', 'beasiswa', 'kampus', 'ptn', 'nilai', 'tugas', 'rapor'],
                'count' => 0,
                'color' => 'bg-emerald-500',
            ],
            'Manajemen Emosi & Stres' => [
                'keywords' => ['stres', 'cemas', 'panik', 'sedih', 'capek', 'takut', 'marah', 'lelah', 'insecure', 'overthinking'],
                'count' => 0,
                'color' => 'bg-brand-600',
            ],
            'Minat, Bakat & Karir' => [
                'keywords' => ['karir', 'cita-cita', 'bakat', 'minat', 'hobi', 'kerja', 'profesi', 'peluang'],
                'count' => 0,
                'color' => 'bg-amber-500',
            ],
            'Sosial & Hubungan Teman' => [
                'keywords' => ['teman', 'sahabat', 'konflik', 'orang tua', 'keluarga', 'bully', 'pertengkaran', 'pacar'],
                'count' => 0,
                'color' => 'bg-blue-500',
            ],
        ];

        foreach ($userMessages as $msg) {
            $lower = mb_strtolower($msg);
            foreach ($categories as $key => &$data) {
                foreach ($data['keywords'] as $kw) {
                    if (str_contains($lower, $kw)) {
                        $data['count']++;
                        break;
                    }
                }
            }
            unset($data);
        }

        $result = [];
        foreach ($categories as $title => $data) {
            $percentage = $totalMessages > 0 ? round(($data['count'] / $totalMessages) * 100) : 0;
            $result[] = [
                'title' => $title,
                'count' => $data['count'],
                'percentage' => $percentage,
                'color' => $data['color'],
            ];
        }

        // Urutkan dari topik terbanyak
        usort($result, fn ($a, $b) => $b['count'] <=> $a['count']);

        return $result;
    }

    /**
     * Mengambil 10 sesi percakapan terbaru beserta relasi pengguna dan guru.
     */
    public function getRecentSessions(int $limit = 10, ?int $teacherId = null): Collection
    {
        return ChatSession::with(['user', 'teacher', 'messages' => fn ($q) => $q->latest()->take(1)])
            ->when($teacherId, function ($q) use ($teacherId) {
                $q->where(function ($sub) use ($teacherId) {
                    $sub->where('mode', '!=', 'guru_bk')
                        ->orWhereNull('mode')
                        ->orWhere('teacher_id', $teacherId);
                });
            })
            ->latest()
            ->take($limit)
            ->get();
    }
}
