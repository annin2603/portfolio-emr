<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VitalSign extends Model
{
    use HasFactory;

    // 一括保存を許可する項目を決める
    protected $fillable = [
        'patient_id',
        'body_temperature',
        'blood_pressure_systolic',
        'blood_pressure_diastolic',
        'pulse_rate',
        'spo2',
        'respiratory_rate',
        'vital_memo',
        'measured_at',
    ];

    // 日時型として扱う(日付操作ライブラリを利用)
    protected $casts = [
        'measured_at' => 'datetime',
    ];

    // リレーション設定（患者情報にアクセスできるようになる）
    public function patient(): BelongsTo {
        return $this->belongsTo(Patient::class);
    }
}
