<?php
require 'db.php'; // Включване на връзката към базата данни

// Логика за филтриране
$filter = '';
$whereClauses = [];

// Проверка за филтър по заглавие
if (isset($_GET['filter']) && !empty($_GET['filter']) && $_GET['filter'] != "past") {
    $filter = $_GET['filter'];
    $whereClauses[] = "title LIKE '%" . $conn->real_escape_string($filter) . "%'";
}

// Проверка за бъдещи събития
if (isset($_GET['future']) && $_GET['future'] == '1') {
    $whereClauses[] = "event_date >= CURDATE()";
}

// Проверка за изминали събития
if (isset($_GET['filter']) && $_GET['filter'] == "past") {
    $whereClauses[] = "event_date < CURDATE()";
}

// Съставяне на WHERE клаузата
$whereSQL = '';
if (count($whereClauses) > 0) {
    $whereSQL = "WHERE " . implode(" AND ", $whereClauses);
}

// Изпълнение на SQL заявката
$sql = "SELECT * FROM events $whereSQL ORDER BY event_date ASC, event_time ASC";
$result = $conn->query($sql);

if (!$result) {
    die("Грешка при изпълнение на заявката: " . $conn->error);
} else {
    echo "Намерени резултати: " . $result->num_rows . "<br>";
}
?>


<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Преглед на събития</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<!-- Модален прозорец -->
<div id="edit-modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div id="modal-body">
            <!-- Формата за редакция ще бъде заредена тук -->
        </div>
    </div>
</div>
    <!-- Заглавие на страницата -->
    <h1>Списък със събития</h1>
    <a href="add_event.php" class="btn">Добави ново събитие</a>
    <!-- Форма за филтриране -->
<form id="filter-form" method="GET" action="view_events.php">
    <label for="filter">Филтрирай по заглавие:</label>
    <input type="text" id="filter" name="filter" value="">
    <button type="submit">Търси</button>
</form>

<form method="GET" action="view_events.php" style="margin-top: 10px;">
    <button type="submit" name="future" value="1">Покажи само бъдещи събития</button>
</form>
<form method="GET" action="view_events.php" style="display:inline;">
    <button type="submit" name="filter" value="past" class="btn-filter">Покажи изминали събития</button>
</form>
<form method="GET" action="view_events.php" style="display:inline;">
    <button type="submit" class="btn-filter">Покажи всички събития</button>
</form>

    <?php if ($result->num_rows > 0): ?>
        <table id="events-table" border="1">
            <tr>
                <th>Заглавие</th>
                <th>Описание</th>
                <th>Дата</th>
                <th>Час</th>
                <th>Действия</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo htmlspecialchars($row['event_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['event_time']); ?></td>
                    <td>
    <form action="delete_event.php" method="POST" style="display:inline;">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <button type="button" class="delete-ajax" data-id="<?php echo $row['id']; ?>">Изтрий</button>
    </form>
    <form action="edit_event.php" method="GET" style="display:inline;">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <button type="button" class="edit-ajax" data-id="<?php echo $row['id']; ?>">Редактирай</button>
    </form>

</td>

                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Няма добавени събития.</p>
    <?php endif; ?>

    <?php
    // Затваряне на връзката с базата данни
    $conn->close();
    ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="ajax.js"></script> 
</body>
</html>
