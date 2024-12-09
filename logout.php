<?php
session_start();
session_unset(); // Убираем все данные сессии
session_destroy(); // Уничтожаем сессию
header("Location: login.php"); // Перенаправляем на страницу входа
exit();
?>
<?php
