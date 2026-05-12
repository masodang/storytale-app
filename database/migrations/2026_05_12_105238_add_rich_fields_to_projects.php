<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->json('custom_metrics')->nullable()->after('cover_image');
            $table->json('custom_scope')->nullable()->after('custom_metrics');
            $table->text('embed_code')->nullable()->after('custom_scope');
        });

        Schema::table('project_images', function (Blueprint $table) {
            $table->string('caption')->nullable()->after('alt_text');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['custom_metrics', 'custom_scope', 'embed_code']);
        });
        Schema::table('project_images', function (Blueprint $table) {
            $table->dropColumn('caption');
        });
    }
};
