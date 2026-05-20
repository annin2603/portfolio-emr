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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();

            $table->string('patient_id')->unique(); // 患者ID（例：P0001、重複禁止）
            $table->string('name');                 // 氏名（漢字）
            $table->string('kana');                 // 氏名（フリガナ）
            $table->date('birthday');               // 生年月日（年齢計算の元データ）
            $table->string('gender');               // 性別
            $table->string('blood_type')->nullable(); // 血液型（空っぽでもOK）
            $table->text('allergy')->nullable();    // アレルギー（複数書けるように長い文章用のTEXT型）
            $table->string('room_number');          // 病室番号（例：402）
            $table->string('bed_number');           // ベッド番号（例：A）
            $table->text('memo')->nullable();       // 備考・主訴など（空っぽでもOK

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
