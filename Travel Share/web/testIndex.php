<?php

require_once 'controllers/authController.php';
include 'upload.php';
include 'likes.php';


if (!isset($_SESSION['id'])) {
    header('location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="testIndddd.css">

    <title>Homepage</title>
</head>

<body>

    <div id="header">

        <ul id="left">
            <li style="color: white; display:inline;"> Welcome, <?php echo $_SESSION['username'] ?></li>
        </ul>

        <ul>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="chatroom.php">Messenger</a></li>
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

        <!--<h3>Welcome, <?php echo $_SESSION['username']; ?></h3>-->

        <div class="forms">
            <div class="uploader">
                <form action="" method="post" enctype="multipart/form-data">
                    Select image files to upload:
                    <input type="file" name="files[]" multiple>
                    <input type="text" name="album" placeholder="Enter Album Name">
                    <textarea name="text" cols="60" rows="6" placeholder="Say something about this album of images.."></textarea>
                    <input type="submit" name="submit" value="UPLOAD">
                </form>
            </div>

            <div class="searchBar">
                <form action="search.php" method="post">
                    <input type="text" name="validUser" placeholder="Enter username for search..">
                    <input type="submit" name="searchName" value="Search">

                    <input type="text" name="validAlbum" placeholder="Enter album name for search..">
                    <input type="submit" name="searchAlbum" value="Search">
                </form>
            </div>
        </div>


        <div class="gallery">
            <?php
            include_once 'dbConfig.php';

            $query = $db->query("SELECT * FROM photos ORDER BY album ASC, user_name ASC");
            $copyQuery = $db->query("SELECT * FROM photos ORDER BY album ASC, user_name ASC");

            $copyRow = $copyQuery->fetch_assoc();
            $copyAlbum = $copyRow['album'];
            $copyCreator = $copyRow['user_name'];
            $count = 0;

            if ($query->num_rows > 0) {
                while ($row = $query->fetch_assoc()) {
                    $imageURL = 'uploads/' . $row["file_name"];
                    $uploadedBy = $row['user_name'];
                    $text = $row['text'];
                    $album = $row['album'];
                    $nLikes = $row['likesCount'];
                    $nDislikes = $row['dislikesCount'];
                    $same = "";
                    ?>

                    <?php if ($count == 0 || $album !== $copyAlbum || $uploadedBy !== $copyCreator) : ?>

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
                            <?php echo "Album author: " . $uploadedBy; ?>

                        </h2>

                        <button class="like">
                            <?php echo $nLikes; ?>
                            <br>
                            <form action="" method="post">
                                <input type="submit" name="<?php echo "like" . $uploadedBy . $album; ?>" value ="Like"/>
                            </form>
                            <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                        </button>
                        
                        <button class="dislike">
                            <?php echo $nDislikes; ?>
                            <br>
                            <form action="" method="post">
                                <input type="submit" name="<?php echo "dislike" . $uploadedBy . $album; ?>" value ="Dislike">
                            </form>
                            <i class="fa fa-thumbs-o-down" aria-hidden="true"></i>
                        </button>


                        <?php if(file_exists($imageURL)):?>
                            <img style="display: block; width: 60%; height: 400px; margin: 0 auto; margin-bottom: 20px;" src="<?php echo $imageURL;?>" alt="" />
                        <?php endif; ?>

                        <p>
                            <?php echo $text; ?>
                        </p>
                    <?php endif; ?>


                    <?php if($same !== $imageURL && file_exists($imageURL)):?>
                        
                            <div style="display: inline;">
                                
                                <img src="<?php echo $imageURL; ?>" alt="" />
                                <!--<button>Delete</button>-->
                            </div>    
                        <?php endif; ?>
                <?php }
            } else { ?>
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