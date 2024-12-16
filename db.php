<?php
// Настройки за връзка с базата данни
$host = 'localhost'; // Или IP адрес на сървъра за базата
$username = 'root'; // Потребителско име (по подразбиране в XAMPP е root)
$password = ''; // Парола (по подразбиране в XAMPP е празно)
$dbname = 'event_manager'; // Името на базата данни

// Създаване на връзка
$conn = new mysqli($host, $username, $password, $dbname);

// Проверка за грешки при свързването
if ($conn->connect_error) {
    die("Грешка при свързване с базата данни: " . $conn->connect_error);
}


// Задаване на кодировка
$conn->set_charset("utf8");
?>
