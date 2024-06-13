<?php
session_start();

include "./db_connection.php";

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {

    // check if category name is filled
    if (isset($_POST['category_name'])) {

        $name = $_POST['category_name'];

        if (empty($name)) {
            $em = "The category name is required";
            header("Location: ../php/add-category.php?error=$em");
            exit;
        }else{
            $sql = "INSERT INTO categories (name) VALUES (?)";
            $stmt = $conn -> prepare($sql);
            $res = $stmt -> execute([$name]);

            if($res){
                $sm = "Category added successfully!!";
            header("Location: ../php/add-category.php?success=$sm");
            exit;
            }else{
                $em = "Some error occured!!";
            header("Location: ../php/add-category.php?error=$em");
            exit;
            }
        }

    }else{
        header("Location: ../add-author.php");
    exit;
    }
    


} else {
    header("Location: login.php");
    exit;
}

