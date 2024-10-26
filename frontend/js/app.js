document.addEventListener('DOMContentLoaded', function () {
    const welcomeMsg = document.getElementById('welcome-msg')
    welcomeMsg.innerText = 'Добро пожаловать, ';

    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const logout = document.getElementById('logout-btn');
    const operationForm = document.getElementById('operation-form');

    const errName = document.getElementById('err-name');
    const errPass = document.getElementById('err-pass');

    checkSession();

    // Проверка сессии
    function checkSession() {
        fetch('src/auth.php', {
            method: 'POST',
            body: JSON.stringify({action: 'auth'}),
            headers: {'Content-Type': 'application/json'}
        })
        .then(response => response.json())
        .then(data => {
            if (data) {
                showMainApp();
                welcomeMsg.innerText = welcomeMsg.innerText + ' ' + data.user;
                loadOperations();
            } else {
                console.log(data);
            }
        });
    }

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
                deleteInputsErrs();
                showMainApp();
                welcomeMsg.innerText = welcomeMsg.innerText + ' ' + data.user;
            } else {
                addInputsErrs(data.errors)
            }
        });
    });


    logout.addEventListener('click', function (e) {
       e.preventDefault();

        fetch('src/auth.php', {
            method: 'POST',
            body: JSON.stringify({action: 'logout'}),
            headers: {'Content-Type': 'application/json'}
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showRegistration();
            }
        });
    });


    // Ф-ция для добавления ошибок
    function addInputsErrs(errs) {
        if (errs['userName'] !== '' && errs['userName'] !== undefined) {
            errName.innerText = errs['userName'];
        } else {
            errName.innerText = '';
        }

        if (errs['userPass'] !== '' && errs['userPass'] !== undefined) {
            errPass.innerText = errs['userPass'];
        } else {
            errPass.innerText = '';
        }
    }


    // Ф-ция для удаления ошибок
    function deleteInputsErrs() {
        errName.innerText = '';
        errPass.innerText = '';
    }

    // Ф-ция для отображения главного экрана
    function showMainApp() {
        document.getElementById("auth-form").style.display = "none";
        document.getElementById("main-app").style.display = "block";
    }

    // Ф-ция для отображения страницы регистрации
    function showRegistration() {
        document.getElementById("auth-form").style.display = "block";
        document.getElementById("main-app").style.display = "none";
    }

    // Добавление операции
    operationForm.addEventListener('submit', function (e) {
        e.preventDefault();
        let sum = operationForm.querySelector('[name="sum"]');
        let type = operationForm.querySelector('[name="type"]');
        let comment = operationForm.querySelector('[name="comment"]');

        let sumValue = sum.value;
        let typeValue = type.value;
        let commentValue = comment.value;

        fetch('src/operation.php', {
            method: 'POST',
            body: JSON.stringify({action: 'add', sumValue, typeValue, commentValue}),
            headers: {'Content-Type': 'application/json'}
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                loadOperations();
            } else {
                alert('Неправильно введены данные!');
            }
        });
    });

    // Загрузка последних операций
    function loadOperations() {
        fetch('src/operation.php', {
            method: 'POST',
            body: JSON.stringify({action: 'getLatest'}),
            headers: {'Content-Type': 'application/json'}
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            updateOperationsTable(data);
            // Обновление итогов
            updateSummary();
        });
    }

    function updateOperationsTable(operations) {
        const tableBody = document.getElementById('operations-table-body');
        tableBody.innerHTML = '';
        operations.forEach(operation => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="main-app__td">${operation.comment}</td>
                <td class="main-app__td">${operation.sum}</td>
                <td class="main-app__td">${operation.type}</td>
                <td class="main-app__td">${operation.date}</td>
                <td class="main-app__td"><button class="btn main-app__btn delete-btn" data-id="${operation.id}">Удалить</button></td>
            `;
            tableBody.appendChild(row);
        });

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                const operationId = this.dataset.id;
                deleteOperation(operationId);
            });
        });
    }

    function updateSummary() {

        fetch('src/operation.php', {
            method: 'POST',
            body: JSON.stringify({action: 'summary'}),
            headers: {'Content-Type': 'application/json'}
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);

            // if (data.totalIncome == null) {
            //     document.getElementById('total-income').innerText = '0';
            // } else {
            //     document.getElementById('total-income').innerText = data.totalIncome;
            // }

            if (data.totalExpenses == null) {
                document.getElementById('total-expense').innerText = 'hello';
            } else {
                document.getElementById('total-expense').innerText = data.totalExpenses;
            }
        });
    }


    // Ф-ция удаления операции
    function deleteOperation(operationId) {
        fetch('src/operation.php', {
            method: 'POST',
            body: JSON.stringify({action: 'delete', operationId}),
            headers: {'Content-Type': 'application/json'}
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                loadOperations();
            } else {
                alert('Ошибка при попытке удаления!');
            }
        });
    }

    //     // Загрузка операций при старте
    // loadOperations();
});