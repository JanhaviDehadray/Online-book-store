<?php
session_start();

include "./db_connection.php";
include "./validation.php";
include "./file-upload.php";

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {

    // check if category name is filled
    if (isset($_POST['book_id']) && isset($_POST['book_title']) && isset($_POST['book_description']) && isset($_POST['book_author']) && isset($_POST['book_category']) && isset($_FILES['book_cover']) && isset($_FILES['file']) && isset($_POST['current_cover']) && isset($_POST['current_file'])) {

        $id          = $_POST['book_id'];
		$title       = $_POST['book_title'];
		$description = $_POST['book_description'];
		$author      = $_POST['book_author'];
		$category    = $_POST['book_category'];


        $text = "Book title";
        $location = "../php/edit-book.php";
        $ms = "id=$id&error";
		is_empty($title, $text, $location, $ms, "");

		$text = "Book description";
        $location = "../php/edit-book.php";
        $ms = "id=$id&error";
		is_empty($description, $text, $location, $ms, "");

		$text = "Book author";
        $location = "../php/edit-book.php";
        $ms = "id=$id&error";
		is_empty($author, $text, $location, $ms, "");

		$text = "Book category";
        $location = "../php/edit-book.php";
        $ms = "id=$id&error";
		is_empty($category, $text, $location, $ms, "");




        if (!empty($_FILES['book_cover']['name'])) {
            
          if (!empty($_FILES['file']['name'])) {
              # update both here

              # book cover Uploading
            $allowed_image_exs = array("jpg", "jpeg", "png");
            $path = "cover";
            $book_cover = upload_files($_FILES['book_cover'], $allowed_image_exs, $path);

            # book cover Uploading
            $allowed_file_exs = array("pdf", "docx", "pptx");
            $path = "files";
            $file = upload_files($_FILES['file'], $allowed_file_exs, $path);
            

            if ($book_cover['status'] == "error" || 
                $file['status'] == "error") {

                $em = $book_cover['data'];

                
                header("Location: ../php/edit-book.php?error=$em&id=$id");
                exit;
            }else {
              # current book cover path
              $c_p_book_cover = "../uploads/cover/$current_cover";

              # current file path
              $c_p_file = "../uploads/files/$current_file";

              # Delete from the server
              unlink($c_p_book_cover);
              unlink($c_p_file);

              
               $file_URL = $file['data'];
               $book_cover_URL = $book_cover['data'];

                # update just the data
                  $sql = "UPDATE books
                          SET title=?,
                              author_id=?,
                              description=?,
                              category_id=?,
                              cover=?,
                              file=?
                          WHERE id=?";
                  $stmt = $conn->prepare($sql);
                $res  = $stmt->execute([$title, $author, $description, $category,$book_cover_URL, $file_URL, $id]);

                
                 if ($res) {
                     # success message
                     $sm = "Successfully updated!";
                    header("Location: ../php/edit-book.php?success=$sm&id=$id");
                    exit;
                 }else{
                     # Error message
                     $em = "Unknown Error Occurred!";
                    header("Location: ../php/edit-book.php?error=$em&id=$id");
                    exit;
                 }


            }
          }else {
              # update just the book cover

              # book cover Uploading
            $allowed_image_exs = array("jpg", "jpeg", "png");
            $path = "cover";
            $book_cover = upload_files($_FILES['book_cover'], $allowed_image_exs, $path);
            
            
            if ($book_cover['status'] == "error") {

                $em = $book_cover['data'];

                
                header("Location: ../php/edit-book.php?error=$em&id=$id");
                exit;
            }else {
              # current book cover path
              $c_p_book_cover = "../php/uploads/cover/$current_cover";

              # Delete from the server
              unlink($c_p_book_cover);

              
               $book_cover_URL = $book_cover['data'];

                # update just the data
                  $sql = "UPDATE books
                          SET title=?,
                              author_id=?,
                              description=?,
                              category_id=?,
                              cover=?
                          WHERE id=?";
                  $stmt = $conn->prepare($sql);
                $res  = $stmt->execute([$title, $author, $description, $category,$book_cover_URL, $id]);

               
                 if ($res) {
                     # success message
                     $sm = "Successfully updated!";
                    header("Location: ../php/edit-book.php?success=$sm&id=$id");
                    exit;
                 }else{
                     # Error message
                     $em = "Unknown Error Occurred!";
                    header("Location: ../php/edit-book.php?error=$em&id=$id");
                    exit;
                 }


            }
          }
      }
      
      else if(!empty($_FILES['file']['name'])){
          # update just the file
        
        # book cover Uploading
        $allowed_file_exs = array("pdf", "docx", "pptx");
        $path = "files";
        $file = upload_files($_FILES['file'], $allowed_file_exs, $path);
        
       
        if ($file['status'] == "error") {

            $em = $file['data'];

            
            header("Location: ../php/edit-book.php?error=$em&id=$id");
            exit;
        }else {
          # current book cover path
          $c_p_file = "../uploads/files/$current_file";

          # Delete from the server
          unlink($c_p_file);

          
           $file_URL = $file['data'];

            # update just the data
              $sql = "UPDATE books
                      SET title=?,
                          author_id=?,
                          description=?,
                          category_id=?,
                          file=?
                      WHERE id=?";
              $stmt = $conn->prepare($sql);
            $res  = $stmt->execute([$title, $author, $description, $category, $file_URL, $id]);

           
             if ($res) {
                 # success message
                 $sm = "Successfully updated!";
                header("Location: ../php/edit-book.php?success=$sm&id=$id");
                exit;
             }else{
                 # Error message
                 $em = "Unknown Error Occurred!";
                header("Location: ../php/edit-book.php?error=$em&id=$id");
                exit;
             }


        }
      
      }else {
          # update just the data
          $sql = "UPDATE books
                  SET title=?,
                      author_id=?,
                      description=?,
                      category_id=?
                  WHERE id=?";
          $stmt = $conn->prepare($sql);
        $res  = $stmt->execute([$title, $author, $description, $category, $id]);

        
         if ($res) {
             # success message
             $sm = "Successfully updated!";
            header("Location: ../php/edit-book.php?success=$sm&id=$id");
            exit;
         }else{
             # Error message
             $em = "Unknown Error Occurred!";
            header("Location: ../php/edit-book.php?error=$em&id=$id");
            exit;
         }
      } 



        

    }else{
        header("Location: ../php/admin.php");
    exit;
    }
    


} else {
    header("Location: login.php");
    exit;
}
