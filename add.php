<?php

require_once 'init.php';
// if(isset($_POST['name'])) {
//     $addComment = trim($_POST['name']);
//     print "yeswwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww";
//     $name = trim($_POST['name']);

//     if(!empty($name)) {
//         $addedQuery = $db->prepare("
//         INSERT INTO comments(username, video, comment, date)
//         VALUES (:username, :video, :comment, NOW())
//         ");
//         $addedQuery->execute([
//             'username' => $_SESSION['username'],
//             'video' => $_SESSION['video'],
//             'comment' => $addComment
//         ]);
//     }
// }
//Comment Button 
if(isset($_POST['comment'])) {
    $addComment = trim($_POST['comment']);
  
    if(!empty($comment)) {
        $addCommentQuery = $db->prepare("
            INSERT INTO comments(username, video, comment, date)
            VALUES (:username, :video, :comment, NOW())
        ");
        $addCommentQuery->execute([
            'username' => $_SESSION['username'],
            'video' => $_SESSION['video'],
            'comment' => $addComment
            
        ]);
    }
  }
header('Location: main.php');