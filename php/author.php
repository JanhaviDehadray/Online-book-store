<?php
session_start();



if(!isset($_GET['id'])){
    header("Location: books.php");
    exit;
}

$id = $_GET['id'];


include "../connection/db_connection.php";

include "../connection/author.php";
$authors = get_all_author($conn);
$current_author = get_author($conn,$id);

include "../connection/book.php";
$books = get_books_by_author($conn, $id);

include "../connection/category.php";
$categories = get_all_categories($conn);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/books.css">
    <link rel="stylesheet" href="../css/index.css">

    <!-- bootstrap 5 cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- bootstrap 5 js bundle cdn -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- PDF.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>

</head>

<body>


    <!-- Header section -->

    <header>
        <div class="header1">
            <a href="" class="logo"><img src="../images/logo.png" alt="" width="100px" height="70px"></a>
            <nav class="navbar">
                <a href="index.php">Home</a>
                <a href="books.php">Books</a>
                <a href="about.php">About</a>
                <a href="suggestion.php">Suggestion</a>


            </nav>

            <div class="icons">
                <!-- <div id="login-btn" class="fas fa-user"></div> -->
                <!-- <a href="#login">Login</a> -->
                <h3>Book Hunt</h3>
            </div>
        </div>
    </header>

    <!-- Header section -->
   
    <h1 class="display-4 p-3 fs-3">
        <a href="./books.php">
            <img src="../images/back-arrow.PNG" alt="" width="35px">
        </a>
        <?=$current_author['name'] ?>
    </h1>

    <div class="d-flex pt-3">
			<?php if ($books == 0){ ?>
				<div class="alert alert-warning 
        	            text-center p-5 pdf-list" 
        	     role="alert">
        	     <img src="../images/empty.png" 
        	          width="100">
        	     <br>
				  There is no book in the database
			  </div>
			<?php }else{ ?>
			<div class="pdf-list d-flex flex-wrap">
				<?php foreach ($books as $book) { ?>
				<div class="card m-1">
					<img src="../uploads/cover/<?=$book['cover'] ?>"
					     class="card-img-top" style="height: 26rem;">
					<div class="card-body">
						<h5 class="card-title">
							<?=$book['title']?>
						</h5>
						<p class="card-text">
                        <i style="color: red;"><b>By: <?php foreach($authors as $author){ 
                            if ($author['id'] == $book['author_id']) {
                                echo $author['name'];
                                break;
                            }
                            ?>
                        <?php } ?>
                        <br></b></i>    
                        <?=$book['description'] ?></p>
                        <i style="color: red;"><b>Category: <?php foreach($categories as $category){ 
                            if ($category['id'] == $book['category_id']) {
                                echo $category['name'];
                                break;
                            }
                            ?>
                        <?php } ?>
                        <br></b></i><br>   
                        <a href="../uploads/files/<?=$book['file'] ?>#toolbar=0" class="btn btn-success">Open</a>

                        
					</div>
				</div>
				<?php } ?>
			</div>
		<?php } ?>

        <div class="category">
			<!-- List of categories -->
			<div class="list-group">
				<?php if ($categories == 0){
					// do nothing
				}else{ ?>
				<a href="#"
				   class="list-group-item list-group-item-action active">Category</a>
				   <?php foreach ($categories as $category ) {?>
				  
				   <a href="category.php?id=<?=$category['id']?>"
				      class="list-group-item list-group-item-action">
				      <?=$category['name']?></a>
				<?php } } ?>
			</div>


            <div class="list-group mt-5">
				<?php if ($authors == 0){
					// do nothing
				}else{ ?>
				<a href="#"
				   class="list-group-item list-group-item-action active">Author</a>
				   <?php foreach ($authors as $author ) {?>
				  
				   <a href="author.php?id=<?=$author['id']?>"
				      class="list-group-item list-group-item-action">
				      <?=$author['name']?></a>
				<?php } } ?>
			</div>

		</div>
	</div>
</body>

</html>