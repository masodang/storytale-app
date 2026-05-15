<?php
// Direct fix script - tidak perlu Laravel route
// Access: https://storytale.danlainlain.id/fix.php?token=fix-now

if ($_GET['token'] ?? '' !== 'fix-now') {
    die('Unauthorized');
}

// Load Laravel
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';

use Illuminate\Support\Facades\DB;

echo "<pre style='font-family: monospace; background: #000; color: #0f0; padding: 20px;'>";
echo "\n╔════════════════════════════════════════════╗\n";
echo "║  FIXING PRODUCTION IMAGE URLS              ║\n";
echo "╚════════════════════════════════════════════╝\n\n";

try {
    $total = DB::table('project_images')->count();
    $localhost = DB::table('project_images')->where('image_url', 'like', '%localhost%')->count();

    echo "📊 Status:\n";
    echo "   Total images: $total\n";
    echo "   With localhost: $localhost\n\n";

    if ($localhost > 0) {
        echo "📋 Sample BEFORE fix:\n";
        DB::table('project_images')
            ->where('image_url', 'like', '%localhost%')
            ->limit(1)
            ->get()
            ->each(fn($img) => echo "   {$img->image_url}\n");
        echo "\n";
    }

    // Fix 1: Remove protocol and domain
    $fixed1 = 0;
    DB::table('project_images')
        ->where('image_url', 'like', 'http%')
        ->get()
        ->each(function($img) use (&$fixed1) {
            $url = preg_replace('|^https?://[^/]+|', '', $img->image_url);
            if ($url !== $img->image_url) {
                DB::table('project_images')->where('id', $img->id)->update(['image_url' => $url]);
                $fixed1++;
            }
        });

    // Fix 2: Replace /storage/uploads/ with /uploads/
    $fixed2 = 0;
    DB::table('project_images')
        ->where('image_url', 'like', '%/storage/uploads/%')
        ->get()
        ->each(function($img) use (&$fixed2) {
            $url = str_replace('/storage/uploads/', '/uploads/', $img->image_url);
            DB::table('project_images')->where('id', $img->id)->update(['image_url' => $url]);
            $fixed2++;
        });

    echo "✅ Fixed:\n";
    echo "   Removed localhost: $fixed1\n";
    echo "   Fixed /storage/uploads/: $fixed2\n";
    echo "   Total: " . ($fixed1 + $fixed2) . "\n\n";

    echo "📋 AFTER fix (all URLs):\n";
    DB::table('project_images')->get()->each(fn($img) => echo "   {$img->image_url}\n");

    echo "\n✨ Done! Database fixed.\n";
    echo "\n⚠️  DELETE THIS FILE after use: rm public/fix.php\n";

} catch (Exception $e) {
    echo "❌ Error: {$e->getMessage()}\n";
    echo "Stack: {$e->getTraceAsString()}\n";
}

echo "\n</pre>";
?>
