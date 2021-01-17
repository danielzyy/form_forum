<?php
// Initialize the session
session_start();

require_once "init.php";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

$_SESSION["video"] = "videos/Ascent Wallk Boost OP Kill (2020.08.11).mp4";
$search = $_SESSION["search"];
$username = $_SESSION["username"];

//Submit Button
if (isset($_POST["submit"])){
  $_SESSION["search"] = trim($_POST["search"]);
  $search = $_SESSION["search"];
}

if(isset($_POST['comment'])) {
  $addComment = trim($_POST['comment']);

  if(!empty($addComment)) {
      $addCommentQuery = $db->prepare("
          INSERT INTO comments(username, video, comment, date)
          VALUES (:username, :video, :comment, NOW())
      ");
      $addCommentQuery->execute([
          'username' => $_SESSION["username"],
          'video' => $_SESSION["video"],
          'comment' => $addComment
      ]);
  }
}

//prepare all comments

$commentQuery = $db->prepare("
  SELECT *
  FROM comments
");

$commentQuery->execute([
  // 'video' => $_SESSION["video"]
]);

$comments = $commentQuery->rowCount() ? $commentQuery : [];

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

  //get User
  foreach ($db->query("SELECT id, username, password, score FROM users WHERE username = '".$username."'") as $row){
    $_SESSION["score"] = $row['score'];
  }
?>
 
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Form Forum Home</title>
  <link rel="stylesheet" href="css/blog-home.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/main.css">
  <!-- Bootstrap core CSS -->


</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" >
    <div class="container">
      <img class="card-img-top" src="form.png" style="height: 60px; width: 195px;" alt="Card image cap">
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
        <h1 class="my-4">Welcome to the Form Forum!
        </h1>
        <?php if($search==""): ?>
            <?php foreach($posts as $post): ?>
            <!-- Blog Post -->
            <div class="card mb-4">
              <video src= "<?php echo $post['video']; ?>" controls width='100%' height='300px'></video>
              <div class="card-body">
                <h2 class="card-title"><?php echo $post['title']; ?></h2>
                <p class="card-title">Form Rating: <?php echo $post['score']; ?></p>
                <a href="command.php?as=increase&item=<?php echo $post['id']."&username=".$post['username']; ?>" class="btn btn-danger">+1</a>
                <a href="command.php?as=decrease&item=<?php echo $post['id']."&username=".$post['username']; ?>" class="btn btn-primary">-1</a>
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal">Comments</button>
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Comments</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                      <ul class="items">
                      <?php foreach($comments as $comment): ?>
                          <li>
                            <span class="comment" ><?php echo $comment['comment']; ?></span>
                            <div class="text-muted">
                              <?php echo substr($post['date'],0,10); ?> - <?php echo $comment['username']; ?>
                            </div>
                          </li>
                      <?php endforeach; ?>
                      </ul>

                      <form class="form-group" method="post">
                        <input type="text" name="comment" class="form-control" autocomplete="off" placeholder="Add a Comment" required ><br>
                        <input type="submit" class="submit btn btn-primary" value="Add Comment">
                      </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
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
              <video src= "<?php echo $post['video']; ?>" controls width='100%' height='300px'></video>
              <div class="card-body">
                <h2 class="card-title"><?php echo $post['title']; ?></h2>
                <p class="card-title">Form Rating: <?php echo $post['score']; ?></p>
                <a href="command.php?as=increase&item=<?php echo $post['id']."&username=".$post['username']; ?>" class="btn btn-danger">+1</a>
                <a href="command.php?as=decrease&item=<?php echo $post['id']."&username=".$post['username']; ?>" class="btn btn-primary">-1</a>
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal">Comments</button>
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Comments</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                      <ul class="items">
                      <?php foreach($comments as $comment): ?>
                          <li>
                            <span class="comment" ><?php echo $comment['comment']; ?></span>
                            <div class="text-muted">
                              <?php echo substr($post['date'],0,10); ?> - <?php echo $comment['username']; ?>
                            </div>
                          </li>
                      <?php endforeach; ?>
                      </ul>

                      <form class="form-group" method="post">
                        <input type="text" name="comment" class="form-control" autocomplete="off" placeholder="Add a Comment" required ><br>
                        <input type="submit" class="submit btn btn-primary" value="Add Comment">
                      </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
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
              <input type="submit" name="submit" class="btn btn-secondary mt-2" value="Go!">
            </form>
          </div>
        </div>

        <!-- Side Widget -->
        <div class="card my-4">
          <h5 class="card-header">Profile</h5>
          <div class="card-body">
            <img class="card-img-top" src="img.png" alt="Card image cap" border-radius:50%;">
            <h1><?php echo $_SESSION["username"] ?></h1>
            <p>Account Form Rating: <?php echo $_SESSION["score"] ?></p>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#submit">Add Post</button>
          </div>
        </div>
        <div class="modal fade" id="submit" tabindex="-1" role="dialog" aria-labelledby="submitLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="submitLabel">Create New Post</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="container">
                
                <form [formGroup]="addPostForm" method="post" enctype='multipart/form-data'>
            <div class="form-group">
                  <input type='file' name='file' />
                  <form method="post">
                <input type="text" name="title" class="form-control mt-3" placeholder="Title">
                </form>
            <input type='submit' href="command.php?as=n" class="btn btn-secondary mt-2" data-toggle="modal" data-target="#submit" value='Upload' name='vid_upload'>
                <?php
                    @$title = $_POST["title"];

                    if(isset($_POST['vid_upload'])){
                        $maxsize=262144000;//250 mb
                        if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != '' && trim($title)!=''){
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
                            $_SESSION['message'] = "Invalid file/title name.";
                            echo $_SESSION['message'];
                        }
                    }else{
                        $_SESSION['message']="Please select a file.";
                    }
                    }
                ?>

            </div>
            <div class="form-group">
              <!-- <a href="main.php" type='submit' class="btn btn-secondary"value='Upload' name='vid_upload' data-dismiss="modal">Submit</a> -->
              
        </div>
      </form >
    </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
  <footer class="py-2 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">HTN 2020++ <3</p>
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
