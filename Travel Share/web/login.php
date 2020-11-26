<?php

require_once 'controllers/authController.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="log.css">

    <title>Login</title>
</head>

<body>

<div id="header">
            <ul>
                <li>
                    <a href="reg.php">Register</a>
                 </li>
            </ul>
        </div>

        <div id="under">
            <h4 class="logo">
                <span class="word1">Travel</span>
                <span class="word2">Share</span>
            </h4>
        </div>
    
    <h1>Login</h1>

    <div id="main">
        <div id="mainH">
                <h2>Please enter valid data</h2>
            </div>
        <form action="login.php" method="post">

        <?php if(count($errors) > 0): ?>
        <div class="alert alert-danger" style="color: red">
            <?php foreach($errors as $error): ?>
                <li style="margin-left: 20px; margin-top:5px; list-style-type: none; font-weight: bold"><?php echo $error; ?></li>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

            <input type="text" name="username" value="<?php echo $username; ?>" placeholder="Please enter e-mail">

            <input type="password" name="password" placeholder="Please enter password">
 
            <button type="submit" style="margin: auto; margin-top:20px; margin-bottom:20px; display:block" class="button" name="login-btn">Login</button>

        <p style="color: white; text-align: center;">Not yet a member? <a href="reg.php" style="color: red;">Sign Up</a></p>
        </form>



    </div>

</body>


</html>