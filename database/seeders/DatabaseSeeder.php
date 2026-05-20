<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //ログインする職員のテストユーザー
        User::create([
            'name' => '清水 看護師',
            'login_id' => '9999',
            'password' => Hash::make('password'),
        ]);
        //患者用シーダーの呼び出し
        $this->call([
            PatientTableSeeder::class,
        ]);
    }
}
