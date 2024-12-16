<?php
require 'db.php'; // Включване на връзката към базата данни

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];

    // SQL заявка за актуализация
    $sql = "UPDATE events SET title = ?, description = ?, event_date = ?, event_time = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $title, $description, $event_date, $event_time, $id);

    if ($stmt->execute()) {
        echo "Събитието е актуализирано успешно!";
    } else {
        echo "Грешка при актуализацията: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    // Пренасочване обратно към списъка със събития
    header("Location: view_events.php");
    exit;
}
?>
