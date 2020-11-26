<?php

require_once 'controllers/authController.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="log.css">

    <title>Register</title>
</head>

<body>


    <div id="under">
            <h4 class="logo">
                <span class="word1">Travel</span>
                <span class="word2">Share</span>
            </h4>
        </div>

    <h1>Register</h1>

    <div id="main">
        <div id="mainH">
                <h2>Please enter valid data</h2>
            </div>
        <form action="reg.php" method="post">


            <?php if (count($errors) > 0) : ?>
                <div class="alert alert-danger" style="color: red">
                    <?php foreach ($errors as $error) : ?>
                        <li style="margin-left: 20px; margin-top:5px; list-style-type: none; font-weight: bold"><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>


            <input type="text" name="username" value="<?php echo $username; ?>" placeholder="Please enter username">
            <input type="email" name="email" value="<?php echo $email; ?>" placeholder="Please enter correct e-mail">
            <input type="password" name="password" placeholder="Please enter password">
            <input type="password" name="passwordConf" placeholder="Please enter password again">
            
            <button type="submit" style="margin: auto; margin-top:20px; margin-bottom:20px; display:block"  class="button" name="signup-btn">Register</button>


            <p style="color: white; text-align: center;">Already a member? <a href="login.php" style="color: red;">Sign In</a></p>
            
        </form>



    </div>

</body>


</html>