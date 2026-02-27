<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->onDelete('cascade'); // Itemとのリレーション
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Userとのリレーション
            $table->text('body'); // コメント本文
            $table->timestamps();

            // 同じユーザーが同じ商品に複数コメントを防ぐためのユニーク制約
            $table->unique(['item_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
}
