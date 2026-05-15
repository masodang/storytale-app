<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('project_images')->get()->each(function ($image) {
            $url = $image->image_url;
            $updated = false;

            // Remove protocol and domain
            if (preg_match('|^https?://[^/]+|', $url)) {
                $url = preg_replace('|^https?://[^/]+|', '', $url);
                $updated = true;
            }

            // Fix /storage/uploads/ to /uploads/
            if (str_contains($url, '/storage/uploads/')) {
                $url = str_replace('/storage/uploads/', '/uploads/', $url);
                $updated = true;
            }

            if ($updated) {
                DB::table('project_images')->where('id', $image->id)->update(['image_url' => $url]);
            }
        });
    }

    public function down(): void
    {
        // Cannot reliably revert URL format changes
    }
};
