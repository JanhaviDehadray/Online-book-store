<?php
session_start();
if (isset($_POST['email']) && isset($_POST['password'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    // db connection file
    include "db_connection.php";

    //validation function
    include "validation.php";

    // form validation
    $text = "Email";
    $location = "../php/login.php";
    $ms = "error";
    is_empty($email,$text,$location,$ms," ");

    $text = "Password";
    $location = "../php/login.php";
    $ms = "error";
    is_empty($password,$text,$location,$ms," ");

    // search the email
    $sql = "SELECT * FROM admin WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);

    // if email exists
    if ($stmt->rowCount()===1) {
        $user = $stmt->fetch();

        $user_id = $user['id'];
        $user_email = $user['email'];
        $user_password = $user['password'];

        if ($email === $user_email) {
           if (password_verify($password,$user_password)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_email'] = $user_email;
            header("Location: ../php/admin.php");
           }else {
            $em = "Incorrect username or password";
            header("Location: ../php/login.php?error=$em");
           }
        }else {
            $em = "Incorrect username or password";
            header("Location: ../php/login.php?error=$em");
        }

    }else {
        $em = "Incorrect username or password";
        header("Location: ../php/login.php?error=$em");
    }

}else {
    header("Location: ../php/login.php");
}
