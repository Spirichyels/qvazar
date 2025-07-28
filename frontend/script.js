let processPATH = "./../backend/process.php";
let functionPATH = "./../backend/function.php";

// document.addEventListener("DOMContentLoaded", function () {
//   // Показать модальное окно бронирования
//   window.showReserveForm = function (bookId) {
//     document.getElementById("book-id").value = bookId;
//     document.getElementById("reservation-modal").style.display = "flex";

//     // Установить дату возврата (по умолчанию +14 дней)
//     const today = new Date();
//     const returnDate = new Date(today);
//     returnDate.setDate(today.getDate() + 14);

//     document.getElementById("return-date").valueAsDate = returnDate;
//     document.getElementById("return-date").min = new Date()
//       .toISOString()
//       .split("T")[0];
//   };

//   // Закрыть модальное окно
//   window.closeModal = function () {
//     document.getElementById("reservation-modal").style.display = "none";
//   };

//   // Обработка формы бронирования
//   document
//     .getElementById("reservation-form")
//     .addEventListener("submit", function (e) {
//       e.preventDefault();

//       const bookId = document.getElementById("book-id").value;
//       const userName = document.getElementById("user-name").value;
//       const email = document.getElementById("email").value;
//       const returnDate = document.getElementById("return-date").value;

//       reserveBook(bookId, userName, email, returnDate);
//     });

//   // Функция бронирования книги
//   window.reserveBook = function (bookId, userName, email, returnDate) {
//     fetch(processPATH, {
//       method: "POST",
//       headers: {
//         "Content-Type": "application/x-www-form-urlencoded",
//       },
//       body: new URLSearchParams({
//         action: "reserve",
//         book_id: bookId,
//         user_name: userName,
//         email: email,
//         return_date: returnDate,
//       }),
//     })
//       .then((response) => response.json())
//       .then((data) => {
//         if (data.success) {
//           alert("Книга успешно забронирована!");
//           location.reload();
//         } else {
//           alert("Ошибка: " + data.message);
//         }
//       })
//       .catch((error) => {
//         console.error("Error:", error);
//         alert("Произошла ошибка при бронировании");
//       });
//   };

//   // Функция возврата книги
//   window.returnBook = function (reservationId) {
//     if (!confirm("Вы уверены, что хотите вернуть книгу?")) {
//       return;
//     }

//     fetch(processPATH, {
//       method: "POST",
//       headers: {
//         "Content-Type": "application/x-www-form-urlencoded",
//       },
//       body: new URLSearchParams({
//         action: "return",
//         reservation_id: reservationId,
//       }),
//     })
//       .then((response) => response.json())
//       .then((data) => {
//         if (data.success) {
//           alert("Книга успешно возвращена!");
//           location.reload();
//         } else {
//           alert("Ошибка: " + data.message);
//         }
//       })
//       .catch((error) => {
//         console.error("Error:", error);
//         alert("Произошла ошибка при возврате книги");
//       });
//   };

//   // Закрытие модального окна при клике вне его
//   window.addEventListener("click", function (event) {
//     const modal = document.getElementById("reservation-modal");
//     if (event.target === modal) {
//       closeModal();
//     }
//   });

//   // Обработка формы Добавление нового пользователя
//   document
//     .getElementById("add-user-form")
//     .addEventListener("submit", function (e) {
//       e.preventDefault();

//       const userId = document.getElementById("user-id").value;
//       const userName = document.getElementById("user-name").value;
//       const email = document.getElementById("email").value;

//       reserveBook(userId, userName, email);
//     });
// });

document.addEventListener("DOMContentLoaded", function () {
  // Показать модальное окно бронирования
  window.showReserveForm = function () {
    document.getElementById("add-user-modal").style.display = "flex";
  };

  // Закрыть модальное окно
  window.closeModal = function () {
    document.getElementById("add-user-modal").style.display = "none";
  };

  // Обработка формы нового пользователя
  document
    .getElementById("add-user-form")
    .addEventListener("submit", function (e) {
      e.preventDefault();

      const userName = document.getElementById("input-user-name").value;
      const email = document.getElementById("input-user-email").value;

      addUserBd(userName, email);
    });

  // Функция бронирования книги
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
    const modal = document.getElementById("add-user-modal");
    if (event.target === modal) {
      closeModal();
    }
  });
});
