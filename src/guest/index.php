<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
</head>
<body>
    <h1 align="center">Все издания кафедры</h1>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand mb-0 h1" style="color: white"> Вы вошли как гость </a>

        <form>
            <input type="submit" value="Зарегистрироваться" class="btn btn-info btn-sm" onclick="redirect('../registration/')"/>
        </form>
        <form>
            <input type="submit" value="Войти" class="btn btn-info btn-sm" onclick="redirect('../login/')"/>
        </form>
    </nav>

    <script>
        function redirect(path){
            window.setTimeout("document.location = '" + path + "';", 0);
        }
    </script>

    <?php 
        require('../account/get_publications_by_filter.php');
    ?>
</body>
</html>