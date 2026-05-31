<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\VitalSign;
use Illuminate\Http\Request;


class VitalSignController extends Controller
{
    // バイタルサインをDBに保存する
    public function store(Request $request, Patient $patient) {

        // 入力チェック（バリデーション）
        $validated = $request->validate([
            'body_temperature' => ['nullable', 'numeric', 'between:30.0,45.0'],
            'pulse_rate'=>['nullable', 'integer', 'between:0,300'],
            'blood_pressure_systolic'=>['nullable', 'integer', 'between:0,300'],
            'blood_pressure_diastolic'=>['nullable', 'integer', 'between:0,200'],
            'respiratory_rate'=>['nullable', 'integer', 'between:0,100'],
            'spo2'=>['nullable', 'integer', 'between:0,100'],
            'vital_memo'=>['nullable', 'string', 'max:1000'],
            'measured_at'=>['required', 'date'],
        ]);

        // どの患者のバイタル記録かどうかIDをセットする
        $validated['patient_id'] = $patient->id;

        // DBに保存（一括保存）
        VitalSign::create($validated);

        // 保存出来たら詳細画面に登録できたメッセージ表示付きで戻る
        return redirect()->route('patients.show', $patient)->with('status', 'バイタルサインを記録しました');


    }

    // バイタルサインの削除
    public function destroy(Patient $patient, VitalSign $vital_sign) {

        // バイタルサインをDBから削除
        $vital_sign->delete();

        // 削除ができたらメッセージ付きで詳細画面にリダイレクト
        return redirect()->route('patients.show', $patient)->with('status', 'バイタルサイン記録を削除しました');
    }

    // バイタルサイン編集画面の表示
    public function edit(Patient $patient, VitalSign $vital_sign) {

        // 患者データとバイタルデータを渡して表示
        return view('patients.edit_vital', compact('patient', 'vital_sign'));
    }

    // バイタルサインを上書き更新
    public function update(Request $request, Patient $patient, VitalSign $vital_sign) {
        $validated = $request->validate([

            // 入力チェック
            'body_temperature' => ['nullable', 'numeric', 'between:30.0,45.0'],
            'pulse_rate'=>['nullable', 'integer', 'between:0,300'],
            'blood_pressure_systolic'=>['nullable', 'integer', 'between:0,300'],
            'blood_pressure_diastolic'=>['nullable', 'integer', 'between:0,200'],
            'respiratory_rate'=>['nullable', 'integer', 'between:0,100'],
            'spo2'=>['nullable', 'integer', 'between:0,100'],
            'vital_memo'=>['nullable', 'string', 'max:1000'],
            'measured_at'=>['required', 'date'],

        ]);

        // 編集したバイタル値を上書き更新
        $vital_sign->update($validated);

        // 更新できたらメッセージ付きで患者詳細画面に表示
        return redirect()->route('patients.show', $patient)->with('status', 'バイタルサイン記録を修正しました。');

    }

}
