<?php

function changeType($type)
{
    if ($type == "apart") {
        return "Апартамент";
    } else if ($type == "house") {
        return "Къща";
    } else if ($type == "garage") {
        return "Гараж";
    }
}

function changePriceType($type)
{
    if ($type == "euro") {
        return "Евро";
    } else {
        return "Лева";
    }
}

function changeBuildingType($type)
{
    switch($type)
       {
        case "pan":
            return "Панел";
       case "tuh":
            return "Тухла";
        case "grad":
            return "Градоред";
        case "epk":
            return "ЕПК";
       case "pk":
            return "ПК";
        case "empty":
            return "0";
       }
}

function checkLowerFloor($firstFloor, $secondFloor, $remainder)
{
    if($firstFloor > $secondFloor)
    {
        $firstFloor = $remainder;
    }
    return $firstFloor;
}

function stripString($expression)
{
    //$str = explode("(\d+)", $expression);
    $str = filter_var($expression, FILTER_SANITIZE_NUMBER_INT);
    //echo $str;
    return $str;
}

if (isset($_POST['saveEdit'])) {


    $updateID = $_SESSION['idToEdit'];
    require_once("connectDB.php");
    $dB = new DbConnect();
    $connDb = $dB->connect();

    $newSQL = "SELECT * from homes where home_id = :home_id";
    $newStmt = $connDb->prepare($newSQL);

    $newStmt->bindParam(':home_id', $updateID, PDO::PARAM_INT);
    $newStmt->execute();

    $row = $newStmt->fetch(PDO::FETCH_ASSOC);

    //echo $row['home_id'];

    /*$updatedHomeType = changeType($_POST['changeHomeType']);
    $updatedHomeRooms = $_POST['changeHomeRooms'];
    $updatedHomePrice = $_POST['changeHomePrice'];
    $updatedPriceType = changePriceType($_POST['changePriceType']);
    $updatedHomeRegion = $_POST['changeHomeRegion'];
    $updatedHomeArea = $_POST['changeHomeArea'];
    $updatedHomeAgency = $_POST['changeHomeAgency'];
    $updatedFirstFloor = $_POST['changeFirstFloor'];
    $updatedSecondFloor = $_POST['changeSecondFloor'];
    $updatedHomeUrl = $_POST['changeHomeUrl'];
    $updatedhomeDescription = $_POST['changeHomeDescription'];

    
    echo $_SESSION['idToEdit'];
    echo $updatedHomeType;
    echo $updatedPriceType;*/
    
   //$updatedFirstFloor = checkLowerFloor($_POST['changeFirstFloor'], $_POST['changeSecondFloor'], $row['firstFloor']);

    $updatedHome = [
        'homeType' => changeType($_POST['changeHomeType']),
        'homeRooms' => $_POST['changeHomeRooms'],
        'homePrice' => $_POST['changeHomePrice'],
        'priceType' => changePriceType($_POST['changePriceType']),
        'homeRegion' => $_POST['changeHomeRegion'],
        'homeBuildingType' => changeBuildingType($_POST['changeHomeBuildingType']),
        'homeArea' => stripString($_POST['changeHomeArea']),
        'homeAgency'=> $_POST['changeHomeAgency'],
        //'homeFirstFloor'=> $_POST['changeFirstFloor'],
        'homeFirstFloor' => checkLowerFloor($_POST['changeFirstFloor'], $_POST['changeSecondFloor'], $row['homeFirstFloor']),
        'homeSecondFloor'=> $_POST['changeSecondFloor'],
        'homeUrl' => $_POST['changeHomeUrl'],
        'homeDescription' => $_POST['changeHomeDescription'],
        'home_id' => $_SESSION['idToEdit'],
    ];

    /*echo $updatedHome['homeBuildingType'];
    echo $updatedHome['homeType'];*/


    $sql = "UPDATE homes SET homeType=:homeType, homeRooms=:homeRooms, homePrice=:homePrice, priceType=:priceType, homeRegion=:homeRegion, homeBuildingType=:homeBuildingType, homeArea=:homeArea, homeAgency=:homeAgency, homeFirstFloor=:homeFirstFloor, homeSecondFloor=:homeSecondFloor, homeUrl=:homeUrl, homeDescription=:homeDescription WHERE home_id=:home_id";
    $stmt= $connDb->prepare($sql);
    $stmt->execute($updatedHome);
}
