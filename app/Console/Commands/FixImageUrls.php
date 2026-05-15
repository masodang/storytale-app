<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixImageUrls extends Command
{
    protected $signature = 'app:fix-image-urls';
    protected $description = 'Fix image URLs in production database';

    public function handle()
    {
        $this->info("\n╔════════════════════════════════════════════╗");
        $this->info("║  FIXING PRODUCTION IMAGE URLS              ║");
        $this->info("╚════════════════════════════════════════════╝\n");

        $total = DB::table('project_images')->count();
        $localhost = DB::table('project_images')->where('image_url', 'like', '%localhost%')->count();

        $this->line("📊 Status:");
        $this->line("   Total images: $total");
        $this->line("   With localhost: $localhost\n");

        if ($localhost > 0) {
            $this->line("📋 Sample BEFORE fix:");
            DB::table('project_images')
                ->where('image_url', 'like', '%localhost%')
                ->limit(1)
                ->get()
                ->each(fn($img) => $this->line("   {$img->image_url}"));
            $this->newLine();
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

        $this->line("✅ Fixed URLs:");
        $this->line("   Removed localhost: $fixed1");
        $this->line("   Fixed /storage/uploads/: $fixed2");
        $this->line("   Total fixed: " . ($fixed1 + $fixed2) . "\n");

        $this->line("📋 Sample AFTER fix:");
        DB::table('project_images')
            ->limit(3)
            ->get()
            ->each(fn($img) => $this->line("   {$img->image_url}"));

        $this->info("\n✨ Done! Semua image URLs sudah fixed.\n");
    }
}
