<?php

session_start();

require 'config/db.php';

$errors = array();
$username = "";
$email = "";

if(isset($_POST['signup-btn'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConf = $_POST['passwordConf'];

    if(empty($username)){
        $errors['username'] = "Username required"; 
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "Email address is invalid";
    }

    if(empty($email)){
        $errors['email'] = "Email required"; 
    }

    if(empty($password)){
        $errors['password'] = "Password required"; 
    }

    if($password !== $passwordConf){
        $errors['password'] = "The two passwords do not match";
    }

    $emailQuery = "SELECT * FROM  users WHERE email=? LIMIT 1"; 
    
    $stmt = $conn->prepare($emailQuery);
    $stmt->bind_param('s', $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $userCount = $result->num_rows;
    $stmt->close();

    if($userCount > 0){
        $errors['email'] = "Email already exists";
    }

    $usernameQuery = "SELECT * FROM users WHERE username=? LIMIT 1";
    $stmt = $conn->prepare($usernameQuery);
    $stmt->bind_param('s', $username);
    $stmt->execute();

    $resultUsername = $stmt->get_result();
    $usernameCount = $resultUsername->num_rows;
    $stmt->close();

    if($usernameCount > 0){
        $errors['username'] = "Username already exists";
    }


    if(count($errors) === 0){
        $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $username, $email, $password);

        if($stmt->execute()){
            $user_id = $conn->insert_id;
            $_SESSION['id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;

            $_SESSION['message'] = "You are now logged in!";
            $_SESSION['alert-class'] = "alert-success";
            header('location: testIndex.php');
            exit();
        }else{
            $errors['db_error'] = "Database error: failed to register";
        }
    }
}

if(isset($_POST['login-btn'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(empty($username)){
        $errors['username'] = "Username required"; 
    }

    if(empty($password)){
        $errors['password'] = "Password required"; 
    }

    if(count($errors) === 0){
        $sql = "SELECT * FROM users WHERE email=? OR username=? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $username, $username);
        $stmt->execute();
    
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
    
        if (password_verify($password, $user['password'])){
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
    
            $_SESSION['message'] = "You are now logged in!";
            $_SESSION['alert-class'] = "alert-success";
            header('location: testIndex.php');
            exit();
        }else{
            $errors['login_fail'] = "Wrong credentials";
        }
    }
}

if (isset($_GET['logout'])){
    session_destroy();
    unset($_SESSION['id']);
    unset($_SESSION['username']);
    unset($_SESSION['email']);
    header('location: login.php');
    exit();
}