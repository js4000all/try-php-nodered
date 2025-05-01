<?php

// 基本的な計算機能の実装
class Calculator {
    private $result = 0;

    public function add($a, $b) {
        $this->result = $a + $b;
        return $this->result;
    }

    public function subtract($a, $b) {
        $this->result = $a - $b; 
        return $this->result;
    }

    public function multiply($a, $b) {
        $this->result = $a * $b;
        return $this->result;
    }

    public function divide($a, $b) {
        if ($b == 0) {
            throw new Exception("0による除算は不可能。");
        }
        $this->result = $a / $b;
        return $this->result;
    }

    public function getResult() {
        return $this->result;
    }
}

// 計算機能の実行
try {
    $calc = new Calculator();
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $num1 = $_POST["num1"] ?? 0;
        $num2 = $_POST["num2"] ?? 0;
        $operation = $_POST["operation"] ?? "add";
        
        $result = match($operation) {
            "add" => $calc->add($num1, $num2),
            "subtract" => $calc->subtract($num1, $num2),
            "multiply" => $calc->multiply($num1, $num2),
            "divide" => $calc->divide($num1, $num2),
            default => 0
        };
    }
?>

<form method="post">
    <input type="number" name="num1" value="<?php echo $_POST["num1"] ?? ""; ?>" placeholder="数値1" required>
    
    <select name="operation">
        <option value="add" <?php echo ($operation ?? "") == "add" ? "selected" : ""; ?>>加算</option>
        <option value="subtract" <?php echo ($operation ?? "") == "subtract" ? "selected" : ""; ?>>減算</option>
        <option value="multiply" <?php echo ($operation ?? "") == "multiply" ? "selected" : ""; ?>>乗算</option>
        <option value="divide" <?php echo ($operation ?? "") == "divide" ? "selected" : ""; ?>>除算</option>
    </select>
    
    <input type="number" name="num2" value="<?php echo $_POST["num2"] ?? ""; ?>" placeholder="数値2" required>
    
    <button type="submit">計算実行</button>
</form>

<?php if (isset($result)): ?>
    <div>計算結果: <?php echo $result; ?></div>
<?php endif;

} catch (Exception $e) {
    echo "エラー発生: " . $e->getMessage();
}
