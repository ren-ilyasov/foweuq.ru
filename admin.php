<!DOCTYPE html>
<html lang="ru">
<head>
<link rel="stylesheet" href="rip.css">
    <!-- Подключение CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<br><br><br><br><br>

<?php
session_start();

// Проверка логина и пароля
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['username'] === 'beauty' && $_POST['password'] === 'pass') {
        $_SESSION['loggedin'] = true;
    } else {
        $error = "Неверный логин или пароль.";
    }
}

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    // Если не авторизован, показываем форму логина
    echo '<form method="POST">
            <label for="username">Логин:</label>
            <input type="text" name="username" required>
            <label for="password">Пароль:</label>
            <input type="password" name="password" required>
            <button type="submit">Войти</button>
          </form>';
          if (isset($_POST['logout'])) {
            session_destroy();
            header("Location: login.php"); 
            
        }
    exit;
}
?>
<form method="POST">
    <button type="submit" name="logout" class="btn btn-danger">Выход</button>
</form>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора - Запись на маникюр</title>
</head>
<body>
<header>
    <h1>Ноготочки</h1>
</header>
<br>
<div class="container">
    <h2>Панель администратора</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ФИО</th>
                <th>Телефон</th>
                <th>Дата и время бронирования</th>
                <th>Выбранный мастер</th>
                <th>Статус</th>
                <th>Изменить статус</th>
            </tr>
        </thead>
        <tbody id="appointments">
            <?php
            // Подключение к базе данных
            $conn = new mysqli('localhost', 'username', 'password', 'database');

            // Проверка подключения
            if ($conn->connect_error) {
                die("Ошибка подключения: " . $conn->connect_error);
            }

            // Запрос к базе данных
            $sql = "SELECT full_name, phone, appointment_time, master, status FROM appointments";
            $result = $conn->query($sql);

            // Проверка наличия результатов
            if ($result->num_rows > 0) {
                // Вывод данных каждой строки
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['full_name']}</td>
                            <td>{$row['phone']}</td>
                            <td>{$row['appointment_time']}</td>
                            <td>{$row['master']}</td>
                            <td class='status'>{$row['status']}</td>
                            <td><button class='change-status btn btn-primary' onclick='changeStatus(this)'>Изменить статус</button></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Нет заявок</td></tr>";
            }

            // Закрытие подключения
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

<script>
    function changeStatus(button) {
        const row = button.closest('tr');
        const statusCell = row.querySelector('.status');

        // Пример изменения статуса
        if (statusCell.innerText === "Новое") {
            statusCell.innerText = "Подтверждено";
        } else if (statusCell.innerText === "Подтверждено") {
            statusCell.innerText = "Отклонено";
        } else {
            statusCell.innerText = "Новое";
        }
    }
</script>
</body>
</html>
