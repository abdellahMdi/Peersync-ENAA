<?php
require_once __DIR__ . "/../Repositories/UserRepository.php";

session_start();
    $_SESSION['error'] = "";
    $email = htmlentities($_POST["email"]);
    $password = $_POST["password"]; 

if(empty($_POST["email"]))
 {
     $_SESSION['error'] = "you have to enter the email";
     header('Location: ../suggestions/index.php'); # path
 } elseif (empty($_POST["password"])) {
     $_SESSION['error'] = "you have to enter the password";
     header('Location: ../suggestions/index.php'); # path
 }else {
    checkUserEntries($email , $password);
 }
 exit ;
 function checkUserEntries($email , $password){
    $response = getUserByEmail($email);
    if($response->email !== $email ){
    $_SESSION['error'] = "this email : ".$email." Doesn't belong to any student";
     header('Location: ../suggestions/index.php'); # path
     exit ;
    }
    $_SESSION['user_id'] = $response->id ;
    $_SESSION['user_name'] = $response->name ;
    $_SESSION['user_email'] = $response->email ;
    $_SESSION['user_role'] = $response->role ;

    if($response->role == "apprenant"){
        if(!password_verify($password, $response->password)){
            $_SESSION['error'] = "wrong password";
            header('Location: ../suggestions/index.php'); # path
            exit ;
        }
        if($response->first_time == 0){
            updateFirstTime($response->id);
            header('Location: ../suggestions/first_login.php'); # path
        }else {
            header('Location: ../suggestions/dashboard.php'); # path
        }
         exit ;
    }
}