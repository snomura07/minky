<h1 class="text-2xl font-semibold text-gray-900">
    <?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>
</h1>

<p class="text-gray-500 mt-1">
    システムの概要や統計情報を確認できます。
</p>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">

    <!-- カード1 -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
        <h2 class="text-lg font-medium text-gray-800">ユーザー管理</h2>
        <p class="text-gray-500 mt-2">ユーザー一覧や権限設定を管理します。</p>
        <button class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            開く
        </button>
    </div>

    <!-- カード2 -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
        <h2 class="text-lg font-medium text-gray-800">ログ閲覧</h2>
        <p class="text-gray-500 mt-2">システムログを確認できます。</p>
        <button class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            開く
        </button>
    </div>

    <!-- カード3 -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
        <h2 class="text-lg font-medium text-gray-800">設定</h2>
        <p class="text-gray-500 mt-2">アプリケーションの設定を変更します。</p>
        <button class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            開く
        </button>
    </div>

</div>
