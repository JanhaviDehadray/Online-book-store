<?php  
session_start();

if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {
        if(!isset($_GET['id'])){
            header("Location: admin.php");
            exit;
        }
        $id = $_GET['id'];

        include "../connection/db_connection.php";
        include "../connection/category.php";
        $category = get_category($conn,$id);



        if($category == 0){
            header("Location: admin.php");
            exit;
        }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/index.css">
        <link rel="stylesheet" href="../css/admin.css">

        <!-- bootstrap 5 cdn -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <!-- bootstrap 5 js bundle cdn -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body>
     <!-- Header section -->

     <header>
            <div class="header1">
                <a href="admin.php" class="logo"><img src="../images/logo.png" alt="" width="100px" height="70px"></a>
                <nav class="navbar">
                <a href="add-book.php">Add book</a>
                    <a href="add-category.php">Add category</a>
                    <a href="add-author.php">Add author</a>
                    <a href="logout.php">Logout</a>

                </nav>

                <div class="icons">
                    <h3>Book Hunt</h3>
                </div>
            </div>
        </header>
        <form action="../connection/edit-category.php" method="post" class="shadow p-4 rounded mt-5" style="width: 90%; max-width: 50rem;margin-left:30%" > 
 
      <h1 class="text-center pb-5 display-4 fs-3"> 
       Edit Category 
      </h1> 
       
      <?php
            if (isset($_GET['error'])) {   //if the required field is filled or not
            ?>

                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($_GET['error']); ?>
                </div>

            <?php
            }
            ?>

            <?php
            if (isset($_GET['success'])) {   //if the required field is filled or not
            ?>

                <div class="alert alert-success" role="alert">
                    <?= htmlspecialchars($_GET['success']); ?>
                </div>

            <?php
            }
            ?>
         
      <div class="mb-3"> 
      <label class="form-label"> 
              Category Name 
             </label> 

      <input type="text"   
             value="<?=$category['id'] ?>"
             hidden
             name="category_id"> 

      <input type="text"  
             class="form-control"  
             value="<?=$category['name'] ?>"
             name="category_name"> 
  </div> 
 
     <button type="submit"  
             class="btn btn-primary"> 
             Update</button> 
     </form>
    
</body>
</html>
<?php }else{
  header("Location: login.php");
  exit;
} ?>