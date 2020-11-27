<?php

if (isset($_POST['submit-btn'])) {
    require('home.php');

    $newHome = new home;

    $newHome->save($_POST['homeType'], $_POST['homeRooms'], $_POST['homePrice'], $_POST['priceType'], $_POST['homeRegion'], $_POST['homeBuildingType'], $_POST['homeArea'], $_POST['homeAgency'], $_POST['homeFirstFloor'], $_POST['homeSecondFloor'], $_POST['homeUrl'], $_POST['homeDescription']);
    $newHome->logIntoDB();
}

if (isset($_POST["export"])) {
    require('home.php');

    $newHome = new home;
    $newHome->export();
}

if(isset($_POST['search'])){
    header('location: search.php');
    exit();
}



/*require('home.php');

$newHome = new home;

$del = "";
$result = $newHome->dbConn->query("SELECT * from homes");

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $del = "delete" . $row['home_id'];
    //echo $del;
    if (isset($_POST[$del])) {
        $sql = "DELETE FROM homes WHERE home_id = :home_id";
        $stmt = $newHome->dbConn->prepare($sql);

        $stmt->bindParam(':home_id', $row['home_id'], PDO::PARAM_INT);
        $stmt->execute();

        try {
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}*/
