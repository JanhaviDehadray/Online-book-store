<?php

session_start();

//start session if admin is logged in
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {

    include "../connection/db_connection.php";

    include "../connection/author.php";
    $authors = get_all_author($conn);

    // include "../connection/book.php";
    // $books = get_all_books($conn);

    include "../connection/category.php";
    $categories = get_all_categories($conn);

    if(isset($_GET['title'])){
        $title = $_GET['title'];
    }else{
        $title = '';
    }

    if(isset($_GET['desc'])){
        $desc = $_GET['desc'];
    }else{
        $desc = '';
    }

    if(isset($_GET['category_id'])){
        $category_id = $_GET['category_id'];
    }else{
        $category_id = 0;
    }

    if(isset($_GET['author_id'])){
        $author_id = $_GET['author_id'];
    }else{
        $author_id = 0;
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


        <form action="../connection/add-book.php" method="post" enctype="multipart/form-data" class="shadow p-4 rounded mt-5" style="width: 90%; max-width: 50rem;margin-left:30%">

            <h1 class="text-center pb-5 display-4 fs-3">
                Add New Book
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
                    Book Title
                </label>
                <input type="text" class="form-control" value="<?=$title?>" name="book_title">
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Book Description
                </label>
                <input type="text" class="form-control" value="<?=$desc?>" name="book_description">
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Book Author
                </label>
                <select name="book_author" class="form-control">
                    <option value="0">
                        Select author
                    </option>
                    <?php
                    if ($authors == 0) {
                    } else {
                        foreach ($authors as $author) {
                            if($author_id == $author['id'] ){
                    ?>
                            <option selected value="<?= $author['id'] ?>">
                                <?= $author['name'] ?>
                            </option>
                    <?php }else{ ?>
                        
                    <option value="<?= $author['id'] ?>">
                    <?= $author['name'] ?>
                    </option>

                    <?php
                    }
                    } 
                    
                }?>

                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Book Category
                </label>
                <select name="book_category" class="form-control">
                    <option value="0">
                        Select category
                    </option>
                    <?php
                    if ($categories == 0) {
                    } else {
                        foreach ($categories as $category) {
                            if($category_id == $category['id'] ){
                    ?>
                            <option selected value="<?= $category['id'] ?>">
                                <?= $category['name'] ?>
                            </option>
                    <?php }else{ ?>
                        
                    <option value="<?= $category['id'] ?>">
                    <?= $category['name'] ?>
                    </option>

                    <?php
                    }
                    } 
                    
                }?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Book Cover
                </label>
                <input type="file" class="form-control" name="book_cover">
            </div>

            <div class="mb-3">
                <label class="form-label">
                    File
                </label>
                <input type="file" class="form-control" name="file">
            </div>

            <button type="submit" class="btn btn-primary">
                Add Book</button>
        </form>

    </body>

    </html>
<?php
} else {
    header("Location: login.php");
    exit;
}
?>