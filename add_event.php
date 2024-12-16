<?php
require 'db.php'; // Свързване с базата данни

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];

    // Проверка за празни полета
    if (empty($title) || empty($event_date) || empty($event_time)) {
        echo "Всички задължителни полета трябва да бъдат попълнени!";
    } else {
        // Вмъкване в базата данни
        $sql = "INSERT INTO events (title, description, event_date, event_time) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $title, $description, $event_date, $event_time);

        if ($stmt->execute()) {
            echo "Събитието е добавено успешно!";
        } else {
            echo "Грешка: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Добавяне на събитие</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Добавяне на събитие</h1>
        <form action="add_event.php" method="POST">
            <label for="title">Заглавие:</label><br>
            <input type="text" id="title" name="title" required><br><br>

            <label for="description">Описание:</label><br>
            <textarea id="description" name="description"></textarea><br><br>

            <label for="event_date">Дата:</label><br>
            <input type="date" id="event_date" name="event_date" required><br><br>

            <label for="event_time">Час:</label><br>
            <input type="time" id="event_time" name="event_time" required><br><br>

            <button type="submit">Добави събитие</button>
        </form>
        <form action="view_events.php" method="GET" style="margin-top: 20px;">
    <button type="submit" class="btn-back">Назад към списъка</button>
</form>
    </div>
</body>
</html>
