<?php
// Initialize the session
session_start();

require_once "init.php";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$search = $_SESSION["search"];
$username = $_SESSION["username"];

//Submit Button
if (isset($_POST["submit"])){
  $_SESSION["search"] = trim($_POST["search"]);
  $search = $_SESSION["search"];
}
//prepare all posts
$postQuery = $db->prepare("
  SELECT id, username, title, video, score, date
  FROM videos
  ORDER BY id DESC
");

$postQuery->execute([
]);

$posts = $postQuery->rowCount() ? $postQuery : [];

//Search posts
$searchQuery = $db->prepare("
  SELECT id, username, title, video, score, date
  FROM videos
  WHERE title = :search
  ");

$searchQuery->execute([
    'search' => $search
]);

$searchs = $searchQuery->rowCount() ? $searchQuery : [];
// To get User-specific posts
$userQuery = $db->prepare("
    SELECT id, username, title, video, score, date
    FROM videos
    WHERE username = :username
");

$userQuery->execute([
    'username' => $username
]);

$users = $userQuery->rowCount() ? $userQuery : [];

//To search for post
$searchQuery = $db->prepare("
      SELECT *
      FROM videos
      WHERE title = :search
  ");

  $searchQuery->execute([
      'search' => $search
  ]);

  $searchs = $searchQuery->rowCount() ? $searchQuery : [];
if($_SERVER["REQUEST_METHOD"] == "POST"){
  if (!empty($_POST["search"])){
    $search = $_POST["search"];
    print "hellfl";
    header("location: login.php");
  }
  
}






//$fetchVideos=mysqli_query($connection, "SELECT * FROM videos ORDER BY id DESC");
//while($row=mysqli_fetch_assoc($fetchVideos)){
	//$location=$row['location'];
	//$name=$row['name'];
// 	echo "<div style='float:left; margin-right:5px;'>
// 		<video src='".$location."' controls width='320px' height='320px'></video>
// 		<br>
// 		<span>".$name."</span>
// 	</div>";
// }



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

        <?php if($search==""): ?>
          <?php foreach($posts as $post): ?>
            <!-- Blog Post -->
            <div class="card mb-4">
            <video src= "<?php echo $post['video']; ?>" controls width='100%' height='300px'></video>
              <div class="card-body">
                <h2 class="card-title"><?php echo $post['title']; ?></h2>
                <p class="card-title">Form Rating: <?php echo $post['score']; ?></p>
                <a href="#" class="btn btn-primary">+1</a>
                <a href="#" class="btn btn-primary">-1</a>
                <div class="card-footer text-muted">
                  Posted on <?php echo substr($post['date'],0,10); ?> by <?php echo $post['username']; ?>
                </div>
              </div>
            <?php endforeach; ?>
            <?php else: ?>
              <?php if(!empty($searchs)): ?>
              <?php foreach($searchs as $post): ?>
            <!-- Blog Post -->
              <div class="card mb-4">
                <img class="card-img-top" src="http://placehold.it/750x300" alt="Card image cap">
                <div class="card-body">
                <div class="line">
                <a href="#" class="btn btn-primary">+1</a>
                  <h2 class="card-title"><?php echo $post['title']; ?></h2>
                </div>
                <div class="line">
                <a href="#" class="btn btn-primary">-1</a>
                  <p class="card-title">Form Rating: <?php echo $post['score']; ?></p>
                </div>
                </div>
                <div class="card-footer text-muted">
                  Posted on <?php echo substr($post['date'],0,10); ?> by <?php echo $post['username']; ?>
                </div>
              </div>
            <?php endforeach; ?>
            <?php else: ?>
              <?php echo "No videos found." ?>
            <?php endif; ?>
            <?php endif; ?>
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
          <form method ="post">      
              <input type="text" name="search" class="form-control" style="padding-bottom=5px;" placeholder="Search for...">
              <input type="submit" name="submit" class="btn btn-secondary" value="Go!">
            </form>
          </div>
        </div>

        <!-- Php code to search -->
        <?php
        
        ?>

        <!-- Side Widget -->
        <div class="card my-4">
          <h5 class="card-header">Profile</h5>
          <div class="card-body">
            <img class="card-img-top" src="http://placehold.it/180x180" alt="Card image cap" 
            style="padding-bottom: 20px; border-radius:50%;">
            <h1><?php echo $_SESSION["username"] ?></h1>
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
          <form [formGroup]="addPostForm" method="post" action="" enctype='multipart/form-data'>
            <div class="form-group">
				<input type='file' name='file' />
				<input type='submit' value='Upload' name='vid_upload'>
                <form method="post">
                <input type="text" name="title" class="form-control" placeholder="Title">
                </form>
                <?php
                    @$title = $_POST["title"];

                    if(isset($_POST['vid_upload'])){
                        $maxsize=262144000;//250 mb
                        if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != ''){
                            $name = $_FILES['file']['name'];
                            $target_dir = "videos/";
                            $target_file = $target_dir . $_FILES["file"]["name"];
                            
                            $extension=strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                            $extensions_arr=array("mp4","avi","flv","wmv","mov", "mpeg");
                            
                            if(in_array($extension,$extensions_arr)){
                                
                                if(($_FILES['file']['size']>=$maxsize) || ($_FILES["file"]["size"]==0)){
                                    $_SESSION['message']= "File is larger than 250 mb.";
                            }else{
                                if(move_uploaded_file($_FILES['file']['tmp_name'],$target_file)){
                                    $query=$db->prepare("INSERT INTO videos(username,title,video,score, date) VALUES('".$username."','".$title."','".$target_file."',0,NOW())");
                                    
                                    $query->execute([
                                    'username' => $username,
                                    'title' => $title
                                    ]);
                                    $_SESSION['message']="Uploaded Successfully.";
                                }
                            }
                        
                        }else{
                            $_SESSION['message']="Invalid file extension.";
                        }
                    }else{
                        $_SESSION['message']="Please select a file.";
                    }
                        
                    exit;
                    }
                ?>

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
