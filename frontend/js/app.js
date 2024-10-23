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
                    console.log(data.status)
                } else {
                    console.log(data.errors['userPass']);
                }
            });
    });

    // // Добавление операции
    // operationForm.addEventListener('submit', function (e) {
    //     e.preventDefault();
    //     const amount = operationForm.querySelector('[name="amount"]').value;
    //     const type = operationForm.querySelector('[name="type"]').value;
    //     const comment = operationForm.querySelector('[name="comment"]').value;
    //
    //     fetch('/api/operation.php', {
    //         method: 'POST',
    //         body: JSON.stringify({action: 'add', amount, type, comment}),
    //         headers: {'Content-Type': 'application/json'}
    //     })
    //     .then(response => response.json())
    //     .then(data => {
    //         if (data.status === 'success') {
    //             loadOperations();
    //         } else {
    //             alert('Failed to add operation');
    //         }
    //     });
    // });
    //
    // // Загрузка последних операций
    // function loadOperations() {
    //     fetch('/api/operation.php', {
    //         method: 'GET'
    //     })
    //     .then(response => response.json())
    //     .then(data => {
    //         // Обновление таблицы операций
    //         updateOperationsTable(data.operations);
    //         // Обновление итогов
    //         updateSummary(data.summary);
    //     });
    // }
    //
    // function updateOperationsTable(operations) {
    //     const tableBody = document.getElementById('operations-table-body');
    //     tableBody.innerHTML = '';
    //     operations.forEach(operation => {
    //         const row = document.createElement('tr');
    //         row.innerHTML = `
    //         <td>${operation.amount}</td>
    //         <td>${operation.type}</td>
    //         <td>${operation.comment}</td>
    //         <td><button data-id="${operation.id}" class="delete-operation">Delete</button></td>
    //     `;
    //         tableBody.appendChild(row);
    //     });
    //
    //     document.querySelectorAll('.delete-operation').forEach(button => {
    //         button.addEventListener('click', function () {
    //             const operationId = this.dataset.id;
    //             deleteOperation(operationId);
    //         });
    //     });
    // }
    //
    // function updateSummary(summary) {
    //     document.getElementById('total-income').textContent = summary.total_income;
    //     document.getElementById('total-expense').textContent = summary.total_expense;
    // }
    //
    // function deleteOperation(id) {
    //     fetch('/api/operation.php', {
    //         method: 'POST',
    //         body: JSON.stringify({action: 'delete', id}),
    //         headers: {'Content-Type': 'application/json'}
    //     })
    //     .then(response => response.json())
    //     .then(data => {
    //         if (data.status === 'success') {
    //             loadOperations();
    //         } else {
    //             alert('Failed to delete operation');
    //         }
    //     });
    // }
    //
    //     // Загрузка операций при старте
    // loadOperations();
});


















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
//     });
//
// });




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

