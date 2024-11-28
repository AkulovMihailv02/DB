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
        die("Таавар с ID $id_prod не найден.");
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
    <title>Детали товара</title>
    <link rel="stylesheet" href="CSS/detail.css">
</head>
<body>

<h2>Детальная информация о товаре</h2>

<div class="detail-container">
    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
    <p><?php echo nl2br(htmlspecialchars($product['des'])); ?></p>
    <p class="price"><?php echo number_format($product['prc'], 2, ',', ' ') . ' ₽'; ?></p>

    <form action="purchase.php" method="POST">
        <input type="hidden" name="id_prod" value="<?php echo $product['id_prod']; ?>">
        <input type="hidden" name="price" value="<?php echo $product['prc']; ?>">
        <button type="submit" class="btn">Купить</button>
    </form>
</div>

</body>
</html>
