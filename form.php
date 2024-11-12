
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="rip.css">
    <!-- Подключение CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Формирование заявки</title>
   
</head>
<body>
    <header>
    <h1>Формирование заявки на бронирование</h1>
</header>
<br><br><br><br><br><br><br>
    
    <form id="bookingForm">
        <label for="master">Выберите мастера:</label>
        <select id="master" name="master" required>
            <option value="">--Выберите мастера--</option>
            <option value="master1">Мастер 1(Ольга)</option>
            <option value="master2">Мастер 2(Рита)</option>
            <option value="master3">Мастер 3(Сулпан)</option>
        </select>

        <label for="date">Выберите дату:</label>
        <input type="date" id="date" name="date" required>

        <label for="time">Выберите время:</label>
        <select id="time" name="time" required>
            <option value="">--Выберите время--</option>
            <option value="08:00">08:00</option>
            <option value="09:00">09:00</option>
            <option value="10:00">10:00</option>
            <option value="11:00">11:00</option>
            <option value="12:00">12:00</option>
            <option value="13:00">13:00</option>
            <option value="14:00">14:00</option>
            <option value="15:00">15:00</option>
            <option value="16:00">16:00</option>
            <option value="17:00">17:00</option>
            <option value="18:00">18:00</option>
        </select>

        <button type="submit">Отправить заявку</button>
    </form>

    <div id="responseMessage"></div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Подключение к базе данных
        $servername = "localhost"; // Замените на ваш сервер
        $username = "username"; // Замените на ваше имя пользователя
        $password = "password"; // Замените на ваш пароль
        $dbname = "database"; // Замените на имя вашей базы данных

        // Создание соединения
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Проверка соединения
        if ($conn->connect_error) {
            die("Ошибка подключения: " . $conn->connect_error);
        }

        // Получение данных из формы
        $master = $_POST['master'];
        $date = $_POST['date'];
        $time = $_POST['time'];

        // SQL-запрос для вставки данных
        $sql = "INSERT INTO bookings (master, date, time) VALUES ('$master', '$date', '$time')";

        if ($conn->query($sql) === TRUE) {
            echo "<div>Заявка отправлена на $date в $time к $master.</div>";
        } else {
            echo "Ошибка: " . $sql . "<br>" . $conn->error;
        }

        // Закрытие соединения
        $conn->close();
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
if ($conn->query($sql) === TRUE) {
    // Если запрос выполнен успешно, перенаправляем на другую страницу
    header("Location: checkform.php");
    exit(); // Не забудьте вызвать exit после header
} else {
    echo "Ошибка: " . $sql . "<br>" . $conn->error;
}
    }
    ?>


</body>
</html>
