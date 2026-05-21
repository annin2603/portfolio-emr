<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

}
