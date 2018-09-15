<?php
	// загрузка списка изданий
    require("../../scripts/connect.php");

    // учитываем фильтр
    $add_condition = "";

    if (isset($_POST['author']) && $_POST['author'] != "") {
    	$add_condition = $add_condition . " AND authors = '" . $_POST['author'] . "'";
    }

    if (isset($_POST['subject']) && $_POST['subject'] != "") {
    	$add_condition = $add_condition . " AND subject = '" . $_POST['subject'] . "'";
    }

    if (isset($_POST['type']) && $_POST['type'] != "") {
    	$add_condition = $add_condition . " AND public_type = '" . $_POST['type'] . "'";
    }

    if (isset($_POST['year']) && $_POST['year'] != "") {
    	$add_condition = $add_condition . " AND publiс_year = " . $_POST['year'];
    }

    if (isset($_POST['authorId'])) {
        $add_condition = $add_condition . " AND person_id = " . $_POST['authorId'];
    }

    // формируем запрос
    $query = "SELECT * FROM publication WHERE id = id " . $add_condition;
    $result = mysqli_query($connection, $query);

    if ($result){
        $rows = mysqli_num_rows($result); // количество полученных строк
 
        if ($rows > 0){
            echo "<table class=\"table\">
                    <thead>
                        <tr>
                            <th scope=\"col\">#</th>
                            <th scope=\"col\">Дисциплина</th>
                            <th scope=\"col\">Вид издания</th>
                            <th scope=\"col\">Тираж</th>
                            <th scope=\"col\">Список авторов</th>
                            <th scope=\"col\">Год издания</th>
                            <th scope=\"col\">Выходные данные</th>
                        </tr>
                    </thead>
                    <tbody>";

            for ($i = 0 ; $i < $rows ; ++$i) {
                $row = mysqli_fetch_row($result);
                echo "<tr>";
                    echo "<th scope=\"row\">" . ($i + 1) . "</th>";
                    for ($j = 2 ; $j < 8 ; ++$j) echo "<td>$row[$j]</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";        
        } else {
            echo "<h4>Ещё нет ни одной публикации</h4>";
        }
    }
?>