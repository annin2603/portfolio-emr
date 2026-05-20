<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🏥 電子カルテシステム (EMR)
            </h2>
            <!-- 👤 画面上部：ログイン者の情報を表示 -->
            <div class="text-sm text-gray-600 bg-blue-50 px-4 py-2 rounded-lg border border-blue-100">
                ログイン職員: <span class="font-bold text-blue-700">{{ $staff->name }}</span> さん
                (職員番号: <span class="font-mono bg-white px-1 border rounded">{{ $staff->login_id }}</span>)
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-700 flex items-center">
                        👥 入院患者一覧
                    </h3>
                    <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded-lg shadow-sm text-sm transition-colors flex items-center">
                        新規患者登録
                    </a>
                    <span class="text-sm text-gray-500">現在 {{ $patients->count() }} 名が入院中</span>
                </div>

                <!-- 📊 画面中～下部：患者一覧をテーブルで表示 -->
                <div class="overflow-x-auto border border-gray-200 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 font-bold text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left">病室-ベッド</th>
                                <th class="px-4 py-3 text-left">患者ID</th>
                                <th class="px-4 py-3 text-left">氏名 (フリガナ)</th>
                                <th class="px-4 py-3 text-center">性別</th>
                                <th class="px-4 py-3 text-center">生年月日</th>
                                <th class="px-4 py-3 text-left">血液型</th>
                                <th class="px-4 py-3 text-left">アレルギー</th>
                                <th class="px-4 py-3 text-left">備考・メモ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($patients as $patient)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3 font-bold text-gray-900">{{ $patient->room_number }}号室 - {{ $patient->bed_number }}</td>
                                    <td class="px-4 py-3 font-mono text-gray-600">{{ $patient->patient_id }}</td>
                                    <td class="px-4 py-3">
                                        <div class="font-bold text-gray-900">{{ $patient->name }}</div>
                                        <div class="text-xs text-gray-400">{{ $patient->kana }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="px-2 py-1 rounded-full text-xs font-bold {{ $patient->gender === '男性' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' }}">
                                            {{ $patient->gender }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center text-gray-600">{{ $patient->birthday }}</td>
                                    <td class="px-4 py-3 text-gray-700 font-mono">{{ $patient->blood_type ?? '未検' }}</td>
                                    <td class="px-4 py-3">
                                        @if($patient->allergy)
                                            <span class="bg-red-50 text-red-700 border border-red-200 px-2 py-0.5 rounded text-xs font-bold">
                                                ⚠️ {{ $patient->allergy }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-xs">なし</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-gray-500 max-w-xs truncate">{{ $patient->memo ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-8 text-center text-gray-400 bg-gray-50">
                                        📭 現在、登録されている患者データがありません。<br>
                                        <span class="text-xs text-gray-400">(データベースにデータを入れるとここに表示されます！)</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
