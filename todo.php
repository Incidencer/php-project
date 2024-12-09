<?php
session_start(); // Начинаем сессию

if (!isset($_SESSION['valid_user'])) {
    // Если не вошел, перенаправляем на страницу входа
    header('Location: login.php');
    exit();
}

// Если еще нет задач в сессии, создаем пустой массив
if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

// Добавление задачи в список
if (isset($_POST['task']) && !empty($_POST['task'])) {
    $_SESSION['tasks'][] = ['task' => $_POST['task'], 'done' => false];
}

// Завершение задачи
if (isset($_GET['done'])) {
    $index = $_GET['done'];
    $_SESSION['tasks'][$index]['done'] = true;
}

// Удаление задачи
if (isset($_GET['delete'])) {
    $index = $_GET['delete'];
    unset($_SESSION['tasks'][$index]);
    $_SESSION['tasks'] = array_values($_SESSION['tasks']); // Пересчитываем индексы

    // Перенаправление на текущую страницу для обновления списка
    header("Location: todo.php");
    exit(); // Останавливаем выполнение скрипта, чтобы не было дальнейших операций
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo List</title>
    <link rel="stylesheet" href="todostyle.css"> <!-- Подключаем стили -->
</head>
<body>

<div class="todo-container">
    <h1>ToDo List</h1>

    <!-- Форма для добавления задачи -->
    <form method="post" class="task-form">
        <input type="text" name="task" placeholder="Добавьте задачу" required>
        <button type="submit">Добавить</button>
    </form>

    <!-- Список задач -->
    <ul>
        <?php foreach ($_SESSION['tasks'] as $index => $task): ?>
            <li class="task <?php echo $task['done'] ? 'done' : ''; ?>">
                <?php echo $task['task']; ?>
                <!-- Кнопка для завершения задачи -->
                <?php if (!$task['done']): ?>
                    <a href="?done=<?php echo $index; ?>">✔</a>
                <?php endif; ?>
                <!-- Кнопка для удаления задачи -->
                <a href="?delete=<?php echo $index; ?>" class="delete">❌</a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<!-- Формы для перехода -->
<form method="post" action="logout.php">
    <input type="submit" value="Выход">
</form>
<form method="post" action="index.php">
    <input type="submit" value="Калькулятор">
</form>
<form method="post" action="snake.php">
    <input type="submit" value="Змейка">
</form>

</body>
</html>
