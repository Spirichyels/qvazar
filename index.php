<?php
require 'functions.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Система бронирования книг</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Библиотечная система бронирования</h1>
        </header>
        
        <main>
            <section class="books-section">
                <h2>Доступные книги</h2>
                <div id="books-list" class="books-grid">
                    <?php 
                    $books = getBooks($pdo, true);
                    foreach ($books as $book): 
                    ?>
                    <div class="book-card" data-id="<?= $book['id'] ?>">
                        <h3><?= htmlspecialchars($book['title']) ?></h3>
                        <p>Автор: <?= htmlspecialchars($book['author']) ?></p>
                        <p>Год: <?= $book['year_published'] ?></p>
                        <p>ISBN: <?= $book['isbn'] ?></p>
                        <button class="reserve-btn" onclick="showReserveForm(<?= $book['id'] ?>)">Забронировать</button>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
            
            <section class="reservations-section">
                <h2>Активные бронирования</h2>
                <table id="reservations-table">
                    <thead>
                        <tr>
                            <th>Книга</th>
                            <th>Читатель</th>
                            <th>Email</th>
                            <th>Дата бронирования</th>
                            <th>Возврат до</th>
                            <th>Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $reservations = getActiveReservations($pdo);
                        foreach ($reservations as $res): 
                        ?>
                        <tr data-id="<?= $res['id'] ?>">
                            <td><?= htmlspecialchars($res['title']) ?></td>
                            <td><?= htmlspecialchars($res['user_name']) ?></td>
                            <td><?= htmlspecialchars($res['email']) ?></td>
                            <td><?= date('d.m.Y', strtotime($res['reservation_date'])) ?></td>
                            <td><?= date('d.m.Y', strtotime($res['return_date'])) ?></td>
                            <td><button class="return-btn" onclick="returnBook(<?= $res['id'] ?>)">Вернуть</button></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </main>
        
        <div id="reservation-modal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2>Бронирование книги</h2>
                <form id="reservation-form">
                    <input type="hidden" id="book-id" name="book_id">
                    <div class="form-group">
                        <label for="user-name">Ваше имя:</label>
                        <input type="text" id="user-name" name="user_name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="return-date">Вернуть до:</label>
                        <input type="date" id="return-date" name="return_date" required>
                    </div>
                    <button type="submit" class="btn">Подтвердить бронирование</button>
                </form>
            </div>
        </div>
        
        <footer>
            <p>Система бронирования книг &copy; <?= date('Y') ?></p>
        </footer>
    </div>
    
    <script src="script.js"></script>
</body>
</html>