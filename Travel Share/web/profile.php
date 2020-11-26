<?php

require_once 'controllers/authController.php';
include 'delete.php';

if (!isset($_SESSION['id'])) {
    header('location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <style>
#myDIV {
  width: 100%;
  padding: 50px 0;
  text-align: center;
  background-color: lightblue;
  margin-top: 20px;
  display: none;
}
</style>

    <link type="text/css" rel="stylesheet" href="testIndddd.css">
    <script type="text/javascript" src="showDivs.js"></script>

    <title>Profile</title>
</head>

<body>

    <div id="header">

        <ul id="left">
            <li style="color: white; display:inline;"> Welcome, <?php echo $_SESSION['username']?></li>
        </ul>

        <ul>
            <li><a href="testIndex.php">Home</a></li>
            <li><a href="index.php?logout=1">Logout</a></li>
        </ul>
    </div>

    <div id="under">
        <h4 class="logo">
            <span class="word1">Travel</span>
            <span class="word2">Share</span>
        </h4>
    </div>

    <div class="container">

        <?php if (isset($_SESSION['message'])) : ?>
            <div class="alert <?php echo $_SESSION['alert-class']; ?>">
                <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                unset($_SESSION['alert-class']);
                ?>
            </div>
        <?php endif; ?>


        <div class="gallery" style="margin-top: 0px;">
        

            <?php
            include_once 'dbConfig.php';

            $query = $db->query("SELECT * FROM photos ORDER BY album ASC, user_name ASC");
            $copyQuery = $db->query("SELECT * FROM photos ORDER BY album ASC, user_name ASC");

            $copyRow = $copyQuery ->fetch_assoc();
            $copyAlbum = $copyRow['album'];
            $count = 0;
            $lookForEmail = $_SESSION['username'];

            

            if($query->num_rows > 0){
                while($row = $query->fetch_assoc()){
                    $imageURL = 'uploads/'.$row["file_name"];
                    $uploadedBy = $row['user_name'];

                    $text = $row['text'];
                    $album = $row['album'];
                    $same = "";
            ?>
 
            <?php if($lookForEmail === $uploadedBy): ?>
             <?php if ($count == 0 || $album !== $copyAlbum) : ?>
             
                        <br>
                            <h2 style="float: right; margin-right: 100px;">
                            <?php echo "Album name: " . $album;
                            $count++;
                            $copyAlbum = $album;
                            $copyCreator = $uploadedBy;
                            $same = $imageURL;
                            ?>
                        </h2>
                        
                        <h2>
                            <?php echo "Album author: " . $uploadedBy;?>

                        </h2>

                        <form action="profile.php" method = "post" enctype="multipart/form-data">
                        <p>
                            <input type="submit" name="<?php echo "delete" . $album;?>" value="Delete Album">
                            
                            <input type="text" name="<?php echo "changeName" . $album;?>" placeholder="Change album name">
                            <input type="submit" name="<?php echo "rename" . $album;?>" value="Rename Album">

                            <br><br>

                            <textarea name="<?php echo "changeText" . $album;?>" cols="80" rows="7"><?php echo $text; ?></textarea>
                            <input type="submit" name="<?php echo "retext" . $album;?>" value="Change Description">

                            <input type="file" name="files[]" multiple>
                                <input type="submit" name="<?php echo "submit" . $album; ?>" value="Update Album">
                        </p>

                        </form>
                        <?php if(file_exists($imageURL)):?>
                            <img style="display: block; width: 60%; height: 400px; margin: 0 auto; margin-bottom: 20px;" src="<?php echo $imageURL;?>" alt="" />
                        <?php endif; ?>
                        <p>
                            <?php echo $text;?>
                        </p>

                        <?php endif; ?>

                        <?php if($same !== $imageURL && file_exists($imageURL)):?>
                        
                            <div style="display: inline;">
                                
                                <img src="<?php echo $imageURL; ?>" alt="" />
                                <!--<button>Delete</button>-->
                            </div>    
                        <?php endif; ?>

            <?php endif; ?>

<?php }
            }else{ ?>
                <p style="margin-bottom: 0px; padding-bottom: 20px;">No image(s) found...</p>
            <?php } ?> 

            
        </div>
    </div>

    <div id="footer">
                <ul>
                    <li><a href="">About Travel Share</a></li>
                    <li><a href="">Careers</a></li>
                    <li><a href="">Help</a></li>
                    <li><a href="">Contact Us</a></li>
                </ul>
                &copy; 2019 www.travelshare.com. All Rights Reserved.
            </div>

</body>

</html>