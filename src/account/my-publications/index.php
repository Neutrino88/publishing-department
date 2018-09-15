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
                    <a class="nav-link" href="/account/publications">Издания кафедры</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/account/send-publication">Отправить издание</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="">Мои издания</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/account/edit-profile">Изменить профиль</a>
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
            <?php echo $_SESSION['userFullName']; ?>, добро пожаловать на наш ресурс!
            Ваш id = <strong> <?php echo $_SESSION['userId']; ?> </strong>
        </div>
    <?php 
    } 

    $_POST['authorId'] = $_SESSION['userId'];
    require('../get_publications_by_filter.php');
    ?>
</body>
</html>