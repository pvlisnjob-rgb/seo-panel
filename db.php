<?php
$host = 'localhost';       // Обычно localhost, но проверьте в панели хостинга
$dbname = 'seopl';  // Впишите имя созданной базы
$username = 'seopl'; // Впишите пользователя БД
$password = 'Roma1234';      // Впишите пароль БД

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Ошибка подключения к БД: " . $e->getMessage());
}
?>