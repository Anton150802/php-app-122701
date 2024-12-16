<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']); // Вземи ID от Ajax заявката

    // SQL заявка за изтриване
    $sql = "DELETE FROM events WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "success"; // Върни успех към Ajax
    } else {
        echo "error"; // Върни грешка към Ajax
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>
