<?php 
    session_start(); 
    require("../scripts/session_is_not_exists.php");

    if ($_SESSION['userRole'] != 'admin')
        echo "<SCRIPT> window.setTimeout(\"document.location = '../login/';\", $redirect_time); </SCRIPT>";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
</head>
<body>
    <h1 align="center">Панель управления</h1>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand mb-0 h1" style="color: white"> <?php echo "Администратор " . $_SESSION['userFullName']; ?> </a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link disabled" href="">Добавить информацию об издании</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="">Просмотр заявок</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="">Редактировать информацию об изданиях</a>
                </li>
            </ul>
        </div>
        <form action="../scripts/logout.php" method="POST">
            <input type="submit" value="Выйти" class="btn btn-info btn-sm"/>
        </form>
    </nav>
</body>
</html>