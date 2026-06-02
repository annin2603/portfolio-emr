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
                    📝 バイタルサインの編集
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

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 border-t-4 border-emerald-500">
                <h3 class="text-lg font-bold text-gray-800 mb-6">📝 バイタルサインの編集</h3>

                <form action="{{ route('patients.vitals.update', [$patient, $vital_sign]) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT') <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">体温 (℃)</label>
                            <input type="number" name="body_temperature" step="0.1" min="30.0" max="45.0"
                                value="{{ old('body_temperature', $vital_sign->body_temperature) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 font-bold text-gray-800">
                            @error('body_temperature') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">脈拍数 (回/分)</label>
                            <input type="number" name="pulse_rate"
                                value="{{ old('pulse_rate', $vital_sign->pulse_rate) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 font-bold text-gray-800">
                            @error('pulse_rate') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">収縮期血圧 (mmHg)</label>
                            <input type="number" name="blood_pressure_systolic"
                                value="{{ old('blood_pressure_systolic', $vital_sign->blood_pressure_systolic) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 font-bold text-gray-800">
                            @error('blood_pressure_systolic') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">拡張期血圧 (mmHg)</label>
                            <input type="number" name="blood_pressure_diastolic"
                                value="{{ old('blood_pressure_diastolic', $vital_sign->blood_pressure_diastolic) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 font-bold text-gray-800">
                            @error('blood_pressure_diastolic') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">呼吸数 (回/分)</label>
                            <input type="number" name="respiratory_rate"
                                value="{{ old('respiratory_rate', $vital_sign->respiratory_rate) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 font-bold text-gray-800">
                            @error('respiratory_rate') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">SpO2 (%)</label>
                            <input type="number" name="spo2" min="0" max="100"
                                value="{{ old('spo2', $vital_sign->spo2) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 font-bold text-gray-800">
                            @error('spo2') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="col-span-2">
                            <label class="block text-xs font-medium text-gray-600 mb-1">測定日時</label>
                            <input type="datetime-local" name="measured_at" required
                                value="{{ old('measured_at', $vital_sign->measured_at->format('Y-m-d\TH:i')) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 text-gray-700">
                            @error('measured_at') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">検温時記録・メモ</label>
                        <textarea name="vital_memo" rows="3"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50 text-sm text-gray-700">{{ old('vital_memo', $vital_sign->vital_memo) }}</textarea>
                        @error('vital_memo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('patients.show', $patient) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold px-4 py-2 rounded-md shadow transition-colors text-sm">
                            キャンセル
                        </a>
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-2 rounded-md shadow transition-colors text-sm">
                            修正を確定する
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
