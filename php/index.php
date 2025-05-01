<?php

// 基本的なPHPの動作確認用コード
$message = "情報統合思念体からの応答を確認。";
echo $message;

// 簡単なデータ処理のサンプル
$data = [
    'id' => 1,
    'name' => '長門有希',
    'role' => '文芸部部長'
];

echo "<pre>";
print_r($data);
echo "</pre>";

// エラーハンドリングのサンプル
try {
    // 処理テスト
    $result = 100 / 2;
    echo "計算結果: " . $result;
} catch (Exception $e) {
    echo "エラー発生: " . $e->getMessage();
}

// 現在時刻の表示
$now = new DateTime();
echo "<br>現在時刻: " . $now->format('Y-m-d H:i:s');

// 計算機能へのリンク
echo "<br><br><a href='calc.php'>計算機能を実行</a>";

