<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Patient; //患者モデルを使う宣言

class PatientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //1人目の患者
        Patient::create([
            'patient_id' => 'P0001',
            'name' => '佐藤 誠',
            'kana' => 'サトウ マコト',
            'birthday' => '1980-05-12',
            'gender' => '男性',
            'blood_type' => 'A+',
            'allergy' => '',
            'room_number' => '701',
            'bed_number' => 'A',
            'memo' => '前回の採血時に気分不良あり。',
        ]);

        //2人目の患者
        Patient::create([
            'patient_id' => 'P0002',
            'name' => '鈴木 一郎',
            'kana' => 'スズキ イチロウ',
            'birthday' => '1978-11-12',
            'gender' => '男性',
            'blood_type' => 'AB+',
            'allergy' => 'なし',
            'room_number' => '502',
            'bed_number' => 'B',
            'memo' => '',
        ]);

        //3人目の患者
        Patient::create([
            'patient_id' => 'P0003',
            'name' => '高橋 光子',
            'kana' => 'タカハシ ミツコ',
            'birthday' => '1980-05-12',
            'gender' => '女性',
            'blood_type' => 'A+',
            'allergy' => 'キウイ、バナナ',
            'room_number' => '701',
            'bed_number' => 'C',
            'memo' => '転倒転落リスク高（アセスメントスコアⅡ-12点）。センサーマット使用中。',
        ]);
    }
}
