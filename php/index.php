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

// Node-RED APIへのアクセス処理
echo "<h2>ユーザー検索API</h2>";
echo "<form method='get'>";
echo "<input type='text' name='user_id' placeholder='ユーザーID' value='" . ($_GET['user_id'] ?? '') . "'>";
echo "<button type='submit'>検索</button>";
echo "</form>";

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $api_url = "http://nodered:1880/api/users/" . urlencode($user_id);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    echo "<div style='margin-top: 20px;'>";
    echo "<h3>API応答結果</h3>";
    echo "<pre>";
    if ($http_code === 200) {
        $user_data = json_decode($response, true);
        echo "ユーザー情報:\n";
        echo "名前: " . $user_data['name'] . "\n";
        echo "年齢: " . $user_data['age'] . "\n";
    } else {
        $error_data = json_decode($response, true);
        echo "エラー: " . ($error_data['error'] ?? '不明なエラー') . "\n";
        echo "ステータスコード: " . $http_code;
    }
    echo "</pre>";
    echo "</div>";
}

// 計算機能へのリンク
echo "<br><br><a href='calc.php'>計算機能を実行</a>";

