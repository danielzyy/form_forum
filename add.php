<?php

require_once 'init.php';
//Comment Button 
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
header('Location: main.php');