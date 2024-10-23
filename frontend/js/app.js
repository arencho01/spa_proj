document.addEventListener('DOMContentLoaded', function () {
   const loginForm = document.getElementById('login-form');
   const registerForm = document.getElementById('register-form');
   const operationForm = document.getElementById('operation-form');

    loginForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const login = loginForm.querySelector('[name="login"]').value;
        const password = loginForm.querySelector('[name="password"]').value;

        fetch('src/auth.php', {
            method: 'POST',
            body: JSON.stringify({action: 'login', login, password}),
            headers: {'Content-Type': 'application/json'}
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // window.location.reload();
                // console.log(data.status);
                console.log(data.status)
            } else {
                // console.log(data.status);
            }
        })

        // let xhr = new XMLHttpRequest();
        // let formData = new FormData();
        //
        // formData.append('username', document.getElementById('username').value);
        // xhr.open('POST', 'src/index.php', false);
        // xhr.onload = function() {
        //     if (xhr.status === 200) {
        //         // Выводим ответ сервера на страницу
        //         console.log('OK');
        //         document.getElementById('result').innerHTML = 'Ответ сервера: ' + xhr.responseText;
        //     } else {
        //         console.error('Ошибка:', xhr.statusText);
        //     }
        // };
        // xhr.send(formData);
    });

});




// function ajax(method, url, data, callback) {
//     const xhr = new XMLHttpRequest();
//     xhr.open(method, url, true);
//     xhr.setRequestHeader('Content-Type', 'application/json');
//     xhr.onreadystatechange = function () {
//         if (xhr.readyState === 4 && xhr.status === 200) {
//             callback(JSON.parse(xhr.responseText));
//         }
//     };
//     xhr.send(JSON.stringify(data));
// }

// function showMainApp() {
//     document.getElementById("auth-form").style.display = "none";
//     document.getElementById("main-app").style.display = "block";
// }

// Отправка AJAX запроса на авторизацию
// function loginUser(username, password) {
//     let xhr = new XMLHttpRequest();
//     xhr.open("POST", "/backend/src/index.php?action=login", true);
//     xhr.setRequestHeader("Content-Type", "application/json");
//
//     xhr.onreadystatechange = function () {
//         if (xhr.readyState === 4 && xhr.status === 200) {
//             let data = JSON.parse(xhr.responseText);
//             if (data.success) {
//                 // showMainApp();
//                 // loadOperations();
//                 alert('OK!')
//             } else {
//                 alert("Login failed");
//             }
//         }
//     };
//
//     let requestData = JSON.stringify({ username: username, password: password });
//     xhr.send(requestData);
//     alert(requestData);
// }

// Отправка AJAX запроса на регистрацию
// function registerUser(username, password) {
//     var xhr = new XMLHttpRequest();
//     xhr.open("POST", "/backend/src/index.php?action=register", true);
//     xhr.setRequestHeader("Content-Type", "application/json");
//
//     xhr.onreadystatechange = function () {
//         if (xhr.readyState === 4 && xhr.status === 200) {
//             var data = JSON.parse(xhr.responseText);
//             if (data.success) {
//                 alert("Registration successful, please log in");
//             } else {
//                 alert("Registration failed");
//             }
//         }
//     };
//
//     var requestData = JSON.stringify({ username: username, password: password });
//     xhr.send(requestData);
// }
//
// Добавление новой операции через AJAX
// function addOperation(amount, type, comment) {
//     var xhr = new XMLHttpRequest();
//     xhr.open("POST", "/backend/src/index.php?action=add-operation", true);
//     xhr.setRequestHeader("Content-Type", "application/json");
//
//     xhr.onreadystatechange = function () {
//         if (xhr.readyState === 4 && xhr.status === 200) {
//             var data = JSON.parse(xhr.responseText);
//             if (data.success) {
//                 loadOperations();
//                 updateSummary();
//             }
//         }
//     };
//
//     var requestData = JSON.stringify({ amount: amount, type: type, comment: comment });
//     xhr.send(requestData);
// }

// Загрузка последних операций
// function loadOperations() {
//     var xhr = new XMLHttpRequest();
//     xhr.open("GET", "/backend/src/index.php?action=get-operations", true);
//
//     xhr.onreadystatechange = function () {
//         if (xhr.readyState === 4 && xhr.status === 200) {
//             var data = JSON.parse(xhr.responseText);
//             var tableBody = document.querySelector("#operations-table tbody");
//             tableBody.innerHTML = "";
//             data.operations.forEach(function (op) {
//                 var row = document.createElement("tr");
//                 row.innerHTML = `
//                     <td>${op.id}</td>
//                     <td>${op.amount}</td>
//                     <td>${op.type}</td>
//                     <td>${op.comment}</td>
//                     <td>${op.date}</td>
//                     <td><button onclick="deleteOperation(${op.id})">Delete</button></td>
//                 `;
//                 tableBody.appendChild(row);
//             });
//         }
//     };
//     xhr.send();
// }

// // Обновление суммарных данных
// function updateSummary() {
//     var xhr = new XMLHttpRequest();
//     xhr.open("GET", "/backend/src/index.php?action=get-summary", true);
//
//     xhr.onreadystatechange = function () {
//         if (xhr.readyState === 4 && xhr.status === 200) {
//             var data = JSON.parse(xhr.responseText);
//             document.getElementById("total-income").textContent = data.totalIncome;
//             document.getElementById("total-expenses").textContent = data.totalExpenses;
//         }
//     };
//     xhr.send();
// }
//
// // Удаление операции
// function deleteOperation(id) {
//     var xhr = new XMLHttpRequest();
//     xhr.open("DELETE", `/backend/src/index.php?action=delete-operation&id=${id}`, true);
//
//     xhr.onreadystatechange = function () {
//         if (xhr.readyState === 4 && xhr.status === 200) {
//             loadOperations();
//             updateSummary();
//         }
//     };
//     xhr.send();
// }

