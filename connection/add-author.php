 <?php
session_start();

include "./db_connection.php";

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {

    // check if author name is filled
    if (isset($_POST['author_name'])) {

        $name = $_POST['author_name'];

        if (empty($name)) {
            $em = "The author name is required";
            header("Location: ../php/add-author.php?error=$em");
            exit;
        }else{
            $sql = "INSERT INTO author (name) VALUES (?)";
            $stmt = $conn -> prepare($sql);
            $res = $stmt -> execute([$name]);

            if($res){
                $sm = "Author added successfully!!";
            header("Location: ../php/add-author.php?success=$sm");
            exit;
            }else{
                $em = "Some error occured!!";
            header("Location: ../php/add-author.php?error=$em");
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

