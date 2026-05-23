<x-app-layout>
   <!-- 画面上のヘッダー部分 -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ➕ 新規患者登録
        </h2>
    </x-slot>

    <!-- 画面のメイン中身 -->
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('patients.store') }}" method="POST" class="space-y-6">
                    @csrf <!-- Laravelのフォームで必須のセキュリティ対策 -->

                    <!-- 入力項目を2列に並べる（レスポンシブで1列になる） -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- 1. 病室 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 ">病室番号（必須、半角数字のみ）</label>
                            <input type="number" name="room_number" value="{{ old('name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        <!-- 2. ベッド番号 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 ">ベッド番号 （必須、例: A, B）</label>
                            <input type="text" name="bed_number" value="{{ old('name') }}" required  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        <!-- 3. 患者ID -->
                         <div>
                            <label class="block text-sm font-medium text-gray-700 ">患者ID（必須）</label>
                            <input type="text" name="patient_id" required  value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        <!-- 4. 氏名 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 ">氏名（必須）</label>
                            <input type="text" name="name" required  value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        <!-- 5. フリガナ -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 ">フリガナ（必須、全角カタカナ）</label>
                            <input type="text" name="kana" required  value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        <!-- 6. 性別 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 ">性別（必須）</label>
                            <select name="gender" required  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                <option value="">選択してください</option>
                                <option value="男性">男性</option>
                                <option value="女性">女性</option>
                                <option value="その他">その他</option>
                            </select>
                        </div>
                        <!-- 7. 生年月日 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 ">生年月日（必須）</label>
                            <!-- type="date" にすると、カレンダーから選べる便利な入力欄になる -->
                            <input type="date" name="birthday" required  value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        <!-- 8. 血液型 -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 ">血液型</label>
                            <select name="blood_type" required  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                <option value="">選択してください</option>
                                <option value="A型+">A型+</option>
                                <option value="A型-">A型-</option>
                                <option value="B型+">B型+</option>
                                <option value="B型-">B型-</option>
                                <option value="O型+">O型+</option>
                                <option value="O型-">O型-</option>
                                <option value="AB型+">AB型+</option>
                                <option value="AB型-">AB型-</option>
                                <option value="未検">未検</option>
                            </select>
                        </div>
                    </div>
                    <!-- 横幅いっぱいに使う項目 -->
                        <!-- 9. アレルギー -->
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 ">アレルギー情報</label>
                            <input type="text" name="allergy" value="{{ old('name') }}" placeholder="例：えびカニなど" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        <!-- 10. 備考（既往歴や申し送り事項） -->
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 ">備考（申し送りなど）</label>
                            <textarea name="memo" rows="3" value="{{ old('name') }}" placeholder="重要な既往歴や看護上の留意点など"  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"></textarea>
                        </div>

                        <div class="flex justify-end space-x-3 pt-6 border-t border-gray-100">
                            <!-- キャンセルを押したら一覧画面に戻るように route() を繋ぐ -->
                            <a href="{{route('dashboard')}}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm transition-colors">
                                キャンセル
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-5 py-2 rounded-md shadow-sm text-sm transition-colors">
                                この内容で登録する
                            </button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
