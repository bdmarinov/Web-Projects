<?php 

    require_once 'controllers/authController.php';
    include 'upload.php';


    if(!isset($_SESSION['id'])){
        header('location: login.php');
        exit();
    }    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <style type="text/css">
        .gallery img {
            width: 250px;
            height: 250px;
            display: inline;
        }
        #setBRogdan{
            color: red;
        }
    </style>

    <title>Homepage</title>
</head>

<body>
    
    <div class="container">

        <?php if(isset($_SESSION['message'])): ?>
            <div class="alert <?php echo $_SESSION['alert-class']; ?>">
                <?php 
                    echo $_SESSION['message']; 
                    unset($_SESSION['message']);
                    unset($_SESSION['alert-class']);
                ?>
            </div>
        <?php endif; ?>

        <h3>Welcome, <?php echo $_SESSION['username']; ?></h3>

        <a href="index.php?logout=1">Logout</a>

        <div class="uploader">
            <form action="" method="post" enctype="multipart/form-data">
            Select image files to upload:
            <input type="file" name="files[]" multiple>
            <textarea name="text" cols="40" rows="4" placeholder="Say something about this album of images.."></textarea>
            <input type="submit" name="submit" value="UPLOAD">
        </div>

        <div class="gallery">
            <?php
                include_once 'dbConfig.php';

                $query = $db->query("SELECT * FROM photos ORDER BY user_name ASC, text ASC");

                if($query->num_rows > 0){
                    $row = $query->fetch_assoc();
                    $curImageURL = 'uploads/'.$row['file_name'];
                    $uploadedBy = $row['user_name'];
                    $texterino = $row['text'];
                    ?> 

                    <h2 id="<?php echo "set" . $uploadedBy;?>"><?php echo $uploadedBy . "'s photos and stories:";?></h2>

                    <p><?php echo $texterino;?></p>

                    <img src="<?php echo $curImageURL;?>"/>

                    <?php
                    while($row = $query->fetch_assoc()){
                        $imageURL = 'uploads/'.$row['file_name'];
                        $currentUploadedBy = $row['user_name'];
                        $curText = $row['text'];
                        ?>
                        
                        <?php if($uploadedBy !== $currentUploadedBy): ?>
                        <h2>
                            <?php echo $currentUploadedBy . "'s photos and stories:";
                            $uploadedBy = $currentUploadedBy;?>
                        </h2>
                        <?php endif; ?>
                        
                        <?php if($texterino !== $curText): ?>
                            <p>
                                <?php echo $curText;
                                $texterino = $curText;?>
                            </p>
                        <?php endif; ?>

                        <img src="<?php echo $imageURL;?>"/>
                        <?php
                    }
                }else{
                    echo '<p>No image(s) found..</p>';
                }

            ?>

        </div>
    </div>

</body>

</html>