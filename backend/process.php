<?php
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    if (isset($_POST['action'])) {
        try {
            switch ($_POST['action']) {
				case 'addUser':
                    if ( empty($_POST['name']) || empty($_POST['email']) ) {
                        throw new Exception("Все поля обязательны для заполнения");
                    }
                    
                    $result = addUserBd(
                        $pdo, 
                        $_POST['name'],
                        $_POST['email']
                    );
                    
                    if ($result === true) {
                        echo json_encode(['success' => true]);
                    } else {
                        throw new Exception($result);
                    }
                    break;
					case 'addBook':
						if ( empty($_POST['title']) || empty($_POST['author'])
						|| empty($_POST['year_published']) || empty($_POST['isbn']) ) {
							throw new Exception("Все поля обязательны для заполнения");
						}
						
						$result = addBookBd(
							$pdo, 
							$_POST['title'],
							$_POST['author'],
							$_POST['year_published'],
							$_POST['isbn'],

						);
						
						if ($result === true) {
							echo json_encode(['success' => true]);
						} else {
							throw new Exception($result);
						}
						break;
                case 'reserve':
                    if (empty($_POST['book_id']) || empty($_POST['user_name']) || 
                        empty($_POST['email']) || empty($_POST['return_date'])) {
                        throw new Exception("Все поля обязательны для заполнения");
                    }
                    
                    $result = reserveBook(
                        $pdo, 
                        $_POST['book_id'],
                        $_POST['user_name'],
                        $_POST['email'],
                        $_POST['return_date']
                    );
                    
                    if ($result === true) {
                        echo json_encode(['success' => true]);
                    } else {
                        throw new Exception($result);
                    }
                    break;
                    
                case 'return':
                    if (empty($_POST['reservation_id'])) {
                        throw new Exception("ID бронирования не указан");
                    }
                    
                    $result = returnBook($pdo, $_POST['reservation_id']);
                    
                    if ($result === true) {
                        echo json_encode(['success' => true]);
                    } else {
                        throw new Exception($result);
                    }
                    break;
				case 'deleteUser':
						if (empty($_POST['id'])) {
							throw new Exception("ID пользователя не указан");
						}
						
						$result = deleteUser($pdo, $_POST['id']);
						
						if ($result === true) {
							echo json_encode(['success' => true]);
						} else {
							throw new Exception($result);
						}
						break;
				case 'deleteBook':
							if (empty($_POST['id'])) {
								throw new Exception("ID пользователя не указан");
							}
							
							$result = deleteBook($pdo, $_POST['id']);
							
							if ($result === true) {
								echo json_encode(['success' => true]);
							} else {
								throw new Exception($result);
							}
							break;
                default:
                    throw new Exception("Неизвестное действие");
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Действие не указано'
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Метод не поддерживается'
    ]);
}
?>