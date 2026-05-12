<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('category', ['case-study','learning','insight','whitepaper','report'])->default('case-study');
            $table->text('excerpt')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('pdf_url')->nullable();
            $table->enum('status', ['draft','published'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('journals'); }
};
