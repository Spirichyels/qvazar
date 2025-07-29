<?php
require __DIR__.'/DB/config.php';

function getBooks($pdo, $availableOnly = false) {
    $sql = "SELECT * FROM books";
    if ($availableOnly) {
        $sql .= " WHERE is_available = 1";
    }
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

function getActiveReservations($pdo) {
    $sql = "SELECT r.*, b.title 
            FROM reservations r 
            JOIN books b ON r.book_id = b.id 
            WHERE r.status = 'active'";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}
function addUserBd($pdo, $userName, $email) {
    $pdo->beginTransaction();
	
	try {
		$id = 5;
		$stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (?,?)");
		$stmt->execute([$userName, $email]);
		$pdo->commit();
		return true;

	} catch(Exception $e) {
		$pdo->rollBack();
        return $e->getMessage();
	}

	
		 
	 


}

function addBookBd($pdo, $title, $author, $year_published, $isbn ){
	$pdo->beginTransaction();
	
	try {
		$id = 5;
		$stmt = $pdo->prepare("INSERT INTO books (title, author,year_published,isbn) VALUES (?,?,?,?)");
		$stmt->execute([$title, $author, $year_published, $isbn]);
		$pdo->commit();
		return true;

	} catch(Exception $e) {
		$pdo->rollBack();
		return $e->getMessage();
	}
}
function reserveBook($pdo, $bookId, $userName, $email, $returnDate) {
    $pdo->beginTransaction();
    
    try {
        // Проверяем доступность книги
        $stmt = $pdo->prepare("SELECT is_available FROM books WHERE id = ? FOR UPDATE");
        $stmt->execute([$bookId]);
        $book = $stmt->fetch();
        
        if (!$book || !$book['is_available']) {
            throw new Exception("Книга недоступна для бронирования");
        }
        
        // Создаем бронирование
        $stmt = $pdo->prepare("INSERT INTO reservations 
                              (book_id, user_name, email, return_date) 
                              VALUES (?, ?, ?, ?)");
        $stmt->execute([$bookId, $userName, $email, $returnDate]);
        
        // Обновляем статус книги
        $stmt = $pdo->prepare("UPDATE books SET is_available = 0 WHERE id = ?");
        $stmt->execute([$bookId]);
        
        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        return $e->getMessage();
    }
}



function returnBook($pdo, $reservationId) {
    $pdo->beginTransaction();
    
    try {
        // Получаем информацию о бронировании
        $stmt = $pdo->prepare("SELECT book_id FROM reservations WHERE id = ?");
        $stmt->execute([$reservationId]);
        $reservation = $stmt->fetch();
        
        if (!$reservation) {
            throw new Exception("Бронирование не найдено");
        }
        
        // Помечаем бронирование как завершенное
        $stmt = $pdo->prepare("UPDATE reservations SET status = 'completed' WHERE id = ?");
        $stmt->execute([$reservationId]);
        
        // Обновляем статус книги
        $stmt = $pdo->prepare("UPDATE books SET is_available = 1 WHERE id = ?");
        $stmt->execute([$reservation['book_id']]);
        
        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        return $e->getMessage();
    }
}


function deleteUser($pdo, $id) {
    $pdo->beginTransaction();
    
    try {
        // Получаем информацию о бронированииDELETE FROM users WHERE id = 17
		//"UPDATE id FROM users WHERE id = ?"
		//SELECT * FROM `books` WHERE id =  1
        $stmt = $pdo->prepare("SELECT id FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $find = $stmt->fetch();
        
        if (!$find) {
            throw new Exception("ПОльзователь не найден");
        }
		else {
			$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
			$stmt->execute([$id]);
			//$pdo->commit();
		}
        
        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        return $e->getMessage();
    }
}

function deleteBook($pdo, $id) {
    $pdo->beginTransaction();
    
    try {
        // Получаем информацию о бронированииDELETE FROM users WHERE id = 17
		//"UPDATE id FROM users WHERE id = ?"
		//SELECT * FROM `books` WHERE id =  1
        $stmt = $pdo->prepare("SELECT id FROM books WHERE id = ?");
        $stmt->execute([$id]);
        $find = $stmt->fetch();
        
        if (!$find) {
            throw new Exception("Книга не найдена");
        }
		else {
			$stmt = $pdo->prepare("DELETE FROM books WHERE id = ?");
			$stmt->execute([$id]);
			//$pdo->commit();
		}
        
        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        return $e->getMessage();
    }
}


function getUsers($pdo, $availableOnly = false) {
    $sql = "SELECT * FROM users";
    if ($availableOnly) {
        $sql .= " WHERE is_available = 1";
    }
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}
?>