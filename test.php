<?php
/**
* Created by PhpStorm.
* User: m0pfin
* Date: 02.06.2020
* Time: 04:04
*/


ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require 'functions.php';
require 'includes/connect.php';
//
//$id = $db->query("SELECT * FROM `qiwi`  ORDER BY id DESC");
//
//foreach ($id as $qiwi_id) {
//
//        $qid =  $qiwi_id['id'];
//        //echo $qiwi_id['id'] . "<br>";
//        $result .= '<br>' . getLastOperation($db,$curl,$qid);
//
//}
//
//echo $result;

//echo $todayStart." ".$todayEnd;

$chat_id = '252602113';
$myrow = $db->query("SELECT * FROM users WHERE role= '" . $chat_id . "'");
//$myrow = mysqli_query($link, "SELECT * FROM users WHERE role= '" . $chat_id . "'"); // Ищем такой Chat ID

//var_dump($chat);

//
//$chatCount = $db->countWhere('users','role', $chat_id);
//
//if ($chatCount != 0) {
//    $chat_id = $myrow[0]['role'];
//    echo "Ваш Chat ID: " . $chat_id;
//}

$id = $db->query("SELECT * FROM `qiwi`  ORDER BY id DESC"); // получаем список всех кошельков

foreach ($id as $qiwi_id) {
    $qid =  $qiwi_id['id'];
    echo $qiwi_id['id'] . "<br>";
    $result .= '<br>' . getBalance($db,$curl,$qid);
}

echo $result;