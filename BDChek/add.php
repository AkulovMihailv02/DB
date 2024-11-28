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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $des = $_POST['des'];
    $prc = $_POST['prc'];

    if (!empty($name) && !empty($des) && !empty($prc)) {
        $stmt = $pdo->prepare("INSERT INTO prod (name, des, prc) VALUES (:name, :des, :prc)");
        $stmt->execute([
            'name' => $name,
            'des' => $des,
            'prc' => $prc
        ]);

        header('Location: Catalog.php');
        exit();
    } else {
        $error_message = 'Все поля должны быть заполнены!';
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить товар</title>
    <link rel="stylesheet" href="CSS/add.css">
</head>
<body>

<h2>Добавить новый товар</h2>

<?php
if (isset($error_message)) {
    echo '<p style="color: red;">' . htmlspecialchars($error_message) . '</p>';
}
?>

<form action="add.php" method="POST">
    <label for="name">Наименование:</label><br>
    <input type="text" id="name" name="name" required><br><br>

    <label for="des">Описание:</label><br>
    <textarea id="des" name="des" rows="5" required></textarea><br><br>

    <label for="prc">Цена:</label><br>
    <input type="number" id="prc" name="prc" step="0.01" required><br><br>

    <button type="submit">Добавить товар</button>
</form>

<a href="Catalog.php">Назад к каталогу</a>

</body>
</html>
