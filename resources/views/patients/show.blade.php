<x-app-layout>
   <!-- 詳細画面上のヘッダー部分 -->
    <x-slot name="header">
        <div class="space-y-4">
            <div class="mb-3">
                <a href="{{ route('dashboard') }}"class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
                    <span class="rounded-lg border border-blue-600 px-3 py-1.5 ml-2">⬅️ 入院患者一覧へ戻る</span>
                </a>
            </div>

            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-base text-gray-500 uppercase tracking-wider">
                    👤 患者詳細
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
    <!-- 成功メッセージ表示 -->
    @if(session('status'))
        <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-700 px-4 py-3">
            {{ session('status') }}
        </div>
    @endif
    <!-- 詳細画面のメイン中身 -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 border-l-4 border-blue-500">
                <!-- 患者の基本情報 -->
                <h4 class="text-lg text-gray-900 font-bold mt-2 mb-6">📝 患者基本情報</h4>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-5 text-sm pt-2 pb-4 border-t border-b border-gray-100">
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
                        <p class="text-gray-400 text-xs font-medium">年齢</p>
                        <p class="font-bold text-gray-800 mt-0.5 text-base">
                            {{ \Carbon\Carbon::parse($patient->birthday)->age }}歳
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

                <form action="{{ route('patients.vitals.store', $patient) }}" method="POST" class="space-y-6">
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

                <!-- バイタル折れ線グラフ -->
                <h4 class="text-lg font-bold text-gray-800 mb-4">📊 バイタルサイン推移グラフ</h4>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                    <!-- 体温グラフ -->
                    <div class="bg-white shadow-sm rounded-lg p-6">
                        <h4 class="text-sm font-bold text-gray-800 mb-4">
                            体温
                        </h4>
                        <canvas id="temperatureChart" height="80"></canvas>
                    </div>
                    <!-- 血圧グラフ -->
                    <div class="bg-white shadow-sm rounded-lg p-6 ">
                        <h4 class="text-sm font-bold text-gray-800 mb-4">
                             血圧
                        </h4>
                        <canvas id="bloodPressureChart" height="80"></canvas>
                    </div>
                    <!-- 脈拍グラフ -->
                    <div class="bg-white shadow-sm rounded-lg p-6">
                        <h4 class="text-sm font-bold text-gray-800 mb-4">
                             脈拍
                        </h4>
                        <canvas id="pulseChart" height="80"></canvas>
                    </div>
                    <!-- SpO2グラフ -->
                    <div class="bg-white shadow-sm rounded-lg p-6">
                        <h4 class="text-sm font-bold text-gray-800 mb-4">
                             SpO₂
                        </h4>
                        <canvas id="spo2Chart" height="80"></canvas>
                    </div>
                    <!-- 呼吸数グラフ -->
                    <div class="bg-white shadow-sm rounded-lg p-6">
                        <h4 class="text-sm font-bold text-gray-800 mb-4">
                             呼吸数
                        </h4>
                        <canvas id="respiratoryChart" height="80"></canvas>
                    </div>

                </div>


                <!-- バイタル履歴 -->
                <div class="mt-8 pt-6 border-t border-gray-100">
                    <h5 class="text-md font-bold text-gray-700 mb-4">📋 過去のバイタルサイン</h5>

                    @if($patient->vitalSigns->isEmpty())
                        <p class="text-sm text-gray-500 py-4 text-center bg-gray-50 rounded">バイタルサインの記録はまだありません。</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-600 border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                                        <th class="px-3 py-3 font-semibold">測定日時</th>
                                        <th class="px-3 py-3 font-semibold">体温</th>
                                        <th class="px-3 py-3 font-semibold">脈拍</th>
                                        <th class="px-3 py-3 font-semibold">血圧</th>
                                        <th class="px-3 py-3 font-semibold">呼吸数</th>
                                        <th class="px-3 py-3 font-semibold">SpO2</th>
                                        <th class="px-3 py-3 font-semibold">検温時記録</th>
                                        <th class="w-24"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($patient->vitalSigns as $vital)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <!-- 測定日時 -->
                                            <td class="px-3 py-3.5 whitespace-nowrap font-medium text-gray-900">
                                                {{ $vital->measured_at->format('Y/m/d H:i') }}
                                            </td>
                                            <!-- 体温 -->
                                            <td class="px-3 py-3.5 whitespace-nowrap">
                                                @if(!is_null($vital->body_temperature))
                                                    <span class="font-bold text-gray-900">{{ $vital->body_temperature }}</span> <span class="text-xs text-gray-400">℃</span>
                                                @else
                                                    <span class="text-gray-300">-</span>
                                                @endif
                                            </td>
                                            <!-- 脈拍 -->
                                            <td class="px-3 py-3.5 whitespace-nowrap">
                                                @if(!is_null($vital->pulse_rate))
                                                    <span class="font-bold text-gray-900">{{ $vital->pulse_rate }}</span> <span class="text-xs text-gray-400">回</span>
                                                @else
                                                    <span class="text-gray-300">-</span>
                                                @endif
                                            </td>
                                            <!-- 血圧 -->
                                            <td class="px-3 py-3.5 whitespace-nowrap">
                                                @if(!is_null($vital->blood_pressure_systolic) || !is_null($vital->blood_pressure_diastolic))
                                                    <span class="font-bold text-gray-900">{{ $vital->blood_pressure_systolic ?? '-' }}</span>
                                                    <span class="text-gray-400 mx-0.5">/</span>
                                                    <span class="font-bold text-gray-900">{{ $vital->blood_pressure_diastolic ?? '-' }}</span>
                                                    <span class="text-xs text-gray-400">mmHg</span>
                                                @else
                                                    <span class="text-gray-300">-</span>
                                                @endif
                                            </td>
                                            <!-- 呼吸数 -->
                                            <td class="px-3 py-3.5 whitespace-nowrap">
                                                @if(!is_null($vital->respiratory_rate))
                                                    <span class="font-bold text-gray-900">{{ $vital->respiratory_rate }}</span> <span class="text-xs text-gray-400">回</span>
                                                @else
                                                    <span class="text-gray-350">-</span>
                                                @endif
                                            </td>
                                            <!-- SpO2 -->
                                            <td class="px-3 py-3.5 whitespace-nowrap">
                                                @if(!is_null($vital->spo2))
                                                    <span class="font-bold text-gray-900">{{ $vital->spo2 }}</span> <span class="text-xs text-gray-400">%</span>
                                                @else
                                                    <span class="text-gray-350">-</span>
                                                @endif
                                            </td>
                                            <!-- 検温時記録 -->
                                            <td class="px-3 py-3.5 max-w-xs text-xs text-gray-500 break-words">
                                                {{ $vital->vital_memo ?? '---' }}
                                            </td>
                                            <!-- ボタン -->
                                            <td class="w-24 whitespace-nowrap space-x-2">
                                                <a href="{{ route('patients.vitals.edit', [$patient, $vital]) }}" class="text-xs text-emerald-600 hover:text-emerald-900 bg-emerald-50 px-2 py-1 rounded border border-emerald-200 transition-colors">
                                                    編集
                                                </a>

                                                <form action="{{ route('patients.vitals.destroy', [$patient, $vital]) }}" method="POST" onsubmit="return confirm('このバイタル記録を削除してもよろしいですか？');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-xs text-rose-600 hover:text-rose-900 bg-rose-50 px-2 py-1 rounded border border-rose-200 transition-colors">
                                                        削除
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // 体温
        const ctx = document.getElementById('temperatureChart');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    @foreach($vital_history as $vital)
                        '{{ $vital->measured_at->format("m/d H:i") }}',
                    @endforeach
                ],
                datasets: [{
                    label: '体温(℃)',
                    data: [
                        @foreach($vital_history as $vital)
                            {{ $vital->body_temperature ?? 'null' }},
                        @endforeach
                    ],
                    borderColor: '#f59e0b',
                    backgroundColor: '#f59e0b',
                    tension: 0,
                    spanGaps: true,
                    pointRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        min:35,
                        max:40
                    }
                }
            }
        });

        // 血圧
        const bpCtx = document.getElementById('bloodPressureChart');

        new Chart(bpCtx, {
            type: 'line',
            data: {
                labels: [
                    @foreach($vital_history as $vital)
                        '{{ $vital->measured_at->format("m/d H:i") }}',
                    @endforeach
                ],
                datasets: [
                    {
                        label: '収縮期血圧',
                        data: [
                            @foreach($vital_history as $vital)
                                {{ $vital->blood_pressure_systolic ?? 'null' }},
                            @endforeach
                        ],
                        borderColor: '#dc2626',
                        backgroundColor: '#dc2626',
                        tension: 0,
                        spanGaps: true,
                        pointRadius: 4,
                    },
                    {
                        label: '拡張期血圧',
                        data: [
                            @foreach($vital_history as $vital)
                                {{ $vital->blood_pressure_diastolic ?? 'null' }},
                            @endforeach
                        ],
                        borderColor: '#2563eb',
                        backgroundColor: '#2563eb',
                        tension: 0,
                        spanGaps: true,
                        pointRadius: 4,
                    }
                ]
            },
            options: {
                maintainAspectRatio: true,
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: false
                    }
                }
            }
        });

        // 脈拍
        const pulseCtx = document.getElementById('pulseChart');

        new Chart(pulseCtx, {
            type: 'line',
            data: {
                labels: [
                    @foreach($vital_history as $vital)
                        '{{ $vital->measured_at->format("m/d H:i") }}',
                    @endforeach
                ],
                datasets: [{
                    label: '脈拍',
                    data: [
                        @foreach($vital_history as $vital)
                            {{ $vital->pulse_rate ?? 'null' }},
                        @endforeach
                    ],
                    borderColor: '#16a34a',
                    backgroundColor: '#16a34a',
                    tension: 0,
                    spanGaps: true,
                    pointRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,

            }
        });

        // SpO2
        const spo2Ctx = document.getElementById('spo2Chart');

        new Chart(spo2Ctx, {
            type: 'line',
            data: {
                labels: [
                    @foreach($vital_history as $vital)
                        '{{ $vital->measured_at->format("m/d H:i") }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'SpO₂',
                    data: [
                        @foreach($vital_history as $vital)
                            {{ $vital->spo2 ?? 'null' }},
                        @endforeach
                    ],
                    borderColor: '#06b6d4',
                    backgroundColor: '#06b6d4',
                    tension: 0,
                    spanGaps: true,
                    pointRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        min:60,
                        max:100
                    }
                }
            }
        });

        // 呼吸数
        const respiratoryCtx = document.getElementById('respiratoryChart');

        new Chart(respiratoryCtx, {
            type: 'line',
            data: {
                labels: [
                    @foreach($vital_history as $vital)
                        '{{ $vital->measured_at->format("m/d H:i") }}',
                    @endforeach
                ],
                datasets: [{
                    label: '呼吸数',
                    data: [
                        @foreach($vital_history as $vital)
                            {{ $vital->respiratory_rate ?? 'null' }},
                        @endforeach
                    ],
                    borderColor: '#8b5cf6',
                    backgroundColor: '#8b5cf6',
                    tension: 0,
                    spanGaps: true,
                    pointRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true
            }
        });
    </script>

</x-app-layout>
