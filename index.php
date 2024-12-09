<?php
session_start();
// Если форма отправлена, обрабатываем операцию
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $num1 = $_POST['num1'];
    $num2 = $_POST['num2'];
    $operator = $_POST['operator'];


    if (is_numeric($num1) && is_numeric($num2)) {
        switch ($operator) {
            case '+':
                $result = $num1 + $num2;
                break;
            case '-':
                $result = $num1 - $num2;
                break;
            case '*':
                $result = $num1 * $num2;
                break;
            case '/':
                $result = ($num2 != 0) ? $num1 / $num2 : "Ошибка";
                break;
            default:
                $result = "Неизвестная операция";
        }
    } else {
        $result = "Ошибка: введите числа";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Калькулятор на PHP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="calculator">
    <h1>Калькулятор</h1>
    <form action="" method="post">
        <input type="text" name="num1" placeholder="Число 1" value="<?= isset($num1) ? $num1 : ''; ?>" required>
        <select name="operator" required>
            <option value="+" <?= isset($operator) && $operator == '+' ? 'selected' : ''; ?>>+</option>
            <option value="-" <?= isset($operator) && $operator == '-' ? 'selected' : ''; ?>>-</option>
            <option value="*" <?= isset($operator) && $operator == '*' ? 'selected' : ''; ?>>*</option>
            <option value="/" <?= isset($operator) && $operator == '/' ? 'selected' : ''; ?>>/</option>
        </select>
        <input type="text" name="num2" placeholder="Число 2" value="<?= isset($num2) ? $num2 : ''; ?>" required>
        <button type="submit">Вычислить</button>
    </form>

    <div class="result">
        <?php
        if (isset($result)) {
            echo "<h2>Результат: $result</h2>";
        }
        ?>
    </div>
    <form method="post" action="todo.php">
        <input type="submit" value="Todo - лист">
    </form>
    <form method="post" action="logout.php">
        <input type="submit" value="Выход">
    </form>
    <form method="post" action="snake.php">
        <input type="submit" value="Змейка">
    </form>
</div>
</body>
</html>
