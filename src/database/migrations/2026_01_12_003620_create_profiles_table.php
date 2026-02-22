<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            // usersテーブルと1対1
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // プロフィール情報
            $table->string('name')->nullable();
            $table->string('postcode')->nullable();
            $table->string('address')->nullable();
            $table->string('building')->nullable(); // 任意
            $table->string('profile_image')->nullable(); // 任意
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
