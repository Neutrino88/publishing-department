<?php 
    session_start();  
    require("../scripts/session_is_exists.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
</head>
<body>
    <h1 align="center">Регистрация</h1>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link disabled" href='../guest/'>Издания кафедры</a>
                </li>
            </ul>
            <form>
                <input type="submit" value="Войти" class="btn btn-info btn-sm" onclick="redirect('../login/')"/>
            </form>
        </div>
    </nav>
    <?php
        // Проверка заполненых полей
        if (isset($_POST['fullname']) && isset($_POST['phone']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password_confirm'])){
            $error = false;
            if (!isset($_FILES['photo'])){
                $error_msg = "Файл не выбран!";
                $error = true;
            }
            else if ($_POST['password'] != $_POST['password_confirm']){
                $error_msg = "Пароли не совпадают!";
                $error = true;
            }  
            else if (isset($_FILES['photo']) && isset($_FILES['photo']['size']) && $_FILES['photo']['size'] > 1048576){
                $error_msg = "Файл с изображением слишком большой!";
                $error = true;
            }

            if (!$error) {
                // Подключение к бд
                require("../scripts/connect.php");

                $fullname = $_POST['fullname'];
                $phone = $_POST['phone'];
                $login = $_POST['username'];
                $password = $_POST['password'];
                $role = 'user';
                $photoData = addslashes(fread(fopen($_FILES['photo']["tmp_name"], "r"), filesize($_FILES['photo']["tmp_name"])));
                $photoMimeType = $_FILES['photo']['type'];
                
                // отправка запроса
                $query = "INSERT INTO person (name, phone, login, password, role, photo, photoMimeType) VALUES ('$fullname', '$phone', '$login', '$password', '$role', '$photoData', '$photoMimeType')";
                $result = mysqli_query($connection, $query);

                if ($result){
                    $_SESSION['regist_msg'] = "Регистрация прошла успешно";

                    // получаем id пользователя из бд
                    $query = "SELECT id FROM person WHERE login='$login' AND password='$password'";
                    $result = mysqli_query($connection, $query);
                    $row = mysqli_fetch_assoc($result);
                    $userId = $row['id'];
                    
                    mysqli_free_result($result);
                    mysqli_close($connection);

                    // сохраняем данные в сессию
                    $_SESSION['userLogin'] = $login;
                    $_SESSION['userFullName'] = $fullname;
                    $_SESSION['userId'] = $userId;
                    $_SESSION['userRole'] = $role;
                    $_SESSION['userPhone'] = $phone;
                    // Перенаправление в личный кабинет
                    if ($role == 'user')
                        echo "<SCRIPT> window.setTimeout(\"document.location = '/account/';\", 1); </SCRIPT>";
                    else if ($role == 'admin')
                        echo "<SCRIPT> window.setTimeout(\"document.location = '/admin/';\", 1); </SCRIPT>";
                 }
                else {
                    $error_msg = "Не удается зарегистрироваться, возможно логин уже занят!";
                    $error = true;
                }           
            }
        }
    ?>

    <div id="register" class="container">
        <div class="row justify-content-md-center">
            <div class="col-4">
                <form name="registrationForm" method="POST" enctype="multipart/form-data">
                    <?php if ($error && isset($error_msg)) {?>
                        <div id="errorMsg" role="alert" class="alert alert-danger">
                            <?php echo $error_msg; ?>
                        </div> 
                    <?php } ?>

                    <div class="form-group">
                        <label for="fullname">Полное имя</label>
                        <input id="fullname" name="fullname" class="form-control" required="required" type="text" placeholder="Иванов Иван Иванович" pattern="^[А-Яа-яЁё]{3,}\s+[А-Яа-яЁё]{3,}\s*(\s[А-Яа-яЁё]{3,})?$"/>
                    </div>

                    <div class="form-group">
                        <label for="phone">Телефон</label>
                        <input id="phone" name="phone" class="form-control" required="required" type="text" placeholder="+79876543210" pattern="^\+[0-9][0-9]{10}$"/>
                    </div>

                    <div class="form-group">
                        <label for="photo">Фотография</label>
                        <input id="photo" name="photo" type="file" class="form-control" required="required" accept="image/*"/>
                        <small id="photoHelp" class="form-text text-muted">Размер до 1 Мб</small>
                    </div>

                    <div class="form-group">
                        <label for="username">Логин</label>
                        <input id="username" name="username" class="form-control" required="required" type="text" placeholder="Логин"/>
                    </div>

                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input id="password" name="password" type="password" class="form-control" required="required" placeholder="******">
                        <small id="passwordHelp" class="form-text text-muted">Должен содержать символы английской раскладки, верхнего и нижнего регистра, цифры, длина пароля не менее 6 символов</small>
                    </div>

                    <div class="form-group">
                        <label for="password_confirm">Подтверждение пароля</label>
                        <input id="password_confirm" name="password_confirm" type="password" placeholder="******" required="required" class="form-control">
                    </div>
                    
                    <button type="submit" class="btn btn-info btn-sm btn-block" onclick="validateData()">Зарегистрироваться</button>
                </form>

                <div class="alert" role="alert">
                    Уже зарегистрированы?
                    <a href="../login/" class="alert-link">Войти</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        function redirect(path){
            window.setTimeout("document.location = '" + path + "';", 0);
        }
        
        function validateData() {
            // ПРОВЕРЯЕМ ЛОГИН
            validLogin() &&
            // ПРОВЕРЯЕМ ПАРОЛЬ
            validPassword() &&
            // ПРОВЕРЯЕМ ФАЙЛ
            validPhoto();
        }

        function validPhoto(){
            var input, file;

            input = document.getElementById('photo');
            if (input) {
                file = input.files[0];

                // если размер файла больше 1 Мб
                if (file.size > 1048576){             
                    showErrorMsg("Файл с изображением слишком большой!");
                }
                else {
                    return true;
                }

                input.value = "";
                return false;
            }
        }

        function validPassword(){
            var upChar = false;
            var loChar = false;
            var numChar = false;
            var wrongChar = false;

            var password = document.getElementById('password').value;
            var password_confirm = document.getElementById('password_confirm').value;
            for (var i = 0; i < password.length; i++){
                if ("0" <= password.charAt(i) && password.charAt(i) <= "9")
                    numChar = true;
                else if ("a" <= password.charAt(i) && password.charAt(i) <= "z")
                    loChar = true;
                else if ("A" <= password.charAt(i) && password.charAt(i) <= "Z")
                    upChar = true;
                else 
                    wrongChar = true;
            }
            // если запрещенный символ или не все условия выполнены, то выводим сообщение
            if (wrongChar || !(upChar && loChar && numChar)){
                showErrorMsg("Пароль обязательно должен сожержать только символы латинского алфавита и цифры!");
            } 
            // если меньше 6 символов
            else if (password.length < 6){
                showErrorMsg("Слишком короткий пароль!");
            }
            else if (password != password_confirm){
                showErrorMsg("Пароли не совпадают!");
            }
            else {
                return true;
            }

            document.getElementById('password').value = "";
            document.getElementById('password_confirm').value = "";
            return false;
        }

        function validLogin(){
            /*
            var wrongChar = false;
            
            var login = document.getElementById('login').value;
            for (var i = 0; i < login.length; i++)
                if ( !(
                    ("0" <= login.charAt(i) && login.charAt(i) <= "9") ||
                    ("a" <= login.charAt(i) && login.charAt(i) <= "z") ||
                    ("A" <= login.charAt(i) && login.charAt(i) <= "Z") ))
                {
                    showErrorMsg("Логин может состоять только из букв латинского алфавита и цифр!");
                    document.getElementById('login').value = "";
                    return false;
                }
            */
            return true;
        }

        function showErrorMsg(msg){
            let div = document.getElementById("errorMsg");
            if (typeof div == object){
                div = document.createElement('div');
                registrationForm.insertBefore(div, registrationForm.firstChild);
            }

            div.className = "alert alert-danger";
            div.setAttribute("role", "alert");
            div.innerHTML = msg;
        }
    </script>
</body>
</html>
