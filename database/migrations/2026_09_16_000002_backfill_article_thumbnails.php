<?php

use App\Models\Article;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $ptnImages = [
            'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1498243691581-b145c3f54a5a?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?auto=format&fit=crop&w=800&q=80',
        ];

        $mentalHealthImages = [
            'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1516302752625-fcc3c50ae61f?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1499209974431-9dddcece7f88?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1507679799987-c73779587ccf?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=800&q=80',
        ];

        $defaultImages = [
            'https://images.unsplash.com/photo-1457369804613-52c61a468e7d?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&w=800&q=80',
        ];

        $articles = Article::whereNull('thumbnail')->orWhere('thumbnail', '')->get();
        foreach ($articles as $idx => $art) {
            if ($art->category === 'tips_ptn') {
                $art->thumbnail = $ptnImages[$idx % count($ptnImages)];
            } elseif ($art->category === 'kesehatan_mental') {
                $art->thumbnail = $mentalHealthImages[$idx % count($mentalHealthImages)];
            } else {
                $art->thumbnail = $defaultImages[$idx % count($defaultImages)];
            }
            $art->save();
        }
    }

    public function down(): void
    {
        // No down action needed
    }
};
