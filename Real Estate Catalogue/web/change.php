<?php
session_start();
require_once 'updateController.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="change.css">
    <title>Промени</title>
</head>

<body>

    <div class="container">
        
        <button class="back" onclick="location.href='index.php';">Назад</button>
        <h2 id="formHeader">Моля редактирайте полетата, които желаете да промените</h2>
        <?php

        $idToEdit = $_SESSION['idToEdit'];

        require_once("connectDB.php");
        $dB = new DbConnect();
        $connDb = $dB->connect();

        $newSQL = "SELECT * from homes where home_id = :home_id";
        $newStmt = $connDb->prepare($newSQL);

        $newStmt->bindParam(':home_id', $idToEdit, PDO::PARAM_INT);
        $newStmt->execute();

        $row = $newStmt->fetch(PDO::FETCH_ASSOC);
        ?>


        <div class="container">
            <form action="change.php" method="post">
                <div class="row">
                    <div class="col-25">
                        <label for="changeHomeType">Вид на имота</label>
                    </div>
                    <div class="col-75">
                        <select id="changeHomeType" name="changeHomeType" required>
                            <?php
                            if ($row['homeType'] == "Апартамент") {
                                echo '<option value="apart">Апартамент</option>';

                                echo '<option value="house">Къща</option>';
                                echo '<option value="garage">Гараж</option>';
                            } else if ($row['homeType'] == "Къща") {
                                echo '<option value="house">Къща</option>';

                                echo '<option value="apart">Апартамент</option>';
                                echo '<option value="garage">Гараж</option>';
                            } else if ($row['homeType'] == "Гараж") {
                                echo '<option value="garage">Гараж</option>';
                                echo '<option value="apart">Апартамент</option>';
                                echo '<option value="house">Къща</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="changeHomeRooms">Брои стаи</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="changeHomeRooms" name="changeHomeRooms" value=<?php echo $row['homeRooms'] ?>>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="changeHomePrice">Цена на имота</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="changeHomePrice" name="changeHomePrice" value=<?php echo $row['homePrice'] ?>>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="changePriceType">Валута</label>
                    </div>
                    <div class="col-75">
                        <select id="changePriceType" name="changePriceType">

                            <?php
                            if ($row['priceType'] == "Евро") {
                                echo '<option value="euro">Евро</option>';
                                echo '<option value="lev">Лева</option>';
                            } else if ($row['priceType'] == "Лева") {
                                echo '<option value="lev">Лева</option>';
                                echo '<option value="euro">Евро</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="changeHomeRegion">Квартал (адрес)</label>
                    </div>
                    <div class="col-75">
                        <?php
                        printf('<input type="text" id="changeHomeRegion" name="changeHomeRegion" value=\'%s\'>', $row['homeRegion']);
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="changeHomeBuildingType">Строителство</label>
                    </div>
                    <div class="col-75">
                        <?php
                        $buildingTypes = array("Панел", "Тухла", "Градоред", "ЕПК", "ПК", "0");
                        $buildingValues = array("pan", "tuh", "grad", "epk", "pk", "empty");

                        $currBuildingType = $row['homeBuildingType'];
                        

                        echo '<select id="changeHomeBuildingType" name="changeHomeBuildingType">';
                        printf('<option value="%s">%s</option>', $buildingValues[array_search($currBuildingType, $buildingTypes)], ($row['homeBuildingType'] == "0") ? "" : $row['homeBuildingType']);
                        //printf('<option value="text" id="changeHomeBuildingType" name="changeHomeBuildingType" value=\'%s\'>', $row['homeBuildingType']);
                        for($i = 0; $i < 6; $i++)
                        {
                            if($buildingTypes[$i] != $currBuildingType)
                            {
                                if($buildingTypes[$i] == "0")
                                {
                                    $buildingTypes[$i] = "";
                                }
                                printf('<option value="%s">%s</option>', $buildingValues[$i], $buildingTypes[$i]);
                            }
                        }
                        echo '</select>';
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="changeHomeArea">Площ</label>
                    </div>
                    <div class="col-75">
                        <?php
                        $tempArea = $row['homeArea'] . " кв.м";
                        printf('<input type="text" class="changeHomeArea" name="changeHomeArea" value=\'%s\'>', $tempArea);
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="changeHomeAgency">Агенция(телефон)</label>
                    </div>
                    <div class="col-75">
                        <!--<input type="text" id="changeHomeAgency" name="changeHomeAgency" value="<?/*php echo $myVar;*/ ?>">-->
                        <?php
                        printf('<input type="text" id="changeHomeAgency" name="changeHomeAgency" value=\'%s\'>', $row['homeAgency']);
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="changeFirstFloor">Етаж</label>
                    </div>
                    <div class="col-75">
                        <?php
                        //Row size = 940px; TO CHANGE
                        printf('<input type="text" style="display: inline; width: 370px; text-align: center; margin-left: 78px; margin-right: 10px; "id="changeFirstFloor" name="changeFirstFloor" value=\'%s\'>', $row['homeFirstFloor']);
                        echo " от ";
                        printf('<input type="text" style="display: inline; width: 370px; text-align: center; margin-left: 10px; margin-right: 78px; "id="changeSecondFloor" name="changeSecondFloor" value=\'%s\'>', $row['homeSecondFloor']);
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="changeHomeUrl">Линк към имота</label>
                    </div>
                    <div class="col-75">
                        <?php
                        printf('<input type="text" id="changeHomeUrl" name="changeHomeUrl" value=\'%s\'>', $row['homeUrl']);
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="changeHomeDescription">Описание на имота</label>
                    </div>
                    <div class="col-75">
                        <textarea id="changeHomeDescription" name="changeHomeDescription" style="height:200px">
                            <?php echo $row['homeDescription'] ?> 
                        </textarea>

                    </div>
                </div>
                <div class="row">
                    <input type="submit" name="saveEdit" value="Запази промените">
                    <input type="reset" name="undoEdit" style="margin-right: 20px;" value="Отмени промените">
                </div>
            </form>
        </div>

    </div>

</body>

</html>