<?php
session_start();

include "./db_connection.php";

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {

    // check if category name is filled
    if (isset($_POST['category_name']) && isset($_POST['category_id']) ) {

        $name = $_POST['category_name'];
        $id = $_POST['category_id'];

        if (empty($name)) {
            $em = "The category name is required";
            header("Location: ../php/edit-category.php?error=$em&id=$id");
            exit;
        }else{

            $sql = "UPDATE categories SET name = ? WHERE id = ?";
            $stmt = $conn -> prepare($sql);
            $res = $stmt -> execute([$name, $id]);

            if($res){
                $sm = "Category updated successfully!!";
            header("Location: ../php/edit-category.php?success=$sm&id=$id");
            exit;
            }else{
                $em = "Some error occured!!";
            header("Location: ../php/edit-category.php?error=$em&id=$id");
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

