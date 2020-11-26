<?php
if (isset($_POST['submit'])) {

    include_once 'dbConfig.php';

    $targetDir = "uploads/";
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    $text = $_POST['text'];
    $album = $_POST['album'];
    $likeUSR = "";
    $dislikeUSR = "";
    $likesPeople = "";
    $dislikesPeople = "";

    $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = '';
    if (!empty(array_filter($_FILES['files']['name']))) {
        foreach ($_FILES['files']['name'] as $key => $val) {
            $fileName = basename($_FILES['files']['name'][$key]);
            $targetFilePath = $targetDir . $fileName;

            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            if (in_array($fileType, $allowTypes)) {
                if (move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)) {
                    $albumQuery = "SELECT * FROM  photos WHERE user_name=? AND album=? LIMIT 1";

                    $stmt = $db->prepare($albumQuery);
                    $stmt->bind_param('ss', $_SESSION['username'], $album);
                    $stmt->execute();

                    $result = $stmt->get_result();
                    $albumCount = $result->num_rows;
                    $stmt->close();

                    if ($albumCount > 0) {
                        $album = $album . date("(Y-m-d-h-ia)");
                    }
                    $insertValuesSQL .= "('" . $fileName . "','" . $_SESSION['username'] . "', NOW(),'" . $text . "', '" . $album . "', '" . $likeUSR . "', '" . $dislikeUSR . "'),";
                } else {
                    $errorUpload .= $_FILES['files']['name'][$key] . ', ';
                }
            } else {
                $errorUploadType .= $_FILES['files']['name'][$key] . ', ';
            }
        }

        if (!empty($insertValuesSQL)) {
            $insertValuesSQL = trim($insertValuesSQL, ',');
            $insert = $db->query("INSERT INTO photos (file_name, user_name, uploaded_on, text, album, likesUsers, dislikesUsers) VALUES $insertValuesSQL");
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
