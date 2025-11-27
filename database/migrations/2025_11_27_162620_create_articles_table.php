<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();                                       // PK
            $table->string('title');                            // タイトル
            $table->string('slug')->unique();                   // スラッグ
            $table->longText('body');                           // 本文
            $table->string('thumbnail')->nullable();            // サムネ画像パス
            $table->enum('status', ['draft', 'published'])      // ステータス
                ->default('draft');
            $table->foreignId('category_id')                    // カテゴリ
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->timestamp('published_at')->nullable();      // 公開日時
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
