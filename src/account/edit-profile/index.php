<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
</head>
<body>
    <h1 align="center">Личный кабинет</h1>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand mb-0 h1" style="color: white"> <?php echo $_SESSION['userFullName']; ?> </a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../publications/">Издания кафедры</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../send-publication">Отправить издание</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../my-publications">Мои издания</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="">Изменить профиль</a>
                </li>
            </ul>

            <form action="../../scripts/logout.php" method="POST">
                <input type="submit" value="Выйти" class="btn btn-light btn-sm"/>
            </form>
        </div>
    </nav>

    <?php 
    require("../../scripts/session_is_not_exists.php");

    if ($_SESSION['userRole'] != 'user')
        echo "<SCRIPT> window.setTimeout(\"document.location = '../../login/';\", $redirect_time); </SCRIPT>";

    // ЕСЛИ СЕЙЧАС ЗАРЕГИСТРИРОВАЛИСЬ, ТО ВЫВОДИМ СООБЩЕНИЕ
    if (isset($_SESSION['regist_msg'])){ ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Регистрация прошла успешно!</strong> 
            <?php echo $_SESSION['userFullName']; unset($_SESSION['regist_msg']); ?>, добро пожаловать на наш ресурс!
            Ваш id = <strong> <?php echo $_SESSION['userId']; ?> </strong>
        </div>
    <?php } ?>
    <?php
        // Проверка заполненых полей
        if (isset($_POST['fullname']) && isset($_POST['phone']) && isset($_POST['username']) && isset($_POST['password']) ){
            $error = false;

            if (!$error) {
                // Подключение к бд
                require("../../scripts/connect.php");

                $fullname = $_POST['fullname'];
                $phone = $_POST['phone'];
                $login = $_POST['username'];
                $password = $_POST['password'];
                $role = 'user';
                $userId = $_SESSION['userId'];
                
                // отправка запроса
                $query = "UPDATE person SET name = '$fullname' AND phone = '$phone' AND login = '$login' AND password = '$password' WHERE id = '$userId'";
                $result = mysqli_query($connection, $query);

                if ($result){
                    $_SESSION['regist_msg'] = "Данные успешно изменены!";

                    // получаем id пользователя из бд                   
                    mysqli_free_result($result);
                    mysqli_close($connection);

                    // сохраняем данные в сессию
                    $_SESSION['userFullName'] = $fullname;
                    $_SESSION['userPhone'] = $phone;
                    $_SESSION['userLogin'] = $login;
                 }
                else {
                    $error_msg = "Не удается изменить данные!";
                    $error = true;
                }           
            }
        }
    ?>
    <div id="register" class="container">
        <div class="row justify-content-md-center">
            <div class="col-4">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="fullname">Полное имя</label>
                        <input id="fullname" name="fullname" class="form-control" required="required" type="text" value="<?php echo $_SESSION['userFullName']; ?>" pattern="^[А-Яа-яЁё]{3,}\s+[А-Яа-яЁё]{3,}\s*(\s[А-Яа-яЁё]{3,})?$"/>
                    </div>

                    <div class="form-group">
                        <label for="phone">Телефон</label>
                        <input id="phone" name="phone" class="form-control" required="required" type="text" value="<?php echo $_SESSION['userPhone']; ?>" pattern="^\+[0-9][0-9]{10}$"/>
                    </div>
                    
                    <div class="form-group">
                        <label for="username">Логин</label>
                        <input id="username" name="username" class="form-control" required="required" type="text" value="<?php echo $_SESSION['userLogin']; ?>" pattern="^[A-Za-z0-9_]{3,}$"/>
                    </div>

                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input id="password" name="password" type="password" class="form-control" required="required" pattern="^[A-Za-z0-9]{6,}$">
                        <small id="passwordHelp" class="form-text text-muted">Должен содержать символы английской раскладки, верхнего и нижнего регистра, цифры, длина пароля не менее 6 символов</small>
                    </div>

                    <button type="submit" class="btn btn-info btn-sm btn-block">Сохранить</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>