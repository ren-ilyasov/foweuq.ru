<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="rip.css">
    <!-- Подключение CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
     
    <title>Записываемся на ноготочки (Вход)</title>
</head>
<body>

<header>
    <h1>Записываемся на ноготочки</h1>
</header>
<br>
<h2> Войти
</h2>
<br>
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = new mysqli('localhost', 'root', '', 'violations_system');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $hashed_password);

    if ($stmt->fetch() && password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $user_id;
        echo "Авторизация успешна!";
        // Можно переадресовать пользователя на другую страницу, например на главную
        header("Location: main.php");
        exit();
    } else {
        echo "Неверный логин или пароль.";
    }

    $stmt->close();
    $conn->close();
}
?>

<form method="POST" action="login.php">
    <input type="text" name="username" placeholder="Логин" required><br>
    <input type="password" name="password" placeholder="Пароль" required><br>
    <input type="submit" value="Войти">
</form>
<br><br>
<nav>
<a href="register.php">Нет аккаунта? Зарегистрироваться</a>
</nav>

</body>
</html>