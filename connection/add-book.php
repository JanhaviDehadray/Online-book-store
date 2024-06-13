<?php
session_start();

include "./db_connection.php";

include "./validation.php";

include "./file-upload.php";

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {

    // check if all fields are field
    if (isset($_POST['book_title']) && isset($_POST['book_description']) && isset($_POST['book_author']) && isset($_POST['book_category']) && isset($_FILES['book_cover']) && isset($_FILES['file'])) {

        $title = $_POST['book_title'];
        $description = $_POST['book_description'];
        $author = $_POST['book_author'];
        $category = $_POST['book_category'];

        // making url data format
        $user_input = 'title = '.$title.'&category_id = '.$category.'&desc = '.$description.'&author_id='.$author;

        // validation
        $text = "Book Title";
        $location = "../php/add-book.php";
        $ms = "error";
        is_empty($title,$text,$location,$ms,$user_input);

        // validation
        $text = "Book Description";
        $location = "../php/add-book.php";
        $ms = "error";
        is_empty($description,$text,$location,$ms,$user_input);

        // validation
        $text = "Book Author";
        $location = "../php/add-book.php";
        $ms = "error";
        is_empty($author,$text,$location,$ms,$user_input);

        // validation
        $text = "Book Category";
        $location = "../php/add-book.php";
        $ms = "error";
        is_empty($category,$text,$location,$ms,$user_input);

        //book cover upload
        $allowed_image_exs = array("jpg","jpeg","png");
        $path = "cover";
        $book_cover = upload_files($_FILES['book_cover'],$allowed_image_exs,$path);

        if ($book_cover['status'] == "error") {
            $em = $book_cover['data'];
            header("Location: ../php/add-book.php?error=$em&$user_input");
            exit;
        }else{

            //file upload
        $allowed_file_exs = array("pdf","docx","pptx");
        $path = "files";
        $file = upload_files($_FILES['file'],$allowed_file_exs,$path);

        if ($file['status'] == "error") {
            $em = $file['data'];
            header("Location: ../php/add-book.php?error=$em&$user_input");
            exit;
        }else{
            
            $file_URL = $file['data'];
            $book_cover_URL = $book_cover['data'];

            $sql = "INSERT INTO books (title,author_id,description,category_id,cover,file) VALUES(? , ? , ? , ? , ? , ?) ";
            $stmt = $conn -> prepare($sql);
            $res = $stmt -> execute([$title,$author,$description,$category,$book_cover_URL,$file_URL]);

            if($res){
                $sm = "Book added successfully!!";
            header("Location: ../php/add-book.php?success=$sm");
            exit;
            }else{
                $em = "Some error occured!!";
            header("Location: ../php/add-book.php?error=$em");
            exit;
            }
            
        }

        }



    }else{
        header("Location: ../admin.php");
    exit;
    }
    


} else {
    header("Location: login.php");
    exit;
}

