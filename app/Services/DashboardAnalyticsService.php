<?php

namespace App\Services;

use App\Models\ChatMessage;
use App\Models\ChatSession;
use App\Models\QuestionnaireResult;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class DashboardAnalyticsService
{
    /**
     * Mengambil data tren konsultasi harian, mingguan, dan bulanan (Chatbot AI vs Live Chat Guru BK).
     *
     * @param  int|null  $teacherId  Jika diset, memfilter live chat khusus guru bersangkutan
     * @return array<string, mixed>
     */
    public function getTrendData(?int $teacherId = null): array
    {
        $now = Carbon::now();

        // 1. Data Mode Mingguan (7 Hari Terakhir)
        $startOfWeek = $now->copy()->subDays(6)->startOfDay();
        $endOfWeek = $now->copy()->endOfDay();
        $startOfPrevWeek = $startOfWeek->copy()->subDays(7);
        $endOfPrevWeek = $startOfWeek->copy()->subSecond();

        $weekSessions = ChatSession::whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->when($teacherId, function ($q) use ($teacherId) {
                $q->where(function ($sub) use ($teacherId) {
                    $sub->where('mode', '!=', 'guru_bk')
                        ->orWhereNull('mode')
                        ->orWhere('teacher_id', $teacherId);
                });
            })
            ->get();

        $prevWeekSessions = ChatSession::whereBetween('created_at', [$startOfPrevWeek, $endOfPrevWeek])
            ->when($teacherId, function ($q) use ($teacherId) {
                $q->where(function ($sub) use ($teacherId) {
                    $sub->where('mode', '!=', 'guru_bk')
                        ->orWhereNull('mode')
                        ->orWhere('teacher_id', $teacherId);
                });
            })
            ->get();

        $weekDays = [];
        $aiWeekData = [];
        $liveWeekData = [];

        for ($i = 6; $i >= 0; $i--) {
            $targetDate = $now->copy()->subDays($i);
            $dayKey = $targetDate->format('Y-m-d');
            $weekDays[] = $targetDate->translatedFormat('D, d M');

            $aiCount = $weekSessions->filter(function ($s) use ($dayKey) {
                return $s->created_at->format('Y-m-d') === $dayKey && $s->mode !== 'guru_bk';
            })->count();

            $liveCount = $weekSessions->filter(function ($s) use ($dayKey) {
                return $s->created_at->format('Y-m-d') === $dayKey && $s->mode === 'guru_bk';
            })->count();

            $aiWeekData[] = $aiCount;
            $liveWeekData[] = $liveCount;
        }

        $totalWeek = $weekSessions->count();
        $prevTotalWeek = $prevWeekSessions->count();
        $weekDiff = $totalWeek - $prevTotalWeek;
        $pctWeek = $prevTotalWeek > 0 ? round(($weekDiff / $prevTotalWeek) * 100, 1) : ($totalWeek > 0 ? 100 : 0);

        $aiWeekTotal = $weekSessions->filter(fn ($s) => $s->mode !== 'guru_bk')->count();
        $prevAiWeekTotal = $prevWeekSessions->filter(fn ($s) => $s->mode !== 'guru_bk')->count();
        $pctAiWeek = $prevAiWeekTotal > 0 ? round((($aiWeekTotal - $prevAiWeekTotal) / $prevAiWeekTotal) * 100, 1) : ($aiWeekTotal > 0 ? 100 : 0);

        $liveWeekTotal = $weekSessions->filter(fn ($s) => $s->mode === 'guru_bk')->count();
        $prevLiveWeekTotal = $prevWeekSessions->filter(fn ($s) => $s->mode === 'guru_bk')->count();
        $pctLiveWeek = $prevLiveWeekTotal > 0 ? round((($liveWeekTotal - $prevLiveWeekTotal) / $prevLiveWeekTotal) * 100, 1) : ($liveWeekTotal > 0 ? 100 : 0);

        // 2. Data Mode Bulanan (5 Minggu di Bulan Berjalan - Sesuai Tampilan Desain)
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();
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

        // Bagi menjadi 5 minggu bulan berjalan:
        // Minggu 1: Hari 1-7, Minggu 2: 8-14, Minggu 3: 15-21, Minggu 4: 22-28, Minggu 5: 29-akhir
        $monthWeeksLabels = ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4', 'Minggu 5'];
        $aiMonthWeeksData = [0, 0, 0, 0, 0];
        $liveMonthWeeksData = [0, 0, 0, 0, 0];

        foreach ($currentMonthSessions as $session) {
            $day = (int) $session->created_at->format('j');
            if ($day <= 7) {
                $wIndex = 0;
            } elseif ($day <= 14) {
                $wIndex = 1;
            } elseif ($day <= 21) {
                $wIndex = 2;
            } elseif ($day <= 28) {
                $wIndex = 3;
            } else {
                $wIndex = 4;
            }

            if ($session->mode === 'guru_bk') {
                $liveMonthWeeksData[$wIndex]++;
            } else {
                $aiMonthWeeksData[$wIndex]++;
            }
        }

        $totalCurrentMonth = $currentMonthSessions->count();
        $totalLastMonth = $lastMonthSessions->count();
        $diffMonth = $totalCurrentMonth - $totalLastMonth;
        $pctMonth = $totalLastMonth > 0 ? round(($diffMonth / $totalLastMonth) * 100, 1) : ($totalCurrentMonth > 0 ? 100 : 0);

        $aiCurrentMonth = $currentMonthSessions->filter(fn ($s) => $s->mode !== 'guru_bk')->count();
        $aiLastMonth = $lastMonthSessions->filter(fn ($s) => $s->mode !== 'guru_bk')->count();
        $pctChangeAiMonth = $aiLastMonth > 0 ? round((($aiCurrentMonth - $aiLastMonth) / $aiLastMonth) * 100, 1) : ($aiCurrentMonth > 0 ? 100 : 0);

        $liveCurrentMonth = $currentMonthSessions->filter(fn ($s) => $s->mode === 'guru_bk')->count();
        $liveLastMonth = $lastMonthSessions->filter(fn ($s) => $s->mode === 'guru_bk')->count();
        $pctChangeLiveMonth = $liveLastMonth > 0 ? round((($liveCurrentMonth - $liveLastMonth) / $liveLastMonth) * 100, 1) : ($liveCurrentMonth > 0 ? 100 : 0);

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

        $lastYearSessions = ChatSession::whereYear('created_at', $now->year - 1)
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

        $totalCurrentYear = $currentYearSessions->count();
        $totalLastYear = $lastYearSessions->count();
        $diffYear = $totalCurrentYear - $totalLastYear;
        $pctYear = $totalLastYear > 0 ? round(($diffYear / $totalLastYear) * 100, 1) : ($totalCurrentYear > 0 ? 100 : 0);

        $aiCurrentYear = $currentYearSessions->filter(fn ($s) => $s->mode !== 'guru_bk')->count();
        $aiLastYear = $lastYearSessions->filter(fn ($s) => $s->mode !== 'guru_bk')->count();
        $pctChangeAiYear = $aiLastYear > 0 ? round((($aiCurrentYear - $aiLastYear) / $aiLastYear) * 100, 1) : ($aiCurrentYear > 0 ? 100 : 0);

        $liveCurrentYear = $currentYearSessions->filter(fn ($s) => $s->mode === 'guru_bk')->count();
        $liveLastYear = $lastYearSessions->filter(fn ($s) => $s->mode === 'guru_bk')->count();
        $pctChangeLiveYear = $liveLastYear > 0 ? round((($liveCurrentYear - $liveLastYear) / $liveLastYear) * 100, 1) : ($liveCurrentYear > 0 ? 100 : 0);

        $formatBadge = function ($pct) {
            if ($pct > 0) {
                return '↗ +'.$pct.'%';
            }
            if ($pct < 0) {
                return '↘ '.$pct.'%';
            }

            return '0.0%';
        };

        return [
            'periods' => [
                'week' => [
                    'labels' => $weekDays,
                    'ai' => $aiWeekData,
                    'live' => $liveWeekData,
                    'ai_count' => $aiWeekTotal,
                    'live_count' => $liveWeekTotal,
                    'total_count' => $totalWeek,
                    'pct_ai' => ($pctAiWeek >= 0 ? '+' : '').$pctAiWeek.'%',
                    'pct_live' => ($pctLiveWeek >= 0 ? '+' : '').$pctLiveWeek.'%',
                    'pct_total' => ($pctWeek >= 0 ? '+' : '').$pctWeek.'%',
                    'pct_ai_badge' => $formatBadge($pctAiWeek),
                    'pct_live_badge' => $formatBadge($pctLiveWeek),
                    'pct_total_badge' => $formatBadge($pctWeek),
                    'pct_val_ai' => $pctAiWeek,
                    'pct_val_live' => $pctLiveWeek,
                    'pct_val_total' => $pctWeek,
                    'pct_val' => $pctWeek,
                    'comparison_text' => ($pctWeek >= 0 ? '↑ ' : '↓ ').abs($pctWeek).'% dibanding 7 hari sebelumnya',
                    'period_subtitle' => '7 hari terakhir',
                ],
                'month' => [
                    'labels' => $monthWeeksLabels,
                    'ai' => $aiMonthWeeksData,
                    'live' => $liveMonthWeeksData,
                    'ai_count' => $aiCurrentMonth,
                    'live_count' => $liveCurrentMonth,
                    'total_count' => $totalCurrentMonth,
                    'pct_ai' => ($pctChangeAiMonth >= 0 ? '+' : '').$pctChangeAiMonth.'%',
                    'pct_live' => ($pctChangeLiveMonth >= 0 ? '+' : '').$pctChangeLiveMonth.'%',
                    'pct_total' => ($pctMonth >= 0 ? '+' : '').$pctMonth.'%',
                    'pct_ai_badge' => $formatBadge($pctChangeAiMonth),
                    'pct_live_badge' => $formatBadge($pctChangeLiveMonth),
                    'pct_total_badge' => $formatBadge($pctMonth),
                    'pct_val_ai' => $pctChangeAiMonth,
                    'pct_val_live' => $pctChangeLiveMonth,
                    'pct_val_total' => $pctMonth,
                    'pct_val' => $pctMonth,
                    'comparison_text' => ($pctMonth >= 0 ? '↑ ' : '↓ ').abs($pctMonth).'% dibanding bulan sebelumnya',
                    'period_subtitle' => $now->translatedFormat('F Y'),
                ],
                'year' => [
                    'labels' => $yearMonths,
                    'ai' => $aiYearData,
                    'live' => $liveYearData,
                    'ai_count' => $aiCurrentYear,
                    'live_count' => $liveCurrentYear,
                    'total_count' => $totalCurrentYear,
                    'pct_ai' => ($pctChangeAiYear >= 0 ? '+' : '').$pctChangeAiYear.'%',
                    'pct_live' => ($pctChangeLiveYear >= 0 ? '+' : '').$pctChangeLiveYear.'%',
                    'pct_total' => ($pctYear >= 0 ? '+' : '').$pctYear.'%',
                    'pct_ai_badge' => $formatBadge($pctChangeAiYear),
                    'pct_live_badge' => $formatBadge($pctChangeLiveYear),
                    'pct_total_badge' => $formatBadge($pctYear),
                    'pct_val_ai' => $pctChangeAiYear,
                    'pct_val_live' => $pctChangeLiveYear,
                    'pct_val_total' => $pctYear,
                    'pct_val' => $pctYear,
                    'comparison_text' => ($pctYear >= 0 ? '↑ ' : '↓ ').abs($pctYear).'% dibanding tahun sebelumnya',
                    'period_subtitle' => 'Tahun '.$now->year,
                ],
            ],
            // Backward-compatibility keys untuk komponen lama:
            'week' => [
                'labels' => $weekDays,
                'ai' => $aiWeekData,
                'live' => $liveWeekData,
            ],
            'month' => [
                'labels' => $monthWeeksLabels,
                'ai' => $aiMonthWeeksData,
                'live' => $liveMonthWeeksData,
            ],
            'year' => [
                'labels' => $yearMonths,
                'ai' => $aiYearData,
                'live' => $liveYearData,
            ],
            'summary' => [
                'total_current_month' => $totalCurrentMonth,
                'total_last_month' => $totalLastMonth,
                'diff' => $diffMonth,
                'pct_change' => $pctMonth,
                'current_month_name' => $now->translatedFormat('F Y'),
                'ai' => [
                    'total_current_month' => $aiCurrentMonth,
                    'total_last_month' => $aiLastMonth,
                    'diff' => $aiCurrentMonth - $aiLastMonth,
                    'pct_change' => $pctChangeAiMonth,
                ],
                'live' => [
                    'total_current_month' => $liveCurrentMonth,
                    'total_last_month' => $liveLastMonth,
                    'diff' => $liveCurrentMonth - $liveLastMonth,
                    'pct_change' => $pctChangeLiveMonth,
                ],
            ],
        ];
    }

    /**
     * Menghitung distribusi konsultasi pada 4 Bidang Standar Bimbingan Konseling (Pribadi, Sosial, Belajar, Karir).
     *
     * @return array<string, mixed>
     */
    public function getBkCategoriesDistribution(?int $teacherId = null): array
    {
        $categories = [
            'pribadi' => [
                'id' => 'pribadi',
                'title' => 'Bimbingan Pribadi',
                'subtitle' => 'Pemahaman diri, emosi, stres, dan penerimaan diri',
                'keywords' => ['stres', 'cemas', 'panik', 'sedih', 'emosi', 'takut', 'marah', 'lelah', 'insecure', 'overthinking', 'percaya diri', 'pribadi', 'diri sendiri', 'mental', 'kesepian', 'bingung', 'capek'],
                'color' => 'indigo',
                'badge' => 'bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 border-indigo-200/60 dark:border-indigo-800/50',
                'bar_color' => 'bg-indigo-600',
                'dot_color' => 'bg-indigo-500',
                'icon_bg' => 'bg-indigo-100 dark:bg-indigo-950/70 text-indigo-600 dark:text-indigo-400',
                'count' => 0,
            ],
            'sosial' => [
                'id' => 'sosial',
                'title' => 'Bimbingan Sosial',
                'subtitle' => 'Hubungan pertemanan, keluarga, dan lingkungan sosial',
                'keywords' => ['teman', 'sahabat', 'konflik', 'orang tua', 'keluarga', 'bully', 'perundungan', 'pertengkaran', 'pacar', 'sosial', 'lingkungan', 'gaul', 'masalah orang tua', 'komunikasi'],
                'color' => 'blue',
                'badge' => 'bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 border-blue-200/60 dark:border-blue-800/50',
                'bar_color' => 'bg-blue-600',
                'dot_color' => 'bg-blue-500',
                'icon_bg' => 'bg-blue-100 dark:bg-blue-950/70 text-blue-600 dark:text-blue-400',
                'count' => 0,
            ],
            'belajar' => [
                'id' => 'belajar',
                'title' => 'Bimbingan Belajar',
                'subtitle' => 'Manajemen waktu, motivasi belajar, dan strategi akademik',
                'keywords' => ['belajar', 'tugas', 'nilai', 'rapor', 'ujian', 'sekolah', 'pr', 'konsentrasi', 'malas', 'jadwal', 'waktu belajar', 'kesulitan belajar', 'remedial', 'akademik'],
                'color' => 'emerald',
                'badge' => 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border-emerald-200/60 dark:border-emerald-800/50',
                'bar_color' => 'bg-emerald-600',
                'dot_color' => 'bg-emerald-500',
                'icon_bg' => 'bg-emerald-100 dark:bg-emerald-950/70 text-emerald-600 dark:text-emerald-400',
                'count' => 0,
            ],
            'karir' => [
                'id' => 'karir',
                'title' => 'Bimbingan Karir',
                'subtitle' => 'Minat bakat, SNBP, SNBT, perguruan tinggi, dan profesi',
                'keywords' => ['karir', 'cita-cita', 'bakat', 'minat', 'kuliah', 'snbt', 'snbp', 'jurusan', 'beasiswa', 'kampus', 'ptn', 'kerja', 'profesi', 'peluang', 'masa depan', 'prodi'],
                'color' => 'amber',
                'badge' => 'bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 border-amber-200/60 dark:border-amber-800/50',
                'bar_color' => 'bg-amber-500',
                'dot_color' => 'bg-amber-500',
                'icon_bg' => 'bg-amber-100 dark:bg-amber-950/70 text-amber-600 dark:text-amber-400',
                'count' => 0,
            ],
        ];

        // Analisis konten pesan user
        $userMessages = ChatMessage::where('role', 'user')
            ->when($teacherId, function ($q) use ($teacherId) {
                $q->whereHas('session', function ($sub) use ($teacherId) {
                    $sub->where(function ($s) use ($teacherId) {
                        $s->where('mode', '!=', 'guru_bk')
                            ->orWhereNull('mode')
                            ->orWhere('teacher_id', $teacherId);
                    });
                });
            })
            ->pluck('content');

        // Analisis judul sesi konsultasi
        $sessionTitles = ChatSession::when($teacherId, function ($q) use ($teacherId) {
            $q->where(function ($sub) use ($teacherId) {
                $sub->where('mode', '!=', 'guru_bk')
                    ->orWhereNull('mode')
                    ->orWhere('teacher_id', $teacherId);
            });
        })->pluck('title');

        foreach ($userMessages as $msg) {
            $lower = mb_strtolower($msg);
            foreach ($categories as &$cat) {
                foreach ($cat['keywords'] as $kw) {
                    if (str_contains($lower, $kw)) {
                        $cat['count']++;
                        break;
                    }
                }
            }
            unset($cat);
        }

        foreach ($sessionTitles as $title) {
            if (! $title) {
                continue;
            }
            $lower = mb_strtolower($title);
            foreach ($categories as &$cat) {
                foreach ($cat['keywords'] as $kw) {
                    if (str_contains($lower, $kw)) {
                        $cat['count']++;
                        break;
                    }
                }
            }
            unset($cat);
        }

        $totalCount = array_sum(array_column($categories, 'count'));

        foreach ($categories as &$cat) {
            $cat['percentage'] = $totalCount > 0 ? round(($cat['count'] / $totalCount) * 100) : 0;
        }
        unset($cat);

        return [
            'items' => $categories,
            'total' => $totalCount,
        ];
    }

    /**
     * Menghitung status penanganan alur konseling (Menunggu Antrean, Sedang Ditangani, Selesai, Butuh Tindak Lanjut).
     *
     * @return array<string, mixed>
     */
    public function getCounselingHandlingStatus(?int $teacherId = null): array
    {
        // 1. Sedang Ditangani (Active Live Chat)
        $activeLiveQuery = ChatSession::where('mode', 'guru_bk')
            ->where('status', 'active');
        if ($teacherId) {
            $activeLiveQuery->where('teacher_id', $teacherId);
        }
        $inProgressSessions = $activeLiveQuery->count();

        // 2. Selesai Ditangani (Closed Sessions)
        $closedSessionsQuery = ChatSession::where('status', 'closed');
        if ($teacherId) {
            $closedSessionsQuery->where(function ($q) use ($teacherId) {
                $q->where('mode', '!=', 'guru_bk')
                    ->orWhereNull('mode')
                    ->orWhere('teacher_id', $teacherId);
            });
        }
        $completedSessions = $closedSessionsQuery->count();

        // 3. Menunggu Antrean (Live Chat aktif tanpa jawaban / antrean atau asesmen belum ditinjau)
        $pendingQuestionnaires = QuestionnaireResult::whereNull('tindak_lanjut_at')->count();
        $waitingCount = $inProgressSessions > 0 ? $inProgressSessions : ($pendingQuestionnaires > 0 ? $pendingQuestionnaires : 0);

        // 4. Butuh Tindak Lanjut / Rujukan
        $handledQuestionnaires = QuestionnaireResult::whereNotNull('tindak_lanjut_at')->count();
        $followUpCount = $handledQuestionnaires;

        $totalCases = $inProgressSessions + $completedSessions + $pendingQuestionnaires + $handledQuestionnaires;

        return [
            'waiting' => [
                'title' => 'Menunggu Respon',
                'count' => $waitingCount,
                'subtitle' => 'Siswa dalam antrean konsultasi atau asesmen baru',
                'color' => 'amber',
                'badge' => 'bg-amber-50 text-amber-700 dark:bg-amber-950/60 dark:text-amber-300 border-amber-200/60 dark:border-amber-800/40',
                'bar_color' => 'bg-amber-500',
                'percentage' => $totalCases > 0 ? round(($waitingCount / $totalCases) * 100) : 0,
            ],
            'in_progress' => [
                'title' => 'Sedang Ditangani',
                'count' => $inProgressSessions,
                'subtitle' => 'Sesi live chat aktif berjalan saat ini',
                'color' => 'blue',
                'badge' => 'bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300 border-blue-200/60 dark:border-blue-800/40',
                'bar_color' => 'bg-blue-600',
                'percentage' => $totalCases > 0 ? round(($inProgressSessions / $totalCases) * 100) : 0,
            ],
            'completed' => [
                'title' => 'Selesai Ditangani',
                'count' => $completedSessions,
                'subtitle' => 'Konsultasi tuntas dan terarsip dengan baik',
                'color' => 'emerald',
                'badge' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border-emerald-200/60 dark:border-emerald-800/40',
                'bar_color' => 'bg-emerald-600',
                'percentage' => $totalCases > 0 ? round(($completedSessions / $totalCases) * 100) : 0,
            ],
            'follow_up' => [
                'title' => 'Tindak Lanjut / Rujukan',
                'count' => $followUpCount,
                'subtitle' => 'Hasil asesmen dengan arahan tindak lanjut',
                'color' => 'indigo',
                'badge' => 'bg-indigo-50 text-indigo-700 dark:bg-indigo-950/60 dark:text-indigo-300 border-indigo-200/60 dark:border-indigo-800/40',
                'bar_color' => 'bg-indigo-600',
                'percentage' => $totalCases > 0 ? round(($followUpCount / $totalCases) * 100) : 0,
            ],
            'total_cases' => $totalCases,
        ];
    }

    /**
     * Mengambil alur aktivitas terbaru siswa (Sesi Konsultasi AI, Live Chat, dan Pengerjaan Asesmen BK).
     *
     * @return array<int, array<string, mixed>>
     */
    public function getStudentActivities(int $limit = 8, ?int $teacherId = null): array
    {
        $activities = [];

        // 1. Sesi Chat Terbaru
        $recentChat = ChatSession::with(['user', 'teacher'])
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

        foreach ($recentChat as $session) {
            $isLive = $session->mode === 'guru_bk';
            $activities[] = [
                'id' => 'session-'.$session->id,
                'type' => $isLive ? 'live_chat' : 'ai_chat',
                'title' => $isLive ? 'Live Chat Bimbingan Konseling' : 'Konsultasi Mandiri Asisten AI',
                'detail' => $session->title ?: ($isLive ? 'Sesi interaktif bersama Guru BK' : 'Tanya jawab bimbingan AI'),
                'student_name' => $session->user?->name ?? 'Siswa Tamu',
                'student_meta' => $session->user?->kelas ? 'Kelas '.$session->user->kelas : ($session->user?->nisn ? 'NISN: '.$session->user->nisn : 'Siswa SMAN 4'),
                'avatar_letter' => strtoupper(substr($session->user?->name ?? 'S', 0, 1)),
                'status' => $session->status === 'active' ? 'Aktif' : 'Selesai',
                'status_color' => $session->status === 'active' ? 'blue' : 'emerald',
                'created_at' => $session->created_at,
                'time_ago' => $session->created_at ? $session->created_at->diffForHumans() : '-',
                'action_url' => $isLive ? route('bk.live-chat') : route('bk.percakapan.detail', $session->id),
            ];
        }

        // 2. Hasil Asesmen Kuesioner Terbaru
        $recentResults = QuestionnaireResult::with(['user', 'questionnaire'])
            ->latest()
            ->take($limit)
            ->get();

        foreach ($recentResults as $res) {
            $hasFollowUp = ! empty($res->tindak_lanjut_at);
            $activities[] = [
                'id' => 'questionnaire-'.$res->id,
                'type' => 'assessment',
                'title' => 'Asesmen BK: '.($res->questionnaire?->title ?? 'Kuesioner Siswa'),
                'detail' => 'Skor capaian: '.$res->score.($hasFollowUp ? ' (Telah Ditindaklanjuti)' : ' (Menunggu Review Guru)'),
                'student_name' => $res->user?->name ?? 'Siswa',
                'student_meta' => $res->user?->kelas ? 'Kelas '.$res->user->kelas : ($res->user?->nisn ? 'NISN: '.$res->user->nisn : 'Siswa SMAN 4'),
                'avatar_letter' => strtoupper(substr($res->user?->name ?? 'S', 0, 1)),
                'status' => $hasFollowUp ? 'Ditindaklanjuti' : 'Hasil Baru',
                'status_color' => $hasFollowUp ? 'indigo' : 'amber',
                'created_at' => $res->created_at,
                'time_ago' => $res->created_at ? $res->created_at->diffForHumans() : '-',
                'action_url' => route('bk.tes.hasil.detail', $res->id),
            ];
        }

        // Urutkan berdasarkan waktu dibuat descending
        usort($activities, function ($a, $b) {
            $timeA = $a['created_at'] ? $a['created_at']->timestamp : 0;
            $timeB = $b['created_at'] ? $b['created_at']->timestamp : 0;

            return $timeB <=> $timeA;
        });

        return array_slice($activities, 0, $limit);
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
                'color' => 'bg-indigo-600',
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
