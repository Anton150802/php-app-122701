<?php
require 'db.php';

$filter = isset($_GET['filter']) ? $_GET['filter'] : '';

$whereSQL = '';
if (!empty($filter)) {
    $whereSQL = "WHERE title LIKE '%" . $conn->real_escape_string($filter) . "%'";
}

$sql = "SELECT * FROM events $whereSQL ORDER BY event_date ASC, event_time ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>" . htmlspecialchars($row['title']) . "</td>
            <td>" . htmlspecialchars($row['description']) . "</td>
            <td>" . htmlspecialchars($row['event_date']) . "</td>
            <td>" . htmlspecialchars($row['event_time']) . "</td>
            <td>
                <button type='button' class='delete-ajax' data-id='" . $row['id'] . "'>Изтрий</button>
            </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='5'>Няма събития.</td></tr>";
}

$conn->close();
?>
