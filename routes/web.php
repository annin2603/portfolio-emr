<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VitalSignController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==============================================================================================

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

use App\Http\Controllers\DashboardController; // ファイルの上のほう（他のuseの並び）に追加
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

//　患者の新規登録画面を開くための道を作る（URL：/patients/create）
Route::get('/patients/create', [DashboardController::class, 'create'])->middleware(['auth'])->name('patients.create');
//　登録画面で登録ボタンを押したときにデータを保存するための道をつくる(POSTリクエスト)
Route::post('/patients', [DashboardController::class, 'store'])->middleware(['auth'])->name('patients.store');

//　編集・更新の道を作る
Route::get('/patients/{patient}/edit', [DashboardController::class, 'edit'])->middleware(['auth'])->name('patients.edit');
Route::put('/patients/{patient}', [DashboardController::class, 'update'])->middleware(['auth'])->name('patients.update');

//　患者詳細画面用の道を作る
Route::get('/patients/{patient}', [DashboardController::class, 'show'])->middleware(['auth'])->name('patients.show');

//　退院（削除）の道を作る
Route::delete('/patients/{patient}', [DashboardController::class, 'destroy'])->name('patients.destroy');

// バイタルサイン記録(保存)の道を作る
Route::post('patients/{patient}/vitals', [VitalSignController::class, 'store'])->name('patients.vitals.store');

// バイタル編集画面を作る
Route::get('patients/{patient}/vitals/{vital_sign}/edit', [VitalSignController::class, 'edit'])->name('patients.vitals.edit');

// バイタルを更新する（PUTリクエスト）
Route::put('patients/{patient}/vitals/{vital_sign}', [VitalSignController::class, 'update'])->name('patients.vitals.update');

// バイタルを削除する（DELETEリクエスト）
Route::delete('patients/{patient}/vitals/{vital_sign}', [VitalSignController::class, 'destroy'])->name('patients.vitals.destroy');


require __DIR__.'/auth.php';
