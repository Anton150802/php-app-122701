<?php
require 'db.php'; // Включваме връзката с базата данни

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    // SQL заявка за изтриване на събитието
    $sql = "DELETE FROM events WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Събитието е изтрито успешно!";
    } else {
        echo "Грешка при изтриване на събитието: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    // Пренасочване обратно към списъка със събития
    header("Location: view_events.php");
    exit;
}
?>
