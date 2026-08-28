<?php

namespace App\Helpers;

class MenuHelper
{
    public static function getMenuGroups()
    {
        $user = auth()->user();
        if (!$user) {
            return [];
        }

        if ($user->role === 'admin') {
            return [
                [
                    'title' => 'Administrator',
                    'items' => [
                        [
                            'icon' => 'dashboard',
                            'name' => 'Dashboard Admin',
                            'path' => '/admin/dashboard',
                        ],
                        [
                            'icon' => 'user-profile',
                            'name' => 'Manajemen User',
                            'path' => '/admin/users',
                        ],
                        [
                            'icon' => 'forms',
                            'name' => 'Konfigurasi Sistem',
                            'path' => '/admin/konfigurasi',
                        ],
                        [
                            'icon' => 'pages',
                            'name' => 'System Log',
                            'path' => '/admin/log',
                        ],
                        [
                            'icon' => 'charts',
                            'name' => 'Laporan & Statistik',
                            'path' => '/admin/laporan',
                        ],
                    ]
                ],
                [
                    'title' => 'Manajemen BK & Konten',
                    'items' => [
                        [
                            'icon' => 'tables',
                            'name' => 'Data Siswa',
                            'path' => '/bk/siswa',
                        ],
                        [
                            'icon' => 'chat',
                            'name' => 'Live Chat Guru BK',
                            'path' => '/bk/live-chat',
                        ],
                        [
                            'icon' => 'support-ticket',
                            'name' => 'Riwayat Percakapan',
                            'path' => '/bk/percakapan',
                        ],
                        [
                            'icon' => 'pages',
                            'name' => 'E-book BK',
                            'path' => '/bk/ebook',
                        ],
                        [
                            'icon' => 'forms',
                            'name' => 'Artikel Edukasi',
                            'path' => '/bk/artikel',
                        ],
                        [
                            'icon' => 'ai-assistant',
                            'name' => 'Knowledge Base AI',
                            'path' => '/bk/knowledge-base',
                        ],
                        [
                            'icon' => 'task',
                            'name' => 'Manajemen Tes',
                            'path' => '/bk/tes',
                        ],
                        [
                            'icon' => 'charts',
                            'name' => 'Evaluasi Chatbot',
                            'path' => '/bk/evaluasi',
                        ],
                        [
                            'icon' => 'pages',
                            'name' => 'FAQ',
                            'path' => '/bk/faq',
                        ],
                    ]
                ]
            ];
        }

        if ($user->role === 'guru_bk') {
            return [
                [
                    'title' => 'Panel Guru BK',
                    'items' => [
                        [
                            'icon' => 'dashboard',
                            'name' => 'Dashboard BK',
                            'path' => '/bk/dashboard',
                        ],
                        [
                            'icon' => 'tables',
                            'name' => 'Data Siswa',
                            'path' => '/bk/siswa',
                        ],
                        [
                            'icon' => 'chat',
                            'name' => 'Live Chat Guru BK',
                            'path' => '/bk/live-chat',
                        ],
                        [
                            'icon' => 'support-ticket',
                            'name' => 'Riwayat Percakapan',
                            'path' => '/bk/percakapan',
                        ],
                    ]
                ],
                [
                    'title' => 'Konten & Pengetahuan',
                    'items' => [
                        [
                            'icon' => 'pages',
                            'name' => 'E-book BK',
                            'path' => '/bk/ebook',
                        ],
                        [
                            'icon' => 'forms',
                            'name' => 'Artikel Edukasi',
                            'path' => '/bk/artikel',
                        ],
                        [
                            'icon' => 'ai-assistant',
                            'name' => 'Knowledge Base AI',
                            'path' => '/bk/knowledge-base',
                        ],
                        [
                            'icon' => 'task',
                            'name' => 'Manajemen Tes',
                            'path' => '/bk/tes',
                        ],
                        [
                            'icon' => 'charts',
                            'name' => 'Evaluasi Chatbot',
                            'path' => '/bk/evaluasi',
                        ],
                        [
                            'icon' => 'pages',
                            'name' => 'FAQ',
                            'path' => '/bk/faq',
                        ],
                    ]
                ]
            ];
        }

        // Default: Siswa Role
        return [
            [
                'title' => 'Siswa SAPA BK',
                'items' => [
                    [
                        'icon' => 'dashboard',
                        'name' => 'Dashboard',
                        'path' => '/dashboard',
                    ],
                    [
                        'icon' => 'ai-assistant',
                        'name' => 'Konseling AI',
                        'path' => '/chat',
                    ],
                    [
                        'icon' => 'support-ticket',
                        'name' => 'Riwayat Konseling',
                        'path' => '/riwayat',
                    ],
                    [
                        'icon' => 'pages',
                        'name' => 'E-book & Literasi',
                        'path' => '/ebook/akses',
                    ],
                    [
                        'icon' => 'task',
                        'name' => 'Tes Psikologi',
                        'path' => '/tes',
                    ],
                    [
                        'icon' => 'user-profile',
                        'name' => 'Profil Saya',
                        'path' => '/profil',
                    ],
                ]
            ]
        ];
    }

    public static function getIconSvg($iconName)
    {
        $icons = [
            'dashboard' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="3" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="2"/><rect x="14" y="3" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="2"/><rect x="14" y="14" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="2"/><rect x="3" y="14" width="7" height="7" rx="1.5" stroke="currentColor" stroke-width="2"/></svg>',

            'ai-assistant' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L15 8L21 9L16.5 14L18 20L12 17L6 20L7.5 14L3 9L9 8L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',

            'user-profile' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="currentColor" stroke-width="2"/><path d="M6 21C6 17.134 8.686 14 12 14C15.314 14 18 17.134 18 21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',

            'forms' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 15H7M17 11H7M17 7H7M4 21H20C21.1046 21 22 20.1046 22 19V5C22 3.89543 21.1046 3 20 3H4C2.89543 3 2 3.89543 2 5V19C2 20.1046 2.89543 21 4 21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',

            'tables' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17 20H7C4.79086 20 3 18.2091 3 16V8C3 5.79086 4.79086 4 7 4H17C19.2091 4 21 5.79086 21 8V16C21 18.2091 19.2091 20 17 20Z" stroke="currentColor" stroke-width="2"/><path d="M12 4V20M3 10H21M3 15H21" stroke="currentColor" stroke-width="2"/></svg>',

            'pages' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 2H6C4.89543 2 4 2.89543 4 4V20C4 21.1046 4.89543 22 6 22H18C19.1046 22 20 21.1046 20 20V8L14 2Z" stroke="currentColor" stroke-width="2"/><path d="M14 2V8H20" stroke="currentColor" stroke-width="2"/></svg>',

            'charts' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18 20V10M12 20V4M6 20V14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',

            'chat' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 12H8.01M12 12H12.01M16 12H16.01M21 12C21 16.4183 16.9706 20 12 20C10.5 20 9.09 19.64 7.84 19L3 20L4.39 16.28C3.51 15.04 3 13.57 3 12C3 7.58172 7.02944 4 12 4C16.9706 4 21 7.58172 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',

            'support-ticket' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 5v2m0 4v2m0 4v2M5 5h14a2 2 0 012 2v3a2 2 0 000 4v3a2 2 0 01-2 2H5a2 2 0 01-2-2v-3a2 2 0 000-4V7a2 2 0 012-2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',

            'task' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        ];

        return $icons[$iconName] ?? '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="8" stroke="currentColor" stroke-width="2"/></svg>';
    }
}
