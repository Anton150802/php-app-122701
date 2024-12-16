<?php
require 'db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // SQL заявка за извличане на данни
    $sql = "SELECT * FROM events WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $event = $result->fetch_assoc();
    } else {
        echo "Събитието не е намерено.";
        exit;
    }

    $stmt->close();
} else {
    echo "Невалиден ID.";
    exit;
}
?>

<form id="edit-form" method="POST">
    <input type="hidden" name="id" value="<?php echo $event['id']; ?>">

    <label for="title">Заглавие:</label><br>
    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($event['title']); ?>" required><br><br>

    <label for="description">Описание:</label><br>
    <textarea id="description" name="description"><?php echo htmlspecialchars($event['description']); ?></textarea><br><br>

    <label for="event_date">Дата:</label><br>
    <input type="date" id="event_date" name="event_date" value="<?php echo $event['event_date']; ?>" required><br><br>

    <label for="event_time">Час:</label><br>
    <input type="time" id="event_time" name="event_time" value="<?php echo $event['event_time']; ?>" required><br><br>

    <button type="button" id="save-changes">Запази промените</button>
</form>
