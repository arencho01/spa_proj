document.addEventListener('DOMContentLoaded', function () {
    const welcomeMsg = document.getElementById('welcome-msg');
    welcomeMsg.innerText = 'Добро пожаловать, ';

    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const logout = document.getElementById('logout-btn');
    const operationForm = document.getElementById('operation-form');

    const errName = document.getElementById('err-name');
    const errPass = document.getElementById('err-pass');

    const errRegName = document.getElementById('err-reg-name');
    const errRegPass = document.getElementById('err-reg-pass');

    checkSession();

    // Проверка сессии
    function checkSession() {
        fetch('index.php', {
            method: 'POST',
            body: JSON.stringify({action: 'auth'}),
            headers: {'Content-Type': 'application/json'}
        })
        .then(response => response.json())
        .then(data => {
            if (data !== '') {
                showMainApp();
                welcomeMsg.innerText = welcomeMsg.innerText + ' ' + data;
                loadOperations();
            }
        });
    }

    loginForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const login = loginForm.querySelector('[name="login"]').value;
        const password = loginForm.querySelector('[name="password"]').value;

        fetch('index.php', {
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
                loadOperations();
            } else {
                addInputsErrs(data.errors)
            }
        });
    });



    const regBtn = document.getElementById('register-link');

    regBtn.addEventListener('click', function (e) {
        e.preventDefault();

        showRegistration();
    });


    const regForm = document.getElementById('register-form');

    registerForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const login = registerForm.querySelector('[name="login"]').value;
        const password = registerForm.querySelector('[name="password"]').value;

        fetch('index.php', {
            method: 'POST',
            body: JSON.stringify({action: 'register', login, password}),
            headers: {'Content-Type': 'application/json'}
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    deleteInputsErrsReg();
                    showMainApp();
                    welcomeMsg.innerText = welcomeMsg.innerText + ' ' + data.user;
                    loadOperations();
                } else {
                    addInputsErrsReg(data.errors)
                }
            });
    });


    logout.addEventListener('click', function (e) {
       e.preventDefault();

        fetch('index.php', {
            method: 'POST',
            body: JSON.stringify({action: 'logout'}),
            headers: {'Content-Type': 'application/json'}
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showLogin();
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

    function addInputsErrsReg(errs) {
        console.log(errs)
        if (errs['userName'] !== '' && errs['userName'] !== undefined) {
            errRegName.innerText = errs['userName'];
        } else {
            errRegName.innerText = '';
        }

        if (errs['userPass'] !== '' && errs['userPass'] !== undefined) {
            errRegPass.innerText = errs['userPass'];
        } else {
            errRegPass.innerText = '';
        }
    }


    // Ф-ции для удаления ошибок
    function deleteInputsErrs() {
        errName.innerText = '';
        errPass.innerText = '';
    }

    function deleteInputsErrsReg() {
        errRegName.innerText = '';
        errRegPass.innerText = '';
    }

    // Ф-ция для отображения главного экрана
    function showMainApp() {
        document.getElementById("auth-block").style.display = "none";
        document.getElementById('register-block').style.display = "none";
        document.getElementById("main-app").style.display = "block";
    }

    // Ф-ция для отображения страницы регистрации
    function showRegistration() {
        document.getElementById("auth-block").style.display = "none";
        document.getElementById("main-app").style.display = "none";
        document.getElementById("register-block").style.display = "block";
    }

    function showLogin() {
        document.getElementById("main-app").style.display = "none";
        document.getElementById("register-block").style.display = "none";
        document.getElementById("auth-block").style.display = "block";
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

        fetch('index.php', {
            method: 'POST',
            body: JSON.stringify({action: 'add-operation', sumValue, typeValue, commentValue}),
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
        fetch('index.php', {
            method: 'POST',
            body: JSON.stringify({action: 'get-latest'}),
            headers: {'Content-Type': 'application/json'}
        })
        .then(response => response.json())
        .then(data => {
            console.log(data)
            updateOperationsTable(data);
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

        fetch('index.php', {
            method: 'POST',
            body: JSON.stringify({action: 'get-summary'}),
            headers: {'Content-Type': 'application/json'}
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('total-income').innerText = data.totalIncome;
            document.getElementById('total-expenses').innerText = data.totalExpenses;
        });
    }


    // Ф-ция удаления операции
    function deleteOperation(operationId) {
        fetch('index.php', {
            method: 'POST',
            body: JSON.stringify({action: 'delete-operation', operationId}),
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