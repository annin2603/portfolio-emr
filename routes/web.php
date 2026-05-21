<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

use App\Http\Controllers\DashboardController; // ファイルの上のほう（他のuseの並び）に追加
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
//患者の新規登録画面を開くための道を作る（URL：/patients/create）
Route::get('/patients/create', [DashboardController::class, 'create'])->middleware(['auth'])->name('patients.create');
//登録画面で登録ボタンを押したときにデータを保存するための道をつくる(POSTリクエスト)
Route::post('/patients', [DashboardController::class, 'store'])->middleware(['auth'])->name('patients.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
