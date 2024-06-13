<?php
session_start();

include "./db_connection.php";

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {

    // check if category name is filled
    if (isset($_POST['author_name']) && isset($_POST['author_id']) ) {

        $name = $_POST['author_name'];
        $id = $_POST['author_id'];

        if (empty($name)) {
            $em = "The author name is required";
            header("Location: ../php/edit-author.php?error=$em&id=$id");
            exit;
        }else{

            $sql = "UPDATE author SET name = ? WHERE id = ?";
            $stmt = $conn -> prepare($sql);
            $res = $stmt -> execute([$name, $id]);

            if($res){
                $sm = "Author updated successfully!!";
            header("Location: ../php/edit-author.php?success=$sm&id=$id");
            exit;
            }else{
                $em = "Some error occured!!";
            header("Location: ../php/edit-author.php?error=$em&id=$id");
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

