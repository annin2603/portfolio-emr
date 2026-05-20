<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient; // 👈 ここで「Patientモデルを使うよ！」と宣言しています

class DashboardController extends Controller
{
    public function index()
    {
        // 1. 🔑 現在ログインしている医療スタッフの情報を丸ごと取得
        $staff = Auth::user();

        // 2. 👥 データベース（patientsテーブル）から患者一覧を全員分ガサッと取得
        $patients = Patient::all();

        // 3. 🎨 ２つのデータ（スタッフ、患者）をセットにして画面（dashboard）に送る！
        return view('dashboard', compact('staff', 'patients'));
    }
}
