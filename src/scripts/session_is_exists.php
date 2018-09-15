<?php
    session_start();
    $redirect_time = 0;

    if (isset($_SESSION['userId'])){
        // ЕСЛИ ЕСТЬ СЕССИЯ ЮЗЕРА, ТО ПЕРЕНАПРАВЛЯЕМ В account.php
        if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 'user')
            echo "<SCRIPT> window.setTimeout(\"document.location = '../account/';\", $redirect_time); </SCRIPT>";

        // <ЕСЛИ ЕСТЬ СЕССИЯ АДМИНА, ТО ПЕРЕНАПРАВЛЯЕМ В control_panel.php
        if (isset($_SESSION['userRole']) && $_SESSION['userRole'] == 'admin')
            echo "<SCRIPT> window.setTimeout(\"document.location = '../admin/';\", $redirect_time);  </SCRIPT>";
    } 
?>