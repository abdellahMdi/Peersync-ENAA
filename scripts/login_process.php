<?php
session_start(); 
require_once __DIR__ . "/../Repositories/UserRepository.php";

$_SESSION['error'] = "";
$email    = htmlentities($_POST["email"]);
$password = $_POST["password"];

if (empty($email)) {
    $_SESSION['error'] = "You have to enter the email";
    header('Location: ../suggestions/index.php');
    exit; 
} elseif (empty($password)) {
    $_SESSION['error'] = "You have to enter the password";
    header('Location: ../suggestions/index.php');
    exit;
} else {
    checkUserEntries($email, $password);
}

function checkUserEntries($email, $password) {
    $response = getUserByEmail($email);

    if (empty($response->email)) {
        $_SESSION['error'] = "This email: $email doesn't belong to any student";
        header('Location: ../suggestions/index.php');
        exit;
    }

    if ($response->role == "apprenant") {
        if (!password_verify($password, $response->password)) {
            $_SESSION['error'] = "Wrong password";
            header('Location: ../suggestions/index.php');
            exit;
        }

        
        $_SESSION['user_id']    = $response->id;
        $_SESSION['user_name']  = $response->name;
        $_SESSION['user_email'] = $response->email;
        $_SESSION['user_role']  = $response->role;

        if ($response->first_time == 0) {
            updateFirstTime($response->id);
            header('Location: ../suggestions/first_login.php');
        } else {
            header('Location: ../suggestions/dashboard.php'); 
        }
        exit;
    }
}