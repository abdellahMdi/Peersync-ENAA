<?php
session_start();
    $_SESSION['error'] = "";
if(isset($_POST["submit"])){
    header('Location: ../suggestions/index.php'); # path
    exit ;
}
if(empty($_POST["email"]))
 {
     $_SESSION['error'] = "you have to enter the email";
     header('Location: ../suggestions/index.php'); # path
     exit ;
 } elseif (empty($_POST["password"])) {
     $_SESSION['error'] = "you have to enter the password";
     header('Location: ../suggestions/index.php'); # path
     exit ;
 }
 unset($_SESSION['error']);

 