<?php
require_once 'authController.php';
require_once 'delete.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="index.css">
    <title>Начална Страница</title>
</head>

<body>

    <div class="container">
        <form id="addBar" action="index.php" method="post">

            <select name="homeType" required>
                <option value="apart">Апартамент</option>
                <option value="house">Къща</option>
                <option value="garage">Гараж</option>
            </select>

            <label for="homeRooms">Стаи: </label>

            <input type="text" name="homeRooms" id="homeRooms" placeholder="" style="width: 37px; text-align: center;">

            <input type="number" name="homePrice" placeholder="Цена" class="numberLong" style="width: 70px;">

            <select name="priceType" required>
                <option value="euro">Евро</option>
                <option value="lev">Лева</option>
            </select>

            <input type="text" name="homeRegion" placeholder="Район(адрес)">

            <input type="number" name="homeArea" placeholder="Площ" class="numberLong" style="width: 57px;">

            <input type="text" name="homeAgency" placeholder="Агенция(телефон)">

            <select name="homeBuildingType" required>
                <option value="pan">Панел</option>
                <option value="tuh">Тухла</option>
                <option value="grad">Градоред</option>
                <option value="epk">ЕПК</option>
                <option value="pk">ПК</option>
                <option value="empty"></option>
            </select>

            <label for="home1st">Етаж: </label>
            <input type="number" name="homeFirstFloor" id="home1st" placeholder="" class="numberShort" style="width: 32px; text-align: center;">
            <label for="home2nd">от</label>
            <input type="number" name="homeSecondFloor" id="home2nd" placeholder="" class="numberShort" style="width: 32px; text-align: center;">
            <input type="url" name="homeUrl" style="width: 120px;" placeholder="Линк към обявата">

            <input type="submit" name="submit-btn" value="Запази">

            <label for="chk"><!--Добави -->Описание</label>
            <input type="checkbox" name="chkbox" id="chk" onclick="showHide()">

            <input type="reset" value="Отмени">

            <div id="hide">

                <textarea name="homeDescription" cols="100" rows="10"></textarea>
            </div>

            <div id="exportDIV">
            <input type="submit" style="float: right; margin-right: 100px;" name="export" value="Изтегляне">

                <input type="submit" name="search" style="margin-left: 100px;" value="Търсене">
            </div>

                    
        </form>


        <div id="homes">
            <?php
            include_once 'home.php';

            $objHomes = new home;
            $homes = $objHomes->getAll();
            echo "<table id='homes'>";
            echo "<th>" . "Вид на имота" . "</th>";
            echo "<th>" . "Стаи" . "</th>";
            echo "<th>" . "Цена" . "</th>";
            echo "<th>" . "Валута" . "</th>";
            echo "<th>" . "Квартал (адрес)" . "</th>";
            echo "<th>" . "Строителство" . "</th>";
            echo "<th>" . "Площ" . "</th>";
            echo "<th>" . "Агенция(телефон)" . "</th>";
            echo "<th>" . "Етаж:  __ от  __  " . "</th>";
            echo "<th>" . "" . "</th>";
            echo "<th>" . "" . "</th>";
            echo "<th>" . "" . "</th>";


            $counter = 0;
            while ($row = $homes->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                //echo $row['home_id'] . " " . $row['homeType'] . " " . $row['homePrice'];
                //echo "<td>" . $row['home_id'] . "</td>";
                echo "<td>" . $row['homeType'] . "</td>";
                echo "<td>" . $row['homeRooms'] . "</td>";
                echo "<td>" . $row['homePrice'] . "</td>";
                echo "<td>" . $row['priceType'] . "</td>";
                echo "<td>" . $row['homeRegion'] . "</td>";

                $buildingType = $row['homeBuildingType'];
                if($buildingType == "0")
                {
                    $buildingType = "";
                }

                echo "<td>" . $buildingType . "</td>";
                echo "<td>" . $row['homeArea'] . " кв.м" . "</td>";
                echo "<td class='right'>" . $row['homeAgency'] . "</td>";

                $firstFloor = $row['homeFirstFloor'];
                if($row['homeFirstFloor'] != null && $firstFloor == 0)
                {
                    $firstFloor = "Партер";
                }

                echo "<td class='right'>" . $firstFloor . " / " . $row['homeSecondFloor'] . "</td>";
                //$nmber = $counter;
                $linkShower = "Покажи линка";

                $currentTD = "myTD" . $counter;
                printf('<td ><button id="' . $currentTD . '" onClick="showDetails(\'%s\');">%s</button></td>', $counter, $linkShower);

                $currDIV = "myDIV" . $counter;
                //echo '<td> <div style="display:none;" id="' . $currDIV . '"> ' . $row['homeUrl'] . ' </div> </td>';
                if($row['homeUrl'] == "Няма зададен линк")
                {
                    echo '<td> <div style="display:none;" id="' . $currDIV . '"> ' . $row['homeUrl'] . ' </div> </td>';
                }else
                {
                    echo '<td> <a href="' . $row['homeUrl'] . '" target="_blank" style="display:none;" id="' . $currDIV . '"> ' . $row['homeUrl'] . ' </a> </td>';
                }

                //printf('<td><div style="display:none;" id="\'%s\'"> \'%s\' </div></td>', $currDIV, $row['homeUrl']);

                //echo '<td> <div style="display:none;" id="' . $currDIV . '"> ' . $row['homeUrl'] . ' </div> </td>';
                //echo '<td> <div style="display:none;" id="' .$currDIV . '"><a href="https://www.w3schools.com"></a></div></td>';


                $del = "Изтрий";

                $currDel = "delete" . $row['home_id'];
                $currChange = "change" . $row['home_id'];

                //echo '<td> <form action="index.php" method="post"> <input type ="submit" name="' . $currDel . '" value ="' . $del . '">  </form> </td>';
                echo '<td id="some"> <form style="display:inline; margin-left: 10px; margin-right: 10px;" action="index.php" method="post" onsubmit="return confirm(\'Сигурни ли сте, че искате да изтриете избраното?\');"> <input type ="submit" name="' . $currDel . '" value ="' . $del . '"></form> <form action="index.php" method="post" style="display: inline;"> <input type="submit" name="' . $currChange . '"  value="Промени"> </form> </td>';
                //printf('<td><form action="index.php" method="post" onsubmit="return confirm(\'              ')

                //echo "<td>" . "<button onclick='myFunction()'>" . "Покажи линка" . "</button>" . "</td>";
                //$currID = "myDIV";
                //echo "<td>" . "<div id='myDIV3'>" . $row['homeUrl'] . "</div>" . "</td>";
                //printf('%s', $currDIV);

                //printf('<td><div id="\'%s\'">%s</div></td>', $currDIV, $row['homeUrl']);

                //echo '<td> <div style="display:none;" id="'.$currDIV.'"> <a href="#">'.$row['homeUrl'].' </a> </div> </td>';


                //echo '<input type="button" id= "'.$row['home_id'].'" value="'.$row['home_id'].'" class="mybut btn btn-info btn-mini" style="">';

                //echo '<td> <button onclick="showDetails(3);"> value="'.$row['home_id'].'" </button> </td>';
                //printf('<td><button onClick="showDetails(\'%s\');">%s</button></td>', $nmber, $str);
                echo "</tr>";
                $counter++;
            }
            ?>
        </div>
    </div>


    <script>
        function showHide() {
            var checkbox = document.getElementById("chk");

            if(checkbox.checked)
            {
                document.getElementById("hide").style.display="block";
            }
            else
            {
                document.getElementById("hide").style.display="none";
            }
            
        }


        function showDetails(currentDIV) {
            if (currentDIV == undefined) {
                currentDIV = 0;
            }

            //alert(currentDIV);

            var divID = "myDIV" + currentDIV;
            var tdID = "myTD" + currentDIV;
            //alert(str);
            var tableHiddenDiv = document.getElementById(divID);
            if (tableHiddenDiv.style.display === "none") {
                tableHiddenDiv.style.display = "block";
                document.getElementById(tdID).innerHTML = "Скрий линка";
            } else {
                tableHiddenDiv.style.display = "none";
                document.getElementById(tdID).innerHTML = "Покажи линка";

            }

        }
    </script>

</body>

</html>