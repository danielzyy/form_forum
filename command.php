<?php

require_once 'init.php';

if(isset($_GET['as'], $_GET['item'])) {
    $as = $_GET['as'];
    $item = $_GET['item'];

    switch($as) {
        case 'increase':
            $increaseQuery = $db->prepare("
                UPDATE videos
                SET score = score+1
                WHERE id = :id
            ");

            $increaseQuery->execute([
                'id' => $item
            ]);
        break;
        case 'decrease':
            $decreaseQuery = $db->prepare("
                UPDATE videos
                SET score = score-1
                WHERE id = :id
            ");

            $decreaseQuery->execute([
                'id' => $item
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