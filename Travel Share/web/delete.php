<?php

include_once 'dbConfig.php';

$delButton = "";
$updateButton = "";
$renameButton = "";
$retextButton = "";
//$albumNames = $db->query("SELECT DISTINCT album FROM photos ORDER BY album ASC");

$albumNames = $db->query("SELECT * FROM photos ORDER BY album ASC, user_name ASC");

if ($albumNames->num_rows > 0) {
    /*echo $albumNames->num_rows;
    echo "\n";*/
    while ($albumRow = $albumNames->fetch_assoc()) {
        $nameAlbum = $albumRow['album'];
        $delButton = "delete" . $nameAlbum;
        $updateButton = "submit" . $nameAlbum;
        $renameButton = "rename" . $nameAlbum;
        $retextButton = "retext" . $nameAlbum;
        /*echo $nameAlbum;
        echo "\r";*/
        if (isset($_POST[$delButton])) {
            $del = $db->query("DELETE FROM photos WHERE user_name = '{$_SESSION['username']}' AND  album = '$nameAlbum'");
            header('location: profile.php');
            exit();
        }
        if (isset($_POST[$renameButton])) {
            $getName = "changeName" . $nameAlbum;
            $newName = $_POST[$getName];

            $nameQuery = "SELECT * FROM  photos WHERE user_name=? AND album=? LIMIT 1";

            $stmt = $db->prepare($nameQuery);
            $stmt->bind_param('ss', $_SESSION['username'], $newName);
            $stmt->execute();

            $result = $stmt->get_result();
            $nameCount = $result->num_rows;
            $stmt->close();

            if ($nameCount > 0) {
                $newName = $newName . date("(Y-m-d-h-ia)");
            }

            $ren = $db->query("UPDATE photos SET album = '$newName' WHERE user_name = '{$_SESSION['username']}' AND  album = '$nameAlbum'");
            header('location: profile.php');
            exit();
        }
        if (isset($_POST[$retextButton])) {
            $getText = "changeText" . $nameAlbum;
            $newText = $_POST[$getText];
            $ret = $db->query("UPDATE photos SET text = '$newText' WHERE user_name = '{$_SESSION['username']}' AND  album = '$nameAlbum'");
            header('location: profile.php');
            exit();
        }
        if (isset($_POST[$updateButton])) {
            $targetDir = "uploads/";
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
            $text = $albumRow['text'];
            $album = $nameAlbum;
            $likesPeople = $albumRow['likesUsers'];
            $dislikesPeople = $albumRow['dislikesUsers'];
            $likeUSR = $albumRow['likesCount'];
            $dislikeUSR = $albumRow['dislikesCount'];

            $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = '';
            if (!empty(array_filter($_FILES['files']['name']))) {
                foreach ($_FILES['files']['name'] as $key => $val) {
                    $fileName = basename($_FILES['files']['name'][$key]);
                    $targetFilePath = $targetDir . $fileName;

                    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                    if (in_array($fileType, $allowTypes)) {
                        if (move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)) {
                            $insertValuesSQL .= "('" . $fileName . "','" . $_SESSION['username'] . "', NOW(),'" . $text . "', '" . $album . "', '" . $likesPeople . "' , '" . $dislikesPeople . "' , '" . $likeUSR . "', '" . $dislikeUSR . "'),";
                        } else {
                            $errorUpload .= $_FILES['files']['name'][$key] . ', ';
                        }
                    } else {
                        $errorUploadType .= $_FILES['files']['name'][$key] . ', ';
                    }
                }

                if (!empty($insertValuesSQL)) {
                    $insertValuesSQL = trim($insertValuesSQL, ',');
                    $insert = $db->query("INSERT INTO photos (file_name, user_name, uploaded_on, text, album, likesUsers, dislikesUsers, likesCount, dislikesCount) VALUES $insertValuesSQL");
                    if ($insert) {
                        $errorUpload = !empty($errorUpload) ? 'Upload Error: ' . $errorUpload : '';
                        $errorUploadType = !empty($errorUploadType) ? 'File Type Error: ' . $errorUploadType : '';
                        $errorMsg = !empty($errorUpload) ? '<br/>' . $errorUpload . '<br/>' . $errorUploadType : '<br/>' . $errorUploadType;
                        $statusMsg = "Files are uploaded successfully." . $errorMsg;
                    } else {
                        $statusMsg = "Sorry, there was an error uploading your file.";
                    }
                }
            } else {
                $statusMsg = 'Please select a file to upload.';
            }
            echo $statusMsg;
        }
        $delButton = "";
        $updateButton = "";
        $renameButton = "";
        $retextButton = "";
    }
}
