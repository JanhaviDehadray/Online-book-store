<?php
session_start();

include "./db_connection.php";

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {

    // check if category name is filled
    if (isset($_GET['id'])) {

        $id = $_GET['id'];

        if (empty($id)) {
            $em = "error occured";
            header("Location: ../php/admin.php?error=$em");
            exit;
        }else{

            
                $sql = "DELETE FROM categories WHERE id = ?";
                $stmt = $conn -> prepare($sql);
                $res = $stmt -> execute([$id]);

            if($res){

                $sm = "Category removed successfully!!";
                header("Location: ../php/admin.php?success=$sm");
                exit;
            }else{
                $em = "error occured";
                header("Location: ../php/admin.php?error=$em");
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

