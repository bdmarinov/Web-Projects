<?php

include_once 'dbConfig.php';

$likes = "";
$dislikes = "";

$allUsers = $db->query("SELECT * FROM photos ORDER BY album ASC, user_name ASC");

if($allUsers->num_rows > 0){
    while($allUsersRow = $allUsers->fetch_assoc()){
        $nameOfOwner = $allUsersRow['user_name'];
        $currentAlbum = $allUsersRow['album'];

        $currentLikes = $allUsersRow['likesCount'];
        $currentDislikes = $allUsersRow['dislikesCount'];

        $currentLikesUsers = $allUsersRow['likesUsers'];
        $currentDislikesUsers = $allUsersRow['dislikesUsers'];

        $likes = "like" . $nameOfOwner . $currentAlbum;
        $dislikes = "dislike" . $nameOfOwner . $currentAlbum;
        //echo $likes . "\r";
        //echo $dislikes . "\r";

        $currentUser = $_SESSION['username'];

        if(isset($_POST[$likes])){
            if(strpos($currentLikesUsers, $currentUser) !== false){
                $currentLikes = $currentLikes - 1;
                $currentLikesUsers = str_replace($currentUser, '', $currentLikesUsers); 
                $changeLikesUsers = $db->query("UPDATE photos set likesUsers = '$currentLikesUsers' WHERE user_name = '$nameOfOwner' AND  album = '$currentAlbum'");
            }else{
                $currentLikes = $currentLikes + 1;
                $currentLikesUsers = $currentLikesUsers . $_SESSION['username'];
                $changeLikesUsers = $db->query("UPDATE photos set likesUsers = '$currentLikesUsers' WHERE user_name = '$nameOfOwner' AND  album = '$currentAlbum'");
            }
            $upLikes = $db->query("UPDATE photos SET likesCount = '$currentLikes' WHERE user_name = '$nameOfOwner' AND  album = '$currentAlbum'");
            header('location: testIndex.php');
            exit();
        }
        if(isset($_POST[$dislikes])){
            if(strpos($currentDislikesUsers, $currentUser) !== false){
                $currentDislikes = $currentDislikes - 1;
                $currentDislikesUsers = str_replace($currentUser, '', $currentDislikesUsers);
                $changeDislikesUsers = $db->query("UPDATE photos set dislikesUsers = '$currentDislikesUsers' WHERE user_name = '$nameOfOwner' AND  album = '$currentAlbum'");
            }else{
                $currentDislikes = $currentDislikes + 1;
                $currentDislikesUsers = $currentDislikesUsers . $_SESSION['username'];
                $changeDislikesUsers = $db->query("UPDATE photos set dislikesUsers = '$currentDislikesUsers' WHERE user_name = '$nameOfOwner' AND  album = '$currentAlbum'");
            }
            $downLikes = $db->query("UPDATE photos SET dislikesCount = '$currentDislikes' WHERE user_name = '$nameOfOwner' AND  album = '$currentAlbum'");
            header('location: testIndex.php');
            exit();
        }
        $likes = "";
        $dislikes = "";
    }
}


