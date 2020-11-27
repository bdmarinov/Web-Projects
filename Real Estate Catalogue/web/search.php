<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="search.css">
    <title>Търсене</title>
</head>

<body>

    <div class="container">

        <form action="search.php" method="post">
            <h2 id="formHeader">Търсене</h2>
            <div class="row">
                <div class="col-25">
                    <label for="searchHomeType">Вид на имота:</label>
                </div>
                <div class="col-75">

                    <label class="contain">Апартамент
                        <input type="checkbox" name="searchType[]" value="Апартамент">
                        <span class="checkmark"></span>
                    </label>

                    <label class="contain" style="margin-left: 20px;">Къща
                        <input type="checkbox" name="searchType[]" value="Къща">
                        <span class="checkmark"></span>
                    </label>

                    <label class="contain" style="margin-left: 20px;">Гараж
                        <input type="checkbox" name="searchType[]" value="Гараж">
                        <span class="checkmark"></span>
                    </label>
                </div>
            </div>

            <div class="row">
                <div class="col-25">
                    <label for="searchRooms">Брой стаи:</label>
                </div>
                <div class="col-75">
                    <input type="text" id="searchRooms" name="searchRooms">
                </div>
            </div>

            <div class="row">
                <div class="col-25">
                    <label for="searchRegion">Квартал (адрес):</label>
                </div>
                <div class="col-75">
                    <input type="text" id="searchRegion" name="searchRegion">

                </div>
            </div>

            <div class="row">
                <div class="col-25">
                    <label for="searchAgency">Агенция(телефон):</label>
                </div>
                <div class="col-75">
                    <input type="text" id="searchAgency" name="searchAgency">

                </div>
            </div>

            <div class="row">
                <div class="col-25">
                    <label for="searchPriceFirst">Цена на имота:</label>
                </div>
                <div class="col-75">
                    <label for="searchPriceFirst">от:</label>
                    <input type="text" style="display: inline; width: 120px; text-align: center; margin-right: 10px; " id="searchPriceFirst" name="searchPriceFirst">
                    <label for="searchPriceSecond">до:</label>
                    <input type="text" style="display: inline; width: 120px; text-align: center; " id="searchPriceSecond" name="searchPriceSecond">

                </div>
            </div>

            <div class="row">
                <div class="col-25">
                    <label for="searchAreaFirst">Площ:</label>
                </div>
                <div class="col-75">
                    <label for="searchAreaFirst">от:</label>
                    <input type="text" style="display: inline; width: 120px; text-align: center; margin-right: 10px; " id="searchAreaFirst" name="searchAreaFirst">
                    <label for="searchAreaSecond">до:</label>
                    <input type="text" style="display: inline; width: 120px; text-align: center; " id="searchAreaSecond" name="searchAreaSecond">

                </div>
            </div>

            <div class="row">
                <div class="col-25">
                    <label for="searchFloorFirst">Етаж:</label>
                </div>
                <div class="col-75">
                    <label for="searchFloorFirst">от:</label>
                    <input type="text" style="display: inline; width: 120px; text-align: center; margin-right: 10px; " id="searchFloorFirst" name="searchFloorFirst">
                    <label for="searchFloorSecond">до:</label>
                    <input type="text" style="display: inline; width: 120px; text-align: center; " id="searchFloorSecond" name="searchFloorSecond">

                </div>
            </div>

            <div class="row">
                <div class="col-25">
                    <label for="searchBuildingType">Вид строителство:</label>
                </div>
                <div class="col-75">

                    <label class="contain">Панел
                        <input type="checkbox" name="buildingType[]" value="Панел">
                        <span class="checkmark"></span>
                    </label>

                    <label class="contain" style="margin-left: 20px;">Тухла
                        <input type="checkbox" name="buildingType[]" value="Тухла">
                        <span class="checkmark"></span>
                    </label>

                    <label class="contain" style="margin-left: 20px;">ЕПК
                        <input type="checkbox" name="buildingType[]" value="ЕПК">
                        <span class="checkmark"></span>
                    </label>

                    <label class="contain">Градоред
                        <input type="checkbox" name="buildingType[]" value="Градоред">
                        <span class="checkmark"></span>
                    </label>

                    <label class="contain">ПК
                        <input type="checkbox" name="buildingType[]" value="ПК">
                        <span class="checkmark"></span>
                    </label>


                </div>
            </div>

            <div style="margin-top: 6px; clear: both;">
                <input type="submit" id="search" name="search" value="Търси">
            </div>
        </form>

    </div>

    <?php

    if (isset($_POST['search'])) {
        echo '<div id="homes" style="margin-top: 15px; margin-bottom: 15px;">';

        require_once("connectDB.php");
        $dB = new DbConnect();
        $connDb = $dB->connect();

        $result = $connDb->query("SELECT * from homes");

        $stackType = array();

        if (!empty($_POST['searchType'])) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                if (in_array($row['homeType'], $_POST['searchType'])) {
                    array_push($stackType, $row['home_id']);
                }
            }
        }

        /*
            echo 'STACK TYPE: ';
            print_r($stackType);
            echo '<br>';
            */

        $result = $connDb->query("SELECT * from homes");

        $stackRooms = array();

        if (!empty($_POST['searchRooms'])) {
            $prevStackCount = count($stackType);

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                if (strpos(strtoupper($row['homeRooms']), strtoupper($_POST['searchRooms'])) !== false) {
                    //echo $row['home_id'] . '<br>';
                    //echo 'PREV STACK COUNT: ' . $prevStackCount . '<br>';
                    if ($prevStackCount > 0 && in_array($row['home_id'], $stackType)) {
                        array_push($stackRooms, $row['home_id']);
                    } else {
                        if ($prevStackCount == 0) {
                            array_push($stackRooms, $row['home_id']);
                        }
                        //echo 'here <br>';
                        //array_push($stackRooms, $row['home_id']);
                    }
                }
            }
        } else {
            //echo 'EMPTY ROOMS<br>';
            $stackRooms = $stackType;
        }

        /*
            echo 'STACK ROOMS: ';
            print_r($stackRooms);
            echo '<br>';
            */

        $result = $connDb->query("SELECT * from homes");

        $stackRegion = array();

        if (!empty($_POST['searchRegion'])) {
            $prevStackCount = count($stackRooms);

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                if (strpos(mb_strtoupper($row['homeRegion']), mb_strtoupper($_POST['searchRegion'])) !== false) {
                    //echo $row['home_id'] . '<br>';
                    //echo 'PREV STACK COUNT: ' . $prevStackCount . '<br>';
                    if ($prevStackCount > 0 && in_array($row['home_id'], $stackRooms)) {
                        array_push($stackRegion, $row['home_id']);
                    } else {
                        if ($prevStackCount == 0) {
                            array_push($stackRegion, $row['home_id']);
                        }
                        //echo 'here <br>';
                        //array_push($stackRooms, $row['home_id']);
                    }
                }
            }
        } else {
            //echo 'EMPTY REGION<br>';
            $stackRegion = $stackRooms;
        }

        /*
            echo 'STACK REGION: ';
            print_r($stackRegion);
            echo '<br>';
            */

        $result = $connDb->query("SELECT * from homes");
        $stackAgency = array();

        if (!empty($_POST['searchAgency'])) {
            $prevStackCount = count($stackRegion);

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                //echo strtoupper($row['homeAgency']);
                if (strpos(mb_strtoupper($row['homeAgency']), mb_strtoupper($_POST['searchAgency'])) !== false) {
                    //echo $row['home_id'] . '<br>';
                    //echo 'PREV STACK COUNT: ' . $prevStackCount . '<br>';
                    if ($prevStackCount > 0 && in_array($row['home_id'], $stackRegion)) {
                        array_push($stackAgency, $row['home_id']);
                    } else {
                        if ($prevStackCount == 0) {
                            array_push($stackAgency, $row['home_id']);
                        }
                        //echo 'here <br>';
                        //array_push($stackRooms, $row['home_id']);
                    }
                }
            }
        } else {
            //echo 'EMPTY AGENCY<br>';
            $stackAgency = $stackRegion;
        }

        /*
            echo 'STACK AGENCY: ';
            print_r($stackAgency);
            echo '<br>';
            */

        $result = $connDb->query("SELECT * from homes");
        $stackLowerPrice = array();

        if (!empty($_POST['searchPriceFirst'])) {
            $prevStackCount = count($stackRegion);

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                if ($row['homePrice'] >= $_POST['searchPriceFirst']) {
                    //echo $row['home_id'] . '<br>';
                    //echo 'PREV STACK COUNT: ' . $prevStackCount . '<br>';
                    if ($prevStackCount > 0 && in_array($row['home_id'], $stackAgency)) {
                        array_push($stackLowerPrice, $row['home_id']);
                    } else {
                        if ($prevStackCount == 0) {
                            array_push($stackLowerPrice, $row['home_id']);
                        }
                        //echo 'here <br>';
                        //array_push($stackRooms, $row['home_id']);
                    }
                }
            }
        } else {
            //echo 'EMPTY LOWER PRICE<br>';
            $stackLowerPrice = $stackAgency;
        }

        /*
            echo 'STACK LOWER PRICE: ';
            print_r($stackLowerPrice);
            echo '<br>';
            */

        $result = $connDb->query("SELECT * from homes");
        $stackHigherPrice = array();

        if (!empty($_POST['searchPriceSecond'])) {
            $prevStackCount = count($stackLowerPrice);

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                if ($row['homePrice'] <= $_POST['searchPriceSecond']) {
                    //echo $row['home_id'] . '<br>';
                    //echo 'PREV STACK COUNT: ' . $prevStackCount . '<br>';
                    if ($prevStackCount > 0 && in_array($row['home_id'], $stackLowerPrice)) {
                        array_push($stackHigherPrice, $row['home_id']);
                    } else {
                        if ($prevStackCount == 0) {
                            array_push($stackHigherPrice, $row['home_id']);
                        }
                        //echo 'here <br>';
                        //array_push($stackRooms, $row['home_id']);
                    }
                }
            }
        } else {
            //echo 'EMPTY HIGHER PRICE<br>';
            $stackHigherPrice = $stackLowerPrice;
        }

        /*
            echo 'STACK HIGHER PRICE: ';
            print_r($stackHigherPrice);
            echo '<br>';
            */

        $result = $connDb->query("SELECT * from homes");
        $stackLowerArea = array();

        if (!empty($_POST['searchAreaFirst'])) {
            $prevStackCount = count($stackHigherPrice);

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                if ($row['homeArea'] >= $_POST['searchAreaFirst']) {
                    //echo $row['home_id'] . '<br>';
                    //echo 'PREV STACK COUNT: ' . $prevStackCount . '<br>';
                    if ($prevStackCount > 0 && in_array($row['home_id'], $stackHigherPrice)) {
                        array_push($stackLowerArea, $row['home_id']);
                    } else {
                        if ($prevStackCount == 0) {
                            array_push($stackLowerArea, $row['home_id']);
                        }
                        //echo 'here <br>';
                        //array_push($stackRooms, $row['home_id']);
                    }
                }
            }
        } else {
            //echo 'EMPTY LOWER AREA<br>';
            $stackLowerArea = $stackHigherPrice;
        }

        /*
            echo 'STACK LOWER AREA: ';
            print_r($stackLowerArea);
            echo '<br>';
            */

        $result = $connDb->query("SELECT * from homes");
        $stackHigherArea = array();

        if (!empty($_POST['searchAreaSecond'])) {
            $prevStackCount = count($stackLowerArea);

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                if ($row['homeArea'] <= $_POST['searchAreaSecond']) {
                    //echo $row['home_id'] . '<br>';
                    //echo 'PREV STACK COUNT: ' . $prevStackCount . '<br>';
                    if ($prevStackCount > 0 && in_array($row['home_id'], $stackLowerArea)) {
                        array_push($stackHigherArea, $row['home_id']);
                    } else {
                        if ($prevStackCount == 0) {
                            array_push($stackHigherArea, $row['home_id']);
                        }
                        //echo 'here <br>';
                        //array_push($stackRooms, $row['home_id']);
                    }
                }
            }
        } else {
            //echo 'EMPTY HIGHER AREA<br>';
            $stackHigherArea = $stackLowerArea;
        }

        /*
            echo 'STACK HIGHER AREA: ';
            print_r($stackHigherArea);
            echo '<br>';
            */

        $result = $connDb->query("SELECT * from homes");
        $stackLowerFloor = array();

        if (!empty($_POST['searchFloorFirst'])) {
            $prevStackCount = count($stackHigherArea);

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                if ($row['homeFirstFloor'] != null && $row['homeFirstFloor'] >= $_POST['searchFloorFirst']) {
                    //echo $row['home_id'] . '<br>';
                    //echo 'PREV STACK COUNT: ' . $prevStackCount . '<br>';
                    if ($prevStackCount > 0 && in_array($row['home_id'], $stackHigherArea)) {
                        array_push($stackLowerFloor, $row['home_id']);
                    } else {
                        if ($prevStackCount == 0) {
                            array_push($stackLowerFloor, $row['home_id']);
                        }
                        //echo 'here <br>';
                        //array_push($stackRooms, $row['home_id']);
                    }
                }
            }
        } else {
            //echo 'EMPTY LOWER FLOOR<br>';
            $stackLowerFloor = $stackHigherArea;
        }

        /*
            echo 'STACK LOWER FLOOR: ';
            print_r($stackLowerFloor);
            echo '<br>';
            */

        $result = $connDb->query("SELECT * from homes");
        $stackHigherFloor = array();

        if (!empty($_POST['searchFloorSecond'])) {
            $prevStackCount = count($stackLowerFloor);

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                if ($row['homeFirstFloor'] != null && $row['homeFirstFloor'] <= $_POST['searchFloorSecond']) {
                    //echo $row['home_id'] . '<br>';
                    //echo 'PREV STACK COUNT: ' . $prevStackCount . '<br>';
                    if ($prevStackCount > 0 && in_array($row['home_id'], $stackLowerFloor)) {
                        array_push($stackHigherFloor, $row['home_id']);
                    } else {
                        if ($prevStackCount == 0) {
                            array_push($stackHigherFloor, $row['home_id']);
                        }
                        //echo 'here <br>';
                        //array_push($stackRooms, $row['home_id']);
                    }
                }
            }
        } else {
            //echo 'EMPTY HIGHER FLOOR<br>';
            $stackHigherFloor = $stackLowerFloor;
        }

        /*
            echo 'STACK HIGHER FLOOR: ';
            print_r($stackHigherFloor);
            echo '<br>';
            */

        $result = $connDb->query("SELECT * from homes");
        $stackBuildingType = array();

        if (!empty($_POST['buildingType'])) {
            $prevStackCount = count($stackHigherFloor);

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                if (in_array($row['homeBuildingType'], $_POST['buildingType'])) {
                    //echo $row['home_id'] . '<br>';
                    //echo 'PREV STACK COUNT: ' . $prevStackCount . '<br>';
                    if ($prevStackCount > 0 && in_array($row['home_id'], $stackHigherFloor)) {
                        array_push($stackBuildingType, $row['home_id']);
                    } else {
                        if ($prevStackCount == 0) {
                            array_push($stackBuildingType, $row['home_id']);
                        }
                        //echo 'here <br>';
                        //array_push($stackRooms, $row['home_id']);
                    }
                }
            }
        } else {
            //echo 'EMPTY BUILDING TYPE<br>';
            $stackBuildingType = $stackHigherFloor;
        }

        /*
            echo 'STACK ROOMS: ';
            print_r($stackBuildingType);
            echo '<br>';
            */

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
        $stackCounter = count($stackBuildingType);

        //echo 'STACK COUNTER: ' . $stackCounter;
        //echo $stackRegion[1];

        $result = $connDb->query("SELECT * from homes");

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            if (in_array($row['home_id'], $stackBuildingType)) {
                echo "<tr>";

                echo "<td>" . $row['homeType'] . "</td>";
                echo "<td>" . $row['homeRooms'] . "</td>";
                echo "<td>" . $row['homePrice'] . "</td>";
                echo "<td>" . $row['priceType'] . "</td>";
                echo "<td>" . $row['homeRegion'] . "</td>";
                echo "<td>" . $row['homeBuildingType'] . "</td>";
                echo "<td>" . $row['homeArea'] . " кв.м" . "</td>";
                echo "<td class='right'>" . $row['homeAgency'] . "</td>";

                $firstFloor = $row['homeFirstFloor'];
                if ($row['homeFirstFloor'] != null && $firstFloor == 0) {
                    $firstFloor = "Партер";
                }

                echo "<td class='right'>" . $firstFloor . " / " . $row['homeSecondFloor'] . "</td>";

                $linkShower = "Покажи линка";

                $currentTD = "myTD" . $counter;
                printf('<td ><button id="' . $currentTD . '" onClick="showDetails(\'%s\');">%s</button></td>', $counter, $linkShower);

                $currDIV = "myDIV" . $counter;
                echo '<td> <div style="display:none;" id="' . $currDIV . '"> ' . $row['homeUrl'] . ' </div> </td>';

                $del = "Изтрий";

                $currDel = "delete" . $row['home_id'];
                $currChange = "change" . $row['home_id'];


                echo '<td id="some"> <form style="display:inline; margin-left: 10px; margin-right: 10px;" action="index.php" method="post" onsubmit="return confirm(\'Сигурни ли сте, че искате да изтриете избраното?\');"> <input type ="submit" name="' . $currDel . '" value ="' . $del . '"></form> <form action="index.php" method="post" style="display: inline;"> <input type="submit" name="' . $currChange . '"  value="Промени"> </form> </td>';

                echo "</tr>";
            }
            $counter++;
        }
        echo '</div>';
    }
    ?>

    <script>
        function showHide() {
            var checkbox = document.getElementById("chk");

            if (checkbox.checked) {
                document.getElementById("hide").style.display = "block";
            } else {
                document.getElementById("hide").style.display = "none";
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