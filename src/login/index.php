<?php 
    session_start(); 
    require("../scripts/session_is_exists.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
</head>
<body>    
    <h1 align="center">Авторизация</h1>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link disabled" href='../guest/'>Издания кафедры</a>
                </li>
            </ul>
            <form>
                <input type="submit" value="Зарегистрироваться" class="btn btn-info btn-sm" onclick="redirect('../registration/')"/>
            </form>
        </div>
    </nav>

    <script>
        function redirect(path){
            window.setTimeout("document.location = '" + path + "';", 0);
        }
    </script>
    <?php
        if (isset($_POST['login']) && isset($_POST['password'])){
            // подключаемся к бд
            require("../scripts/connect.php");
            // отправляем запрос
            $login = $_POST['login'];
            $password = $_POST['password'];

            $query = "SELECT id, name, role, phone FROM person WHERE login='$login' AND password='$password'";
            $result = mysqli_query($connection, $query) or die(mysqli_error($connection));

            $count = mysqli_num_rows($result);
            $error = false;
            // Если запрос выполнился
            if ($count == 1){
                $row = mysqli_fetch_assoc($result);

                $_SESSION['userLogin'] = $login;
                $_SESSION['userFullName'] = $row['name'];
                $_SESSION['userId'] = $row['id'];
                $_SESSION['userRole'] = $row['role'];
                $_SESSION['userPhone'] = $row['phone'];

                if ($row['role'] == 'user')
                    echo "<SCRIPT> window.setTimeout(\"document.location = '../account/';\", 1); </SCRIPT>";
                if ($row['role'] == 'admin')
                    echo "<SCRIPT> window.setTimeout(\"document.location = '../admin/';\", 1); </SCRIPT>";
            }
            // Если запрос не выполнился
            else {
                $error_msg = "Неправильный логин или пароль!";
                $error = true;
            }

            // разрываем соединение с бд
            mysqli_free_result($result);
            mysqli_close($connection);
        }
    ?>
    <div id="register" class="container">
        <div class="row justify-content-md-center">
            <div class="col-4">
                <form method="POST">
                    <?php if ($error && isset($error_msg)){ ?>
                        <div role="alert" class="alert alert-danger">
                            <?php echo $error_msg; ?>
                        </div> 
                    <?php } ?>

                    <div class="form-group">
                        <label for="login">Логин</label>
                        <input id="login" name="login" class="form-control" required="required" type="text" placeholder="Введите логин" />
                    </div>

                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input id="password" name="password" type="password" class="form-control" placeholder="Введите пароль">
                    </div>

                    <button type="submit" class="btn btn-info btn-sm btn-block">Войти</button>
                </form>

                <div class="alert" role="alert">
                    Вы здесь впервые?
                    <a href="../registration/" class="alert-link">Зарегистрироваться</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
