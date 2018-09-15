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
                    <a class="nav-link disabled" href="">Издания кафедры</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/account/send-publication">Отправить издание</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/account/my-publications">Мои издания</a>
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

    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-4">
                <div class="alert alert-info" role="alert">
                    <h4>Фильтр</h4>
                    <form method="POST">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Автор</span>
                            </div>
                            <input type="text" name="author" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>

                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Дисциплина</span>
                            </div>
                            <input type="text" name="subject" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>

                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Вид издания</span>
                            </div>
                            <input type="text" name="type" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>

                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Год издания</span>
                            </div>
                            <input type="text" name="year" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                        </div>

                        <button type="submit" class="btn btn-info btn-sm btn-block" onclick="get_publications()">Найти</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
        require('../get_publications_by_filter.php');
    ?>

    <script>
        function get_publications(){ 
            var get_public = "<?php require('get_publications_by_filter.php'); ?>";
        }
    </script>
</body>
</html>