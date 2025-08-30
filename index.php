<?php
require __DIR__.'/backend/functions.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Система бронирования книг</title>
    <link rel="stylesheet" href="./frontend/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Библиотечная система бронирования</h1>
        </header>
        
        <main>
            <section class="books-section">

                <h2>Доступные книги</h2>
				<div >
					<button id="add-user-btn" class="add-book-btn" onclick="showAddBookForm()">
					<span>+</span> Добавить книгу
				</button>
				</div>
				
				
                <div id="books-list" class="books-grid">
					
                    <?php 
                    $books = getBooks($pdo, true);
                    foreach ($books as $book): 
                    ?>
                    <div class="book-card" data-id="<?= $book['id'] ?>">
					<div><span class="del-user" onclick="delBook(<?= $book['id'] ?>)">&times;</span></div>
                        <h3><?= htmlspecialchars($book['title']) ?></h3>
                        <p>Автор: <?= htmlspecialchars($book['author']) ?></p>
                        <p>Год: <?= $book['year_published'] ?></p>
                        <p>ISBN: <?= $book['isbn'] ?></p>
                        <button class="reserve-btn" onclick="showReserveForm(<?= $book['id'] ?>)">Забронировать</button>
                    </div>
                    <?php endforeach; ?>
                </div>
				
            </section>

			<section class="users-section">
                <h2>Читатели библиотеки</h2>
				<button id="add-user-btn" class="add-user-btn" onclick="showAddUserForm()">
					<span>+</span> Добавить читателя
				</button>
                <div id="users-list" class="users-grid">
                    <?php 
                    $users = getUsers($pdo, true);
                    foreach ($users as $user): 
                    ?>
                    <div class="users-card" data-id="<?= $user['id'] ?>">
						<div><span class="del-user" onclick="delUser(<?= $user['id'] ?>)">&times;</span></div>
                        <h3><?= htmlspecialchars($user['name']) ?></h3>
                        <p>email: <?= htmlspecialchars($user['email']) ?>
						
						<!-- <span class="close" onclick="">&times;</span>   -->
					</p>
						
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
                <span class="close" onclick="closeModalReservation()">&times;</span>
                <h2>Бронирование книги</h2>

				
                <form id="reservation-form">
				<?php 
                    $books = getBooks($pdo, true);
                    foreach ($books as $book): 
                    ?>
					<?php endforeach; ?>
			
                    <div class="form-group">
                        <label for="return-date">Вернуть до:</label>
                        <input type="date" id="return-date" name="return_date" required>
                    </div>
                    <button type="submit" class="btn">Подтвердить бронирование</button>
                </form>
            </div>
        </div>

		<div id="add-user-modal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2>Новый пользователь</h2>
                <form id="add-user-form">
                    <input type="hidden" id="book-id" name="book_id">
                    <div class="form-group">
                        <label for="input-user-name">Ваше имя:</label>
                        <input type="text" id="input-user-name" name="input-user_name" required>
                    </div>
                    <div class="form-group">
                        <label for="input-user-email">Email:</label>
                        <input type="email" id="input-user-email" name="input-user-email" required>
                    </div>
                    <button type="submit" class="btn">Сохранить пользователя</button>
                </form>
            </div>
        </div>

		<div id="add-book-modal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModalAddBook()">&times;</span>
                <h2>Новая книга</h2>
                <form id="add-book-form">
                    <input type="hidden" id="book-id" name="book_id">
					<div class="form-group">
                        <label for="input-book-title">Название книги:</label>
                        <input type="text" id="input-book-title" name="input-title" required>
                    </div>
                    <div class="form-group">
                        <label for="input-book-author">Автор книги:</label>
                        <input type="text" id="input-book-author" name="input-author" required>
                    </div>
                    <div class="form-group">
                        <label for="input-book-year">Год:</label>
                        <input type="year" id="input-book-year" name="input-book-year" required>
                    </div>
					<div class="form-group">
                        <label for="input-book-isbn">ISBN:</label>
                        <input type="ISBN" id="input-book-isbn" name="input-book-isbn" required>
                    </div>
                    <button type="submit" class="btn">Сохранить книгу</button>
                </form>
            </div>
        </div>
        
        <footer>
            <p>Система бронирования книг &copy; <?= date('Y') ?></p>
        </footer>
    </div>
    
    <script src= "./frontend/script.js"></script>
</body>
</html>