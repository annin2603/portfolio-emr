<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient; //Patientモデルを使う宣言

class DashboardController extends Controller
{
    public function index()
    {
        //現在ログインしている医療スタッフの情報を取得
        $staff = Auth::user();
        //データベース（patientsテーブル）から患者一覧を全員分取得
        $patients = Patient::all();
        //２つのデータ（スタッフ、患者）をセットにして画面（dashboard）に送る
        return view('dashboard', compact('staff', 'patients'));
    }

    //新規登録画面（フォーム）を表示させる
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
        $validateData = $request->validate([
            'room_number'  => 'required|integer',
            'bed_number'   => 'required|string',
            'patient_id'   => 'required|string|unique:patients,patient_id',
            'name'         => 'required|string',
            'kana'         => 'required|string',
            'gender'       => 'required|string',
            'birthday'     => 'required|date',
            'blood_type'   => 'nullable|string',
            'allergy'      => 'nullable|string',
            'memo'         => 'nullable|string',
        ]);

        //チェックの結果OKの場合データベース（Patientモデル）に新しいデータを保存
        Patient::create($validateData);

        //保存ができたらメッセージ付きでダッシュボード画面に戻る
        return redirect()->route('dashboard')->with('success', '新規患者を登録しました');

    }
}
