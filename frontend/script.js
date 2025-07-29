let processPATH = "./../backend/process.php";
let functionPATH = "./../backend/function.php";

document.addEventListener("DOMContentLoaded", function () {
  // Показать модальное окно бронирования
  window.showReserveForm = function (bookId) {
    document.getElementById("book-id").value = bookId;
    document.getElementById("reservation-modal").style.display = "flex";

    // Установить дату возврата (по умолчанию +14 дней)
    const today = new Date();
    const returnDate = new Date(today);
    returnDate.setDate(today.getDate() + 14);

    document.getElementById("return-date").valueAsDate = returnDate;
    document.getElementById("return-date").min = new Date()
      .toISOString()
      .split("T")[0];
  };

  // Закрыть модальное окно
  window.closeModalReservation = function () {
    document.getElementById("reservation-modal").style.display = "none";
  };

  // Обработка формы бронирования
  document
    .getElementById("reservation-form")
    .addEventListener("submit", function (e) {
      e.preventDefault();

      const bookId = document.getElementById("book-id").value;
      const userName = document.getElementById("user-name").value;
      const email = document.getElementById("email").value;
      const returnDate = document.getElementById("return-date").value;

      reserveBook(bookId, userName, email, returnDate);
    });

  // Функция бронирования книги
  window.reserveBook = function (bookId, userName, email, returnDate) {
    fetch(processPATH, {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({
        action: "reserve",
        book_id: bookId,
        user_name: userName,
        email: email,
        return_date: returnDate,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert("Книга успешно забронирована!");
          location.reload();
        } else {
          alert("Ошибка: " + data.message);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("Произошла ошибка при бронировании");
      });
  };

  // Функция возврата книги
  window.returnBook = function (reservationId) {
    if (!confirm("Вы уверены, что хотите вернуть книгу?")) {
      return;
    }

    fetch(processPATH, {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({
        action: "return",
        reservation_id: reservationId,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert("Книга успешно возвращена!");
          location.reload();
        } else {
          alert("Ошибка: " + data.message);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("Произошла ошибка при возврате книги");
      });
  };

  // Закрытие модального окна при клике вне его
  window.addEventListener("click", function (event) {
    const modal = document.getElementById("reservation-modal");
    if (event.target === modal) {
      closeModal();
    }
  });

  //////////////////

  // Показать модальное окно бронирования
  window.showAddUserForm = function () {
    document.getElementById("add-user-modal").style.display = "flex";
    console.log("close");
  };
  // Закрыть модальное окно
  window.closeModal = function () {
    document.getElementById("add-user-modal").style.display = "none";
  };

  window.showAddBookForm = function () {
    document.getElementById("add-book-modal").style.display = "flex";
    console.log("close");
  };

  window.closeModalAddBook = function () {
    document.getElementById("add-book-modal").style.display = "none";
  };
});

document.addEventListener("DOMContentLoaded", function () {
  // Обработка формы нового пользователя
  document
    .getElementById("add-user-form")
    .addEventListener("submit", function (e) {
      e.preventDefault();

      const userName = document.getElementById("input-user-name").value;
      const email = document.getElementById("input-user-email").value;

      addUserBd(userName, email);
    });

  // обработка формы новой книги
  document
    .getElementById("add-book-form")
    .addEventListener("submit", function (e) {
      e.preventDefault();

      const title = document.getElementById("input-book-title").value;
      const author = document.getElementById("input-book-author").value;
      const year_published = document.getElementById("input-book-year").value;
      const isbn = document.getElementById("input-book-isbn").value;
      addBookBd(title, author, year_published, isbn);
    });

  // Функция добавления пользователя
  window.addUserBd = function (userName, email) {
    fetch(processPATH, {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({
        action: "addUser",
        name: userName,
        email: email,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert("Пользователь успешно добавлен");
          location.reload();
        } else {
          alert("Ошибка: " + data.message);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("Произошла ошибка при добавлении нового пользователя");
      });
  };

  window.addBookBd = function (title, author, year_published, isbn) {
    fetch(processPATH, {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({
        action: "addBook",
        title: title,
        author: author,
        year_published: year_published,
        isbn: isbn,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert("Книга успешно добавлна");
          location.reload();
        } else {
          alert("Ошибка: " + data.message);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("Произошла ошибка при добавлении книги");
      });
  };

  // Закрытие модального окна при клике вне его
  window.addEventListener("click", function (event) {
    const modal = document.getElementById("add-user-modal");
    if (event.target === modal) {
      closeModal();
    }
  });

  window.addEventListener("click", function (event) {
    const modal = document.getElementById("add-book-modal");
    if (event.target === modal) {
      closeModal();
    }
  });

  // Функция удаления пользователя
  window.delUser = function (id) {
    if (!confirm("Вы уверены, что хотите удалить пользователя?")) {
      return;
    }

    fetch(processPATH, {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({
        action: "deleteUser",
        id: id,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert("Пользователь успешно удален!");
          location.reload();
        } else {
          alert("Ошибка: " + data.message);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("Произошла ошибка при удаления пользователя");
      });
  };

  // Функция удаления пользователя
  window.delBook = function (id) {
    if (!confirm("Вы уверены, что хотите удалить книгу?")) {
      return;
    }

    fetch(processPATH, {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({
        action: "deleteBook",
        id: id,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert("Книга успешно удалена!");
          location.reload();
        } else {
          alert("Ошибка: " + data.message);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("Произошла ошибка при удаления пользователя");
      });
  };
});
