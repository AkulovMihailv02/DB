<?php
session_start();

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {

        if ($password === $user['password']) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;
            header('Location: Catalog.php');
            exit();
        } else {
            $error_message = 'Пароль неверный.';
        }
    } else {
        $error_message = 'Пользователь не найден.';
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="CSS/autcss.css">
</head>
<body>

<h2>Авторизация</h2>

<div class="login-container">
    <img src="img/logo.png" alt="Логотип" />

    <?php
    if (isset($error_message)) {
        echo '<p class="error">' . $error_message . '</p>';
    }
    ?>

    <form action="AutoPHP.php" method="POST">
        <label for="username">Логин:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Пароль:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Войти">
    </form>
</div>

</body>
</html>
