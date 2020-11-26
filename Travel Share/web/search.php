<?php
    include 'header.php';
?>

<div id="header">

        <ul id="left">
        </ul>

        <ul>
            <li><a href="testIndex.php">Home</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="index.php?logout=1">Logout</a></li>
        </ul>
    </div>

    <div id="under">
        <h4 class="logo">
            <span class="word1">Travel</span>
            <span class="word2">Share</span>
        </h4>
    </div>

<div class="gallery">
<?php 
    $first = "";
    $second = "";

    if(isset($_POST['searchName'])){

        $first = $_POST['validUser'];

        if(!empty($first)){
            echo "<h1>".$first."'s albums: </h1>";
    
            $getAll = $db->query("SELECT * FROM photos ORDER BY album ASC, user_name ASC");
            
            $copyGetAll = $db->query("SELECT * FROM photos ORDER BY album ASC, user_name ASC");
            $copyGetRow = $copyGetAll->fetch_assoc();
            $copyGetAlbum = $copyGetRow['album'];
            $searchCount = 0;
    
            if($getAll->num_rows > 0){
                while($getAllRow = $getAll->fetch_assoc()){
                    $searchUser = $getAllRow['user_name'];
                    if($searchUser === $first){
    
                        $url = 'uploads/' . $getAllRow["file_name"];
                        $searchText = $getAllRow['text'];
                        $searchAlbum = $getAllRow['album'];
                        $searchSame = "";
        
                        if($searchCount == 0 || $copyGetAlbum !== $searchAlbum){
                            echo "<br>";
                            echo "<h2>Album name: ".$searchAlbum."</h2>";
                            $searchCount++;
                            $copyGetAlbum = $searchAlbum;
                            $searchSame = $url;
            
                            if(file_exists($url)){
                                echo "<img style='display: block; width: 60%; height: 400px; margin: 0 auto; margin-bottom: 20px;' src='".$url."' alt='' />";
                            }
            
                            echo "<p>".$searchText."";
                            echo "<br>";
                        }
        
                        if($searchSame !== $url && file_exists($url)){
                            echo "<img src='".$url."' alt='' />";
                        }
                    }
                    }
            }else{
                echo "<p style='margin-bottom: 0px; padding-bottom: 20px;'>No image(s) found...</p>";
            }    
        }else{
            header('location: testIndex.php');
            exit();
        }
    }

    if(isset($_POST['searchAlbum'])){

        $second = $_POST['validAlbum'];

        if(!empty($second)){
            echo "<h1>Albums containing: ".$second."</h1>";
    
            $getAll = $db->query("SELECT * FROM photos ORDER BY album ASC, user_name ASC");
            
            $copyGetAll = $db->query("SELECT * FROM photos ORDER BY album ASC, user_name ASC");
            $copyGetRow = $copyGetAll->fetch_assoc();
            $copyGetUser = $copyGetRow['user_name'];
            $copyGetAlbum = $copyGetRow['album'];
            $searchCount = 0;
    
            if($getAll->num_rows > 0){
                while($getAllRow = $getAll->fetch_assoc()){
                    $searchGetAlbum = $getAllRow['album'];

                    if(strpos($searchGetAlbum, $second) !== false){
                        
                        $url = 'uploads/' . $getAllRow["file_name"];
                        $searchUser = $getAllRow['user_name'];
                        $searchText = $getAllRow['text'];
                        $searchAlbum = $getAllRow['album'];
                        $searchSame = "";
        
                        if($searchCount == 0 || $copyGetAlbum !== $searchAlbum || $searchUser !== $copyGetUser){
                            echo "<br>";
                            echo "<h2>Album name: ".$searchAlbum.", Author: ".$searchUser."</h2>";
                            $searchCount++;
                            $copyGetAlbum = $searchAlbum;
                            $copyGetUser = $searchUser;
                            $searchSame = $url;
            
                            if(file_exists($url)){
                                echo "<img style='display: block; width: 60%; height: 400px; margin: 0 auto; margin-bottom: 20px;' src='".$url."' alt='' />";
                            }
            
                            echo "<p>".$searchText."";
                            echo "<br>";
                        }
        
                        if($searchSame !== $url && file_exists($url)){
                            echo "<img src='".$url."' alt='' />";
                        }
                    }
                    }
            }else{
                echo "<p style='margin-bottom: 0px; padding-bottom: 20px;'>No image(s) found...</p>";
            }    
        }else{
            header('location: testIndex.php');
            exit();
        }
    }
?>
</div>