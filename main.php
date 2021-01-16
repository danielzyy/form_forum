<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>

<body>
    <div class="page-header">
        <h1>Hi, <?php echo htmlspecialchars($_SESSION["username"]); ?>! Welcome Form Forum, the front page of fitness.</h1>
        <h2>You have a Form Score of: <?php echo $_SESSION["score"]?>.</h2>
    </div>
    <p>
        <a href="logout.php" class="btn btn-danger">Sign Out</a>
    </p>
</body>
</html>