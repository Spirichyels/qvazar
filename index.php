<!DOCTYPE html>
<html>
<body>
    <form method="POST">
        <label>Название книги:</label>
        <input type="text" name="title" required>
        
        <label>Автор:</label>
        <input type="text" name="author" required>
        
        <button type="submit">Добавить</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $author = $_POST['author'];
        
        echo "<p>Добавлена книга: $title ($author)</p>";
    }
    ?>

<?php
$host = 'localhost';
$db   = 'library_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// Подключение к БД
try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=$charset", 
        $user, 
        $pass
    );
    echo "<p>Успешное подключение к БД!</p>";
} catch (PDOException $e) {
    die("<p>Ошибка подключения: " . $e->getMessage() . "</p>");
}

// Пример запроса
$stmt = $pdo->query("SELECT * FROM books");
while ($row = $stmt->fetch()) {
    echo "<p>{$row['title']} - {$row['author']}</p>";
}
?>
</body>
</html>