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

    $stmt = $pdo->prepare("SELECT * FROM prod WHERE id_prod = :id_prod");
    $stmt->execute(['id_prod' => $id_prod]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        die("Товар с ID $id_prod не найден.");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $des = $_POST['des'];
        $prc = $_POST['prc'];

        $updateStmt = $pdo->prepare("UPDATE prod SET name = :name, des = :des, prc = :prc WHERE id_prod = :id_prod");
        $updateStmt->execute([
            'name' => $name,
            'des' => $des,
            'prc' => $prc,
            'id_prod' => $id_prod
        ]);

        header('Location: Catalog.php');
        exit();
    }
} else {
    die("Некорректный запрос.");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование товара</title>
    <link rel="stylesheet" href="CSS/edit.css">
</head>
<body>

<h2>Редактировать товар</h2>

<form action="" method="POST">
    <label for="name">Наименование:</label><br>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required><br><br>

    <label for="des">Описание:</label><br>
    <textarea id="des" name="des" required><?php echo htmlspecialchars($product['des']); ?></textarea><br><br>

    <label for="prc">Цена:</label><br>
    <input type="number" id="prc" name="prc" value="<?php echo htmlspecialchars($product['prc']); ?>" step="0.01" required><br><br>

    <button type="submit">Сохранить изменения</button>
</form>

</body>
</html>
