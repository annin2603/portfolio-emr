<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient; //Patientモデルを使う宣言

class DashboardController extends Controller
{
    // 0. 患者一覧の表示
    public function index()
    {
        //現在ログインしている医療スタッフの情報を取得
        $staff = Auth::user();
        //データベース（patientsテーブル）から患者一覧を取得して病室順に並べる
        $patients = Patient::orderBy('room_number')-> orderBy('bed_number')-> get();
        //２つのデータ（スタッフ、患者）をセットにして画面（dashboard）に送る
        return view('dashboard', compact('staff', 'patients'));
    }

    // 1. 新規登録画面（フォーム）を表示させる
    public function create()
    {
        //ログイン職員の情報だけ取得して患者登録画面に送る
        $staff = Auth::user();
        return view('patients.create', compact('staff'));
    }

    //登録画面から送られてきたデータをデータベースに保存させる
    public function store(Request $request)
    {
        //看護師が入力した内容のチェック（バリデーション）
        $validatedData = $request->validate([
            'room_number'  => 'required|integer|min:1',
            'bed_number'   => 'required|string',
            'patient_id'   => 'required|string|unique:patients,patient_id',
            'name'         => 'required|string|max:255',
            'kana'         => 'required|string|max:255',
            'gender'       => 'required|string',
            'birthday'     => 'required|date',
            'blood_type'   => 'required|string',
            'allergy'      => 'nullable|string',
            'memo'         => 'nullable|string|max:1000',
        ]);

        //チェックの結果OKの場合データベース（Patientモデル）に新しいデータを保存
        Patient::create($validatedData);

        //保存ができたらメッセージ付きでダッシュボード画面に戻る
        return redirect()->route('dashboard')->with('success', '新規患者を登録しました');
    }

    // 2. 患者情報の編集画面の表示する
    public function edit(Patient $patient){
        $staff = Auth::user(); // ログイン中の職員情報を取得
        return view('patients.edit', compact('patient'));
    }
    // 編集画面から送られてきたデータで上書き保存する
    public function update(Request $request, Patient $patient)
    {
        //看護師が入力した内容のチェック（バリデーション）
        $validatedData = $request->validate([
            'room_number'  => 'required|integer|min:1',
            'bed_number'   => 'required|string',
            'patient_id'   => 'required|string|unique:patients,patient_id,'.$patient->id,
            'name'         => 'required|string|max:255',
            'kana'         => 'required|string|max:255',
            'gender'       => 'required|string',
            'birthday'     => 'required|date',
            'blood_type'   => 'required|string',
            'allergy'      => 'nullable|string',
            'memo'         => 'nullable|string|max:1000',
        ]);

        //検証でOKのデータを既存データに上書き保存
        $patient->update($validatedData);

        //上書き保存ができたらメッセージ付きでダッシュボード画面に戻る
        return redirect()->route('dashboard')->with('success', '患者情報を更新しました');
    }

    // 3. 患者でデータの削除（退院）
    public function destroy(Patient $patient) {
        //データベースから選択している患者のデータを削除
        $patient->delete();

        //削除できたらメッセージ付きでダッシュボードに戻る
        return redirect()->route('dashboard')->with('success', '患者情報を削除しました');
    }

    // 患者の詳細画面を表示する
    public function show(Patient $patient) {
        $staff = Auth::user();

        // 詳細画面のテンプレート開き、患者データと職員データもまとめて持っていく
        return view('patients.show', compact('patient', 'staff'));
    }
}
