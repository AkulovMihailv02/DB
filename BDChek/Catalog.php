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

$stmt = $pdo->query("SELECT * FROM prod");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог товаров</title>
    <link rel="stylesheet" href="CSS/cat.css">
</head>
<body>

<h2>Каалог товаров</h2>
<a href="add.php" class="a">Дабавить товар</a>
<div class="catalog-container">
    <?php
    if (count($products) > 0) {
        foreach ($products as $product) {
            echo '<div class="product">';
            echo '<h3>' . htmlspecialchars($product['name']) . '</h3>';
            echo '<p class="price">' . number_format($product['prc'], 2, ',', ' ') . ' ₽</p>';
            echo '<a href="detail.php?id_prod=' . $product['id_prod'] . '" class="a">Купить</a>';
            echo '<a href="edit.php?id_prod=' . $product['id_prod'] . '" class="a">Изменить</a>';
            echo '<a href="del.php?id_prod=' . $product['id_prod'] . '" class="a" onclick="return confirm(\'Вы уверены, что хотите удалить этот товар?\');">Удалить</a>';
            echo '</div>';
        }
    } else {
        echo '<p>Нет товаров для отображения.</p>';
    }
    ?>
</div>


</body>
</html>
