<?php


echo "<a href='/'>TOP</a>";
echo "<br>";


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

// ユーザー登録フォーム
echo "<h2>ユーザー登録</h2>";
echo "<form method='post' action=''>";
echo "<input type='text' name='name' placeholder='名前' required><br>";
echo "<input type='number' name='age' placeholder='年齢' required><br>";
echo "<button type='submit' name='register'>登録</button>";
echo "</form>";

// ユーザー登録処理
if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    
    $api_url = "http://nodered:1880/api/users";
    $data = json_encode(['name' => $name, 'age' => $age]);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data)
    ]);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    echo "<div style='margin-top: 20px;'>";
    echo "<h3>登録結果</h3>";
    echo "<pre>";
    if ($http_code === 200) {
        echo "ユーザー登録が完了しました。\n";
        $result = json_decode($response, true);
        echo "登録されたユーザー情報:\n";
        echo "ID: " . $result['id'] . "\n";
        echo "名前: " . $result['name'] . "\n";
        echo "年齢: " . $result['age'] . "\n";
    } else {
        $error_data = json_decode($response, true);
        echo "エラー: " . ($error_data['error'] ?? '不明なエラー') . "\n";
        echo "ステータスコード: " . $http_code;
    }
    echo "</pre>";
    echo "</div>";
}

// ユーザー一覧の取得と表示
echo "<h2>ユーザー一覧</h2>";

$api_url = "http://nodered:1880/api/users";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "<div style='margin-top: 20px;'>";
if ($http_code === 200) {
    $users = json_decode($response, true);
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>ID</th><th>名前</th><th>年齢</th></tr>";
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($user['id']) . "</td>";
        echo "<td>" . htmlspecialchars($user['name']) . "</td>";
        echo "<td>" . htmlspecialchars($user['age']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "ユーザー一覧の取得に失敗しました。";
    echo "ステータスコード: " . $http_code;
}
echo "</div>";

// 計算機能へのリンク
echo "<br><br><a href='calc.php'>計算機能を実行</a>";

