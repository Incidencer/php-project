<?php
session_start(); // Начинаем сессию

// Инициализация игры
if (!isset($_SESSION['snake'])) {
    $_SESSION['snake'] = [
        'body' => [[5, 5]],    // Начальная позиция змейки
        'food' => [10, 10],    // Начальная позиция еды
        'direction' => 'RIGHT', // Направление змейки
        'score' => 0,          // Очки
        'game_over' => false   // Состояние игры
    ];
}

// Обработка событий (передача данных в JS)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['restart'])) {
        $_SESSION['snake'] = [
            'body' => [[5, 5]],
            'food' => [10, 10],
            'direction' => 'RIGHT',
            'score' => 0,
            'game_over' => false
        ];
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Змейка</title>
    <style>
        /* Пиксельный стиль для игры */
        body {
            background-color: #333;
            color: #fff;
            font-family: 'Press Start 2P', cursive; /* Пиксельный шрифт */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        #score {
            font-size: 2em;
            margin-bottom: 20px;
            color: #f2f2f2;
        }

        #game-container {
            display: grid;
            grid-template-columns: repeat(20, 20px);
            grid-template-rows: repeat(20, 20px);
            gap: 1px;
            width: 420px;
            height: 420px;
            margin: auto;
            border: 2px solid #fff;
            background-color: #222;
            box-shadow: 0 0 20px rgba(0, 255, 0, 0.5);
        }

        .cell {
            width: 20px;
            height: 20px;
            background-color: #222;
        }

        .snake {
            width: 20px;  /* Ширина каждой части змейки */
            height: 20px; /* Высота каждой части змейки */
            background-color: #00ff00; /* Ярко-зеленый цвет для змейки */
            border-radius: 50%; /* Округлые углы для объема */
            box-shadow: 0 0 6px rgba(0, 255, 0, 0.8), 0 0 10px rgba(0, 255, 0, 0.6); /* Тени для объема */
        }

        /* Стиль для еды с изображением яблока */
        .food {
            width: 20px;  /* Ширина еды */
            height: 20px; /* Высота еды */
            background-image: url('http://s1.iconbird.com/ico/2013/11/491/w256h2561384698911applered.png'); /* Подставьте путь к картинке яблока */
            background-size: cover; /* Картинка полностью заполняет блок */
            background-position: center; /* Центрирование изображения */
            border-radius: 50%; /* Округлые углы */
            box-shadow: 0 0 6px rgba(255, 0, 0, 0.8), 0 0 10px rgba(255, 0, 0, 0.6); /* Тени для объема */
        }

        /* Кнопка перезапуска */
        .restart-btn {
            margin-top: 20px;
            background-color: #00ff00;
            color: black;
            padding: 10px 20px;
            font-size: 1.5em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.5);
            transition: all 0.3s ease;
        }

        .control-btn {
            margin-top: 20px;
            background-color: #00ff00;
            color: black;
            padding: 10px 20px;
            font-size: 1.5em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.5);
            transition: all 0.3s ease;
        }
        .control-btn:hover {
            background-color: #00cc00;
        }
        .control-btn:active {
            background-color: #3e8e41;
        }
        .control-form {
            display: inline-block;
        }

        .restart-btn:hover {
            background-color: #00cc00;
        }
    </style>
</head>
<body>

<div>
    <div id="score">Очки: <?php echo $_SESSION['snake']['score']; ?></div>
    <div id="game-container"></div>
    <form method="post">
        <button class="restart-btn" type="submit" name="restart">Начать заново</button>
    </form>
    <div class="game-controls">
        <form method="post" action="todo.php" class="control-form">
            <button class="control-btn">Todo-list</button>
        </form>
        <form method="post" action="index.php" class="control-form">
            <button class="control-btn">Калькулятор</button>
        </form>
        <form method="post" action="logout.php" class="control-form">
            <button class="control-btn">Выход</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Данные игры из PHP
        let snake = <?php echo json_encode($_SESSION['snake']['body']); ?>;
        let food = <?php echo json_encode($_SESSION['snake']['food']); ?>;
        let direction = '<?php echo $_SESSION['snake']['direction']; ?>';
        let score = <?php echo $_SESSION['snake']['score']; ?>;
        let gameOver = <?php echo $_SESSION['snake']['game_over'] ? 'true' : 'false'; ?>;

        const gridSize = 20;
        const gameContainer = document.getElementById('game-container');
        const scoreElement = document.getElementById('score');

        function drawBoard() {
            gameContainer.innerHTML = ''; // Очищаем игровое поле

            for (let y = 0; y < gridSize; y++) {
                for (let x = 0; x < gridSize; x++) {
                    let cell = document.createElement('div');
                    cell.classList.add('cell');
                    if (isSnake(x, y)) {
                        cell.classList.add('snake');
                    } else if (food[0] === x && food[1] === y) {
                        cell.classList.add('food');
                    }
                    gameContainer.appendChild(cell);
                }
            }
        }

        function isSnake(x, y) {
            return snake.some(segment => segment[0] === x && segment[1] === y);
        }

        function moveSnake() {
            if (gameOver) return;

            let head = [...snake[0]]; // Копия головы змейки
            switch (direction) {
                case 'UP':
                    head[1]--;
                    break;
                case 'DOWN':
                    head[1]++;
                    break;
                case 'LEFT':
                    head[0]--;
                    break;
                case 'RIGHT':
                    head[0]++;
                    break;
            }

            // Проверка на столкновение со стенками или телом змейки
            if (head[0] < 0 || head[0] >= gridSize || head[1] < 0 || head[1] >= gridSize || isSnake(head[0], head[1])) {
                gameOver = true;
                alert("Игра окончена! Ваши очки: " + score);
                return;
            }

            // Добавление головы
            snake.unshift(head);

            // Проверка на еду
            if (head[0] === food[0] && head[1] === food[1]) {
                score++;
                food = [Math.floor(Math.random() * gridSize), Math.floor(Math.random() * gridSize)]; // Новая еда
            } else {
                snake.pop(); // Удаление хвоста
            }

            // Обновление счета
            scoreElement.textContent = 'Очки: ' + score;
            drawBoard();
        }

        // Управление стрелками
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowUp' && direction !== 'DOWN') {
                direction = 'UP';
            } else if (e.key === 'ArrowDown' && direction !== 'UP') {
                direction = 'DOWN';
            } else if (e.key === 'ArrowLeft' && direction !== 'RIGHT') {
                direction = 'LEFT';
            } else if (e.key === 'ArrowRight' && direction !== 'LEFT') {
                direction = 'RIGHT';
            }
        });

        // Запуск игры
        setInterval(moveSnake, 100); // Обновление змейки каждую сотую секунды

        // Начальная отрисовка
        drawBoard();
    });
</script>

</body>
</html>
