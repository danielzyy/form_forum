<?php

require_once 'init.php';

if(isset($_GET['as'], $_GET['item'], $_GET['username'])) {
    $as = $_GET['as'];
    $item = $_GET['item'];
    $username = $_GET['username'];
    switch($as) {
        case 'increase':
            $increaseVideoQuery = $db->prepare("
                UPDATE videos
                SET score = score+1
                WHERE id = :id
            ");

            $increaseVideoQuery->execute([
                'id' => $item
            ]);

            $increaseUserQuery = $db->prepare("
                UPDATE users
                SET score = score+1
                WHERE username = :username
            ");

            $increaseUserQuery->execute([
                'username' => $username
            ]);
        break;
        case 'decrease':
            $decreaseVideoQuery = $db->prepare("
                UPDATE videos
                SET score = score-1
                WHERE id = :id
            ");

            $decreaseVideoQuery->execute([
                'id' => $item
            ]);
            
            $decreaseUserQuery = $db->prepare("
                UPDATE users
                SET score = score-1
                WHERE username = :username
            ");

            $decreaseUserQuery->execute([
                'username' => $username
            ]);
        break;
        // case 'delete':
        //     $deleteQuery = $db->prepare("
        //         DELETE FROM items
        //         WHERE id = :item
        //         AND user = :user
        //     ");

        //     $deleteQuery->execute([
        //         'item' => $item,
        //         'user' => $_SESSION['user_id']
        //     ]);
        // break;
    }
}

header('Location: main.php');