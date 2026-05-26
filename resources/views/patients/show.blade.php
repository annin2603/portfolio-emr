<x-app-layout>
   <!-- 詳細画面上のヘッダー部分 -->
    <x-slot name="header">
        <div class="space-y-4">
            <div class="flex items-center justify-between gap-4">
                <h2 class="font-semibold text-sm text-gray-500 uppercase tracking-wider whitespace-nowrap">
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

            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 border-l-4 border-blue-500">

                <div class="pb-4">
                    <div class="flex flex-col md:flex-row justify-between items-start mb-3 gap-2">
                        <div class="text-right text-sm bg-blue-100 text-blue-800 px-3 py-1 rounded-full mb-4">
                            <p><strong>患者ID：</strong>{{ $patient->patient_id }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-bold text-gray-600">
                                {{ $patient->room_number }}号室 - {{ $patient->bed_number }}ベッド
                            </span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 text-sm pt-2 pb-4 border-t border-b border-gray-100">
                    <h4 class="text-lg text-gray-900 font-bold mt-3">📝 患者基本情報</h4>
                    <div>
                        <p class="text-gray-400 text-xs font-medium">性別</p>
                        <p class="font-bold text-gray-800 mt-0.5 textbase">{{ $patient->gender }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs font-medium">生年月日</p>
                        <p class="font-bold text-gray-800 mt-0.5 textbase">
                            {{ \Carbon\Carbon::parse($patient->birthday)->format('Y年m月d日') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs font-medium">血液型</p>
                        <p class="font-bold text-gray-800 mt-0.5 textbase">{{ $patient->blood_type }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs font-medium">アレルギー情報</p>
                        <p class="font-bold text-red-500 mt-0.5 textbase">{{ $patient->allergy ?? 'なし' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs font-medium">備考・申し送り事項</p>
                        <p class="font-bold text-gray-800 mt-1 textbase">{{ $patient->memo ?? '特記事項なし' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overfllow-hidden shadow-sm rounded-lg p-6">
                <h4 class="text-lg font-bold text-gray-800 mb-4">📈 バイタルサイン記録</h4>

                <div class="p-4 bg-gray-50 rounded border border-gray-200">
                    <p class="text-gray-600 text-sm font-medium mb-2">バイタルサイン</p>
                    <p class="text-gray-500 text-sm leading-relaxed">ここに血圧や体温を入力するフォームと、これまでのグラフや履歴を表示</p>
                </div>
            </div>




        </div>
    </div>
</x-app-layout>
