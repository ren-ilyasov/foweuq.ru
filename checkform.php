

<?php
session_start();
include 'db_connection.php'; // файл для подключения к базе данных

// Проверка авторизации пользователя
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Получение заявок пользователя из базы данных
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM applications WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$applications = $result->fetch_all(MYSQLI_ASSOC);

// Обработка новой заявки
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $master = $_POST['master'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    
    $insertQuery = "INSERT INTO applications (user_id, master, date, time, status) VALUES (?, ?, ?, ?, 'новое')";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("isss", $user_id, $master, $date, $time);
    $insertStmt->execute();
    
    header("Location: applications.php");
    exit();
}

// Получение списка мастеров
$mastersQuery = "SELECT * FROM masters";
$mastersResult = $conn->query($mastersQuery);
$masters = $mastersResult->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="rip.css">
    <!-- Подключение CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Мои заявки</title>
</head>
<body>
    <h1>Мои заявки</h1>
    
    <table outline="1">
        <tr>
            <th>ФИО мастера</th>
            <th>Дата</th>
            <th>Время</th>
            <th>Статус</th>
        </tr>
        <?php foreach ($applications as $application): ?>
            <tr>
                <td><?php echo htmlspecialchars($application['master']); ?></td>
                <td><?php echo htmlspecialchars($application['date']); ?></td>
                <td><?php echo htmlspecialchars($application['time']); ?></td>
                <td><?php echo htmlspecialchars($application['status']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Новая заявка</h2>
    <form method="POST">
        <label for="master">Выберите мастера:</label>
        <select name="master" id="master" required>
            <?php foreach ($masters as $master): ?>
                <option value="<?php echo htmlspecialchars($master['name']); ?>"><?php echo htmlspecialchars($master['name']); ?></option>
            <?php endforeach; ?>
        </select>
        
        <br>
        
        <label for="date">Дата:</label>
        <input type="date" name="date" required>
        
        <br>
        
        <label for="time">Время:</label>
        <input type="time" name="time" min="08:00" max="18:00" required>
        
        <br>
        
        <input type="submit" value="Подать заявку">
    </form>

    <a href="logout.php">Выйти</a>
</body>
</html>

<?php
// Закрытие соединения с базой данных
$conn->close();
?>
