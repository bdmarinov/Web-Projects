<?php

session_start();

require_once("connectDB.php");
$db = new DbConnect();
$conn = $db->connect();


$del = "";
$change= "";

$result = $conn->query("SELECT * from homes");

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $del = "delete" . $row['home_id'];
    $change = "change" . $row['home_id'];
    //echo $change;
    //echo $del;
    if (isset($_POST[$del])) {
        $sql = "DELETE FROM homes WHERE home_id = :home_id";
        $stmt = $conn->prepare($sql);

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
    if(isset($_POST[$change])){
        $_SESSION['idToEdit'] = $row['home_id'];
        header('location: change.php');
        exit();
    }
}