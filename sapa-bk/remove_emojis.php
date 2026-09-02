<?php
$dir = __DIR__ . '/resources/views/student';
$files = glob($dir . '/*.blade.php');

$replacements = [
    '🎓' => '',
    '👨‍🏫' => '',
    '🛠️' => '',
    '💬' => '',
    '📚' => '',
    '📰' => '',
    '⚠️' => '',
    '📄' => '',
    '🌐' => '',
    '📝' => '',
    '🔍' => '',
    '👋' => '',
    '🚀' => '',
    '👤' => '',
    '🤖' => '',
    '📊' => '',
    '🧠' => '',
    '💡' => '',
    '📈' => '',
    '🎯' => '',
    '🏆' => '',
];

foreach ($files as $file) {
    $content = file_get_contents($file);
    
    // Special replacements for chat avatars
    $content = str_replace("'👨‍🏫'", "'BK'", $content);
    $content = str_replace("'🤖'", "'AI'", $content);
    $content = str_replace("'💬'", "''", $content);
    $content = str_replace(">👨‍🏫<", ">BK<", $content);
    $content = str_replace(">🤖<", ">AI<", $content);
    
    $newContent = str_replace(array_keys($replacements), array_values($replacements), $content);
    
    // Clean up empty spans
    $newContent = preg_replace('/<span[^>]*>\s*<\/span>/i', '', $newContent);
    
    if ($content !== $newContent) {
        file_put_contents($file, $newContent);
        echo "Cleaned " . basename($file) . "\n";
    }
}
echo "Done.\n";
