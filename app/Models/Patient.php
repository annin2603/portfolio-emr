<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    //一括保存を許可する項目を指定する
    protected $fillable = [
        'room_number',
        'bed_number',
        'patient_id',
        'name',
        'kana',
        'gender',
        'birthday',
        'blood_type',
        'allergy',
        'memo'
    ];

    // 患者側にバイタルの記録を引っ張てこれるようにする
    public function vitalSigns(): HasMany {

        // 測定日時が新しい順（降順）に並べて表示する
        return $this->hasMany(VitalSign::class)->orderBy('measured_at', 'desc');
    }

}
