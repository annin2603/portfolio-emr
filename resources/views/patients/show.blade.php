<x-app-layout>
   <!-- 詳細画面上のヘッダー部分 -->
    <x-slot name="header">
        <div class="space-y-4">
            <div class="flex items-center justify-between gap-4">
                <h2 class="font-semibold text-base text-gray-500 uppercase tracking-wider whitespace-nowrap">
                     患者詳細
                </h2>
                <div class="text-xs text-gray-600 bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-100 shadow-sm whitespace-nowrap">
                    ログイン職員: <span class="font-bold text-blue-700">{{ $staff->name }}</span> さん
                    (職員番号: <span class="font-mono bg-white px-1 border rounded">{{ $staff->login_id }}</span>)
                </div>
            </div>
            <div class="flex items-end justify-between gap-4 pt-3 mt-4 border-t border-gray-100">
                <div>
                    <h3 class="text-3xl font-bold text-gray-900  mt-3 leading-tight">
                        {{ $patient->name }}
                    </h3>
                    <h3 class="text-sm font-normal text-gray-500">
                        {{ $patient->kana }}
                    </h3>
                </div>

                <div class="flex items-center space-x-3 whitespace-nowrap">
                    <a href="{{ route('patients.edit', $patient) }}" class="text-green-600 hover:text-green-900 bg-green-100 px-3 py-1 rounded-md transition-colors">
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

    <!-- 詳細画面のメイン中身 -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-6">
            <!-- 患者IDと病床 -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 border-l-4 border-blue-500">
                <div class="pb-4">
                    <div class="flex justify-between items-center mb-4 gap-2">
                        <div class="text-right text-sm bg-blue-100 text-blue-800 px-3 py-1 rounded-full">
                            <p><strong>患者ID：</strong>{{ $patient->patient_id }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-bold text-gray-600">
                                {{ $patient->room_number }}号室 - {{ $patient->bed_number }}ベッド
                            </span>
                        </div>
                    </div>
                </div>
                <!-- 患者の基本情報 -->
                <h4 class="text-lg text-gray-900 font-bold mt-2 mb-6">📝 患者基本情報</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm pt-2 pb-4 border-t border-b border-gray-100">
                    <div>
                        <p class="text-gray-400 text-xs font-medium">性別</p>
                        <p class="font-bold text-gray-800 mt-0.5 text-base">{{ $patient->gender }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs font-medium">生年月日</p>
                        <p class="font-bold text-gray-800 mt-0.5 text-base">
                            {{ \Carbon\Carbon::parse($patient->birthday)->format('Y年m月d日') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs font-medium">血液型</p>
                        <p class="font-bold text-gray-800 mt-0.5 text-base">{{ $patient->blood_type }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs font-medium">アレルギー情報</p>
                        <p class="font-bold text-red-500 mt-0.5 text-base">{{ $patient->allergy ?? 'なし' }}</p>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-gray-400 text-xs font-medium">備考・申し送り事項</p>
                    <p class="font-bold text-gray-800 mt-1 text-base">{{ $patient->memo ?? '特記事項なし' }}</p>
                </div>
            </div>

            <!-- バイタルサインの表示  -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                <h4 class="text-lg font-bold text-gray-800 mb-4">📈 バイタルサイン記録</h4>

                <form action="#" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                        <!-- 1.体温 -->
                        <div>
                            <label for="body_temperature" class="block text-xs font-medium text-gray-600 mb-1">
                                体温（℃）
                            </label>

                            <input
                                type="number"
                                name="body_temperature"
                                id="body_temperature"
                                step="0.1"
                                min="30.0" max="45.0"
                                value="{{ old('body_temperature') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50 font-bold text-gray-800 text-base">

                            @error('body_temperature')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- 2.脈拍 -->
                        <div>
                            <label for="pulse_rate" class="block text-xs font-medium text-gray-600 mb-1">
                                脈拍（回/分）
                            </label>

                            <input
                                type="number"
                                name="pulse_rate"
                                id="pulse_rate"
                                min="0" max="200"
                                value="{{ old('pulse_rate') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50 font-bold text-gray-800 text-base">

                            @error('pulse_rate')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- 3.収縮期血圧 -->
                        <div>
                            <label for="blood_pressure_systolic" class="block text-xs font-medium text-gray-600 mb-1">
                                収縮期血圧（mmHg）
                            </label>

                            <input
                                type="number"
                                name="blood_pressure_systolic"
                                id="blood_pressure_systolic"
                                min="0" max="250"
                                value="{{ old('blood_pressure_systolic') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50 font-bold text-gray-800 text-base">

                            @error('blood_pressure_systolic')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- 4.拡張期血圧 -->
                        <div>
                            <label for="blood_pressure_diastolic" class="block text-xs font-medium text-gray-600 mb-1">
                                拡張期血圧（mmHg）
                            </label>

                            <input
                                type="number"
                                name="blood_pressure_diastolic"
                                id="blood_pressure_diastolic"
                                min="0" max="150"
                                value="{{ old('blood_pressure_diastolic') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50 font-bold text-gray-800 text-base">

                            @error('blood_pressure_diastolic')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- 5.呼吸数 -->
                        <div>
                            <label for="respiratory_rate" class="block text-xs font-medium text-gray-600 mb-1">
                                呼吸数（回/分）
                            </label>

                            <input
                                type="number"
                                name="respiratory_rate"
                                id="respiratory_rate"
                                min="0" max="50"
                                value="{{ old('respiratory_rate') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50 font-bold text-gray-800 text-base">

                            @error('respiratory_rate')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- 6.SpO2 -->
                        <div>
                            <label for="spo2" class="block text-xs font-medium text-gray-600 mb-1">
                                SpO2（%）
                            </label>

                            <input
                                type="number"
                                name="spo2"
                                id="spo2"
                                min="0" max="100"
                                value="{{ old('spo2') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50 font-bold text-gray-800 text-base">

                            @error('spo2')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- 測定日時 -->
                        <div class="col-span-2">
                            <label for="measured_at" class="block text-xs font-medium text-gray-600 mb-1">
                                測定日時
                            </label>

                            <input
                                type="datetime-local"
                                name="measured_at"
                                id="measured_at"
                                required
                                value="{{ old('measured_at', now()->format('Y-m-d\TH:i')) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50 font-bold text-gray-800 text-base">

                            @error('measured_at')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror

                        </div>
                    </div>
                    <!-- メモ -->
                    <div>
                        <label for="vital_memo" class="block text-xs font-medium text-gray-600 mb-1">
                            検温時記録（任意）
                        </label>

                            <textarea
                                name="vital_memo"
                                id="vital_memo"
                                rows="2"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50  text-gray-700 text-sm"
                                >{{ old('vital_memo') }}</textarea>

                        @error('vital_memo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- 登録ボタン -->
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2 rounded-md shadow transition-colors text-sm">
                            記録を確定する
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
