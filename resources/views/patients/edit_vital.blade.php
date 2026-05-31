<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📊 バイタルサイン記録の修正
        </h2>
        <p class="text-2xl text-gray-500 mt-1">
            <span class="font-bold text-gray-800">{{ $patient->name }}</span>
        </p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-6 lg:px-8">

            <div class="mb-4">
                <a href="{{ route('patients.show', $patient) }}" class="text-sm text-gray-500 hover:text-gray-700">
                    ← 患者詳細カルテに戻る
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 border-t-4 border-emerald-500">
                <h3 class="text-lg font-bold text-gray-800 mb-6">📝 記録の編集</h3>

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
