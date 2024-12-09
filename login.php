<?php
session_start(); // Начинаем сессию

// Данные пользователя (в реальных приложениях их обычно хранить в базе данных)
$valid_user = "admin";
$valid_password = "admin";

// Проверяем, был ли отправлен логин
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Если логин и пароль правильные, создаем сессию
    if ($username == $valid_user && $password == $valid_password) {
        $_SESSION['loggedin'] = true; // Устанавливаем сессионную переменную
        header("Location: index.php"); // Перенаправляем на страницу калькулятора
        exit();
    } else {
        $error = "Неверный логин или пароль!";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="login-form">
    <h1>Вход в систему</h1>
    <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
    <form action="" method="post">
        <input type="text" name="username" placeholder="Логин" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Войти</button>
    </form>
</div>
</body>
</html>


<style>
    /* Общие стили для страницы */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        flex-direction: column; /* Центрируем элементы по вертикали */
    }

    /* Контейнер для todo-листа */
    .todo-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 600px;
        padding: 30px;
        margin-bottom: 30px; /* Отступ снизу для кнопок */
    }

    /* Заголовок */
    h1 {
        text-align: center;
        color: #333;
        font-size: 2em;
        margin-bottom: 20px;
    }

    /* Форма добавления задачи */
    .task-form {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    /* Стиль для поля ввода */
    .task-form input {
        width: 80%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1em;
    }

    /* Стиль для кнопки добавления задачи */
    .task-form button {
        width: 18%;
        padding: 10px;
        border: none;
        background-color: #4CAF50;
        color: white;
        font-size: 1em;
        cursor: pointer;
        border-radius: 5px;
    }

    .task-form button:hover {
        background-color: #45a049;
    }

    /* Стили для списка задач */
    ul {
        list-style: none;
        padding: 0;
    }

    /* Стиль для каждой задачи */
    .task {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 10px;
        font-size: 1.1em;
    }

    /* Стиль для завершенных задач */
    .task.done {
        text-decoration: line-through;
        color: #999;
    }

    /* Ссылки на действия с задачами */
    .task a {
        text-decoration: none;
        font-size: 1.2em;
        color: #4CAF50;
        margin-left: 10px;
    }

    /* Стили при наведении на ссылки */
    .task a:hover {
        color: #45a049;
    }

    /* Стили для кнопки удаления задачи */
    .task.delete {
        color: red;
    }



    input[type="submit"] {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }


    /* Дополнительный отступ для кнопок */
    form input[type="submit"]:not(:last-child) {
        margin-bottom: 10px;
    }

</style>
