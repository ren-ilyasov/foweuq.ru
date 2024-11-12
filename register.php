<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="rip.css">
    <!-- Подключение CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
     
    <title>Ноготочки(Регистрация)</title>
</head>
<body>
<main>
<header>
    <h1>Ноготочки чтобы сделать, нужно пройти регистрацию...</h1>
</header>
<br>
 <h2>Зарегестрируйся, чтобы начать!</h2>

    <?php
    // Включить отображение ошибок
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $fullname = $_POST['fullname'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $conn = new mysqli('localhost', 'root', '', 'violations_system');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO users (fullname, phone, email, username, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $fullname, $phone, $email, $username, $password);

        if ($stmt->execute()) {
            echo "Регистрация успешна!";
        } else {
            echo "Ошибка: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</main>
    <form method="POST" action="">
        <input type="text" name="fullname" placeholder="ФИО" required><br>
        <input type="text" name="phone" placeholder="Телефон"><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="text" name="username" placeholder="Логин" required><br>
        <input type="password" name="password" placeholder="Пароль" required><br>
        <input type="submit" value="Зарегистрироваться">
    </form>


</body>
</html>

