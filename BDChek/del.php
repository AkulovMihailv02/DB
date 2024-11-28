<?php
$host = '127.0.0.1';  
$dbname = 'user_system';  
$username_db = 'root';  
$password_db = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username_db, $password_db);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}

if (isset($_GET['id_prod']) && is_numeric($_GET['id_prod'])) {
    $id_prod = $_GET['id_prod'];

    $stmt = $pdo->prepare("DELETE FROM prod WHERE id_prod = :id_prod");
    $stmt->execute(['id_prod' => $id_prod]);

    header('Location: Catalog.php');
    exit();
} else {
    die("Некорректный запрос.");
}
?>
