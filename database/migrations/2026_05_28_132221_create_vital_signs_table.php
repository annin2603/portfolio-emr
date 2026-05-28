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
        Schema::create('vital_signs', function (Blueprint $table) {
            $table->id();

            // バイタルサインの項目を定義する
            $table->foreignId('patient_id')->constrained()->onDelete('cascade'); //患者テーブルとの紐づけ、退院したら一緒に削除

            $table->decimal('body_temperature', 4, 1)->nullable(); //体温、数字4桁(100.0まで広く取っておく)、小数点第一位
            $table->integer('blood_pressure_systolic')->nullable(); //収縮期血圧
            $table->integer('blood_pressure_diastolic')->nullable(); //拡張期血圧
            $table->integer('pulse_rate')->nullable(); //脈拍数
            $table->integer('spo2')->nullable(); //SpO2
            $table->integer('respiratory_rate')->nullable(); //呼吸数

            $table->text('vital_memo')->nullable(); // 検温時の看護記録
            $table->dateTime('measured_at'); //検温した時間を後から時間をさかのぼっても登録できるようにする

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vital_signs');
    }
};
