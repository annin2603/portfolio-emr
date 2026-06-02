<x-app-layout>
   <!-- 詳細画面上のヘッダー部分 -->
    <x-slot name="header">
        <div class="space-y-4">
            <div class="mb-3">
                <a href="{{ route('patients.show', $patient) }}"
                class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
                    <span class="rounded-lg border border-blue-600 px-3 py-1.5 ml-2">⬅️ 患者詳細へ戻る</span>
                </a>
            </div>

            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-base text-gray-500 uppercase tracking-wider">
                    📝 患者基本情報の編集
                </h2>

                <div class="text-xs text-gray-600 bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-100 shadow-sm whitespace-nowrap">
                    ログイン職員: <span class="font-bold text-blue-700">{{ $staff->name }}</span> さん
                    (職員番号: <span class="font-mono bg-white px-1 border rounded">{{ $staff->login_id }}</span>)
                </div>
            </div>
            <div class="flex items-end justify-between gap-4 pt-3 mt-4 border-t border-gray-100">

                <!-- 左側 -->
                <div class="flex items-end gap-6">
                    <div>
                        <h3 class="text-3xl font-bold text-gray-900  mt-3 leading-tight">
                            {{ $patient->name }}
                        </h3>
                        <h3 class="text-sm font-normal text-gray-500">
                            {{ $patient->kana }}
                        </h3>
                    </div>
                    <!-- 患者IDと病床 -->
                    <div class="flex items-center gap-3 pb-1 ml-5">
                        <div class="text-sm bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-semibold">
                            <p><strong>患者ID：</strong>{{ $patient->patient_id }}</p>
                        </div>
                        <p class="text-sm font-bold text-gray-600 px-3 py-1">
                            {{ $patient->room_number }}号室 - {{ $patient->bed_number }}ベッド
                        </p>
                    </div>
                </div>

                <!-- 右側 -->
                <div class="flex items-center space-x-3 whitespace-nowrap">
                    <a href="{{ route('patients.edit', $patient) }}" class="text-emerald-600 hover:text-emerald-900 bg-emerald-100 px-3 py-1 rounded-md transition-colors">
                        編集
                    </a>
                    <form action="{{ route('patients.destroy', $patient) }}" method="POST" onsubmit="return confirm('本当に退院（削除）でよろしいですか？');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-yellow-600 hover:text-yellow-900 bg-yellow-100 px-3 py-1 rounded-md transition-colors">
                            退院
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>

    <!-- 画面のメイン中身 -->
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-6">📝 患者基本情報の編集</h3>
                <form action="{{ route('patients.update', $patient) }}" method="POST" class="space-y-6">
                    @csrf <!-- Laravelのフォームで必須のセキュリティ対策 -->
                    @method('PUT') <!-- 上書き保存の宣言 -->

                    <!-- 入力項目を2列に並べる（レスポンシブで1列になる） -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- 1. 病室 -->
                        <div>
                            <label for="room_number" class="block text-sm font-medium text-gray-700 ">病室番号（必須、半角数字のみ）</label>
                            <input type="number" name="room_number" id="room_number" value="{{ old('room_number', $patient->room_number) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            @error('room_number')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- 2. ベッド番号 -->
                        <div>
                            <label for="bed_number" class="block text-sm font-medium text-gray-700 ">ベッド番号 （必須、個室の場合はA）</label>
                            <select name="bed_number" id="bed_number" required  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                <option value="">選択してください</option>
                                <option value="A" {{ old('bed_number', $patient->bed_number) == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('bed_number', $patient->bed_number) == 'B' ? 'selected' : '' }}>B</option>
                                <option value="C" {{ old('bed_number', $patient->bed_number) == 'C' ? 'selected' : '' }}>C</option>
                                <option value="D" {{ old('bed_number', $patient->bed_number) == 'D' ? 'selected' : '' }}>D</option>
                            </select>
                            @error('bed_number')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- 3. 患者ID -->
                         <div>
                            <label for="patient_id" class="block text-sm font-medium text-gray-700 ">患者ID（必須）</label>
                            <input type="text" name="patient_id" id="patient_id" required  value="{{ old('patient_id', $patient->patient_id) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            @error('patient_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- 4. 氏名 -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 ">氏名（必須）</label>
                            <input type="text" name="name" id="name" required  value="{{ old('name', $patient->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- 5. フリガナ -->
                        <div>
                            <label for="kana" class="block text-sm font-medium text-gray-700 ">フリガナ（必須、全角カタカナ）</label>
                            <input type="text" name="kana" id="kana" required  value="{{ old('kana', $patient->kana) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            @error('kana')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- 6. 性別 -->
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700 ">性別（必須）</label>
                            <select name="gender" id="gender" required  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                <option value="">選択してください</option>
                                <option value="男性" {{ old('gender', $patient->gender) == '男性' ? 'selected' : '' }}>男性</option>
                                <option value="女性" {{ old('gender', $patient->gender) == '女性' ? 'selected' : '' }}>女性</option>
                                <option value="その他" {{ old('gender', $patient->gender) == 'その他' ? 'selected' : '' }}>その他</option>
                            </select>
                            @error('gender')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- 7. 生年月日 -->
                        <div>
                            <label for="birthday" class="block text-sm font-medium text-gray-700 ">生年月日（必須）</label>
                            <!-- type="date" にすると、カレンダーから選べる便利な入力欄になる -->
                            <input type="date" name="birthday" id="birthday" required  value="{{ old('birthday', $patient->birthday) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            @error('birthday')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- 8. 血液型 -->
                        <div>
                            <label for="blood_type" class="block text-sm font-medium text-gray-700 ">血液型</label>
                            <select name="blood_type" id="blood_type" required  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                <option value="">選択してください</option>
                                @foreach(['A+','A-','B+','B-','O+','O-','AB+','AB-','未検'] as $type)
                                <option value="{{ $type }}" {{old('blood_type', $patient->blood_type) == $type ? 'selected' : ''}}>{{ $type }}</option>
                                @endforeach
                            </select>
                            @error('blood_type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                    <!-- 横幅いっぱいに使う項目 -->
                        <!-- 9. アレルギー -->
                        <div class="mt-6">
                            <label for="allergy" class="block text-sm font-medium text-gray-700 ">アレルギー情報</label>
                            <input type="text" name="allergy" id="allergy" value="{{ old('allergy', $patient->allergy) }}" placeholder="例：えび・カニなど" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                            @error('allergy')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- 10. 備考（既往歴や申し送り事項） -->
                        <div class="mt-6">
                            <label for="memo" class="block text-sm font-medium text-gray-700 ">備考（申し送りなど）</label>
                            <textarea name="memo" id="memo" rows="3" placeholder="重要な既往歴や看護上の留意点など"  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">{{ old('memo', $patient->memo) }}</textarea>
                            @error('memo')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- ボタン -->
                        <div class="flex justify-end space-x-3 pt-6 border-t border-gray-100">
                            <!-- キャンセルを押したら一覧画面に戻るように route() を繋ぐ -->
                            <a href="{{ route('patients.show', $patient) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm transition-colors">
                                キャンセル
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-5 py-2 rounded-md shadow-sm text-sm transition-colors">
                                この内容で更新する
                            </button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
