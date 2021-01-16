<?php
// Initialize the session
session_start();

require_once "init.php";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$username = $_SESSION["id"];
//prepare all posts
$postQuery = $db->prepare("
  SELECT id, user_id, title, video, score, date
  FROM videos
");

$postQuery->execute([
    
]);

$posts = $postQuery->rowCount() ? $postQuery : [];

// To get User-specific posts
$userQuery = $db->prepare("
    SELECT id, user_id, title, video, score, date
    FROM videos
    WHERE user_id = :username
");

$userQuery->execute([
    'username' => $username
]);

$users = $userQuery->rowCount() ? $userQuery : [];

?>
 
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Form Forum Home</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">

  <!-- Bootstrap core CSS -->
  <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->

  <!-- Custom styles for this template -->
  <link href="css/blog-home.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: lightblue;">
    <div class="container">
      <img class="card-img-top" src="form.png" style="height: 50px; width: 170px;" alt="Card image cap">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="main.php" style="padding-right: 30px;">Home 
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
          <a href="logout.php" class="btn btn-danger">Sign Out</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  
  <div class="container">

    <div class="row">

      <!-- Blog Entries Column -->
      <div class="col-md-8">
        <h1 class="my-4">Welcome to Form Forum!
        </h1>

        <?php foreach($posts as $post): ?>
          <!-- Blog Post -->
          <div class="card mb-4">
            <img class="card-img-top" src="http://placehold.it/750x300" alt="Card image cap">
            <div class="card-body">
              <h2 class="card-title"><?php echo $item['title']; ?></h2>
              <a href="#" class="btn btn-primary">Read More &rarr;</a>
            </div>
            <div class="card-footer text-muted">
              Posted on <?php echo $item['date']; ?> by <?php echo $item['user_id']; ?>
            </div>
          </div>
        <?php endforeach; ?>

        <!-- Pagination -->
        <ul class="pagination justify-content-center mb-4">
          <li class="page-item">
            <a class="page-link" href="#">&larr; Older</a>
          </li>
          <li class="page-item disabled">
            <a class="page-link" href="#">Newer &rarr;</a>
          </li>
        </ul>

      </div>

      <!-- Sidebar Widgets Column -->
      <div class="col-md-4">

        <!-- Search Widget -->
        <div class="card my-4">
          <h5 class="card-header">Search</h5>
          <div class="card-body">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search for...">
              <span class="input-group-append">
                <button class="btn btn-secondary" type="button">Go!</button>
              </span>
            </div>
          </div>
        </div>

        <!-- Side Widget -->
        <div class="card my-4">
          <h5 class="card-header">Profile</h5>
          <div class="card-body">
            <img class="card-img-top" src="http://placehold.it/180x180" alt="Card image cap" 
            style="padding-bottom: 20px; border-radius:50%;">
            <h1><?php htmlspecialchars($_SESSION["id"]); ?></h1>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add Post</button>
          </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Create New Post</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="container">
          <form [formGroup]="addPostForm">
            <div class="form-group">
              <label class="post-title">Title</label>
              <input type="text" [formControlName]="'title'" class="form-control" placeholder="Title">
            </div>
            <div class="form-group">
              <a href="main.php" class="btn btn-primary" data-dismiss="modal">Submit</a>
              <a class="btn btn-primary">Add Video</a>
        </div>
      </form >
    </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>



      </div>

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; Your Website 2020</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</body>

</html>
