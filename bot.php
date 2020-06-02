<?php
/**
 * Created by PhpStorm.
 * User: m0pfin
 * Date: 02.06.2020
 * Time: 08:38
 */

require 'functions.php';
require 'includes/connect.php';
require __DIR__ . '/vendor/autoload.php';

    use Telegram\Bot\Api;

    $telegram = new Api('API_KEY_BOT'); //Устанавливаем токен, полученный у BotFather
    $result = $telegram -> getWebhookUpdates(); //Передаем в переменную $result полную информацию о сообщении пользователя

    $text = $result["message"]["text"]; //Текст сообщения
    $chat_id = $result["message"]["chat"]["id"]; //Уникальный идентификатор пользователя
    $name = $result["message"]["from"]["username"]; //Юзернейм пользователя
    $keyboard = [["Баланс"],["Последние операции"],["Тотал сегодня","Тотал 7 дней"]]; //Клавиатура

    $myrow = $db->query("SELECT * FROM users WHERE role= '" . $chat_id . "'");// Ищем такой Chat ID

    if($text){


        if ($text == "/start") {
            $reply = "Ваш Chat ID: " . $chat_id;
            $reply_markup = $telegram->replyKeyboardMarkup([ 'keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false ]);
            $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply]);

            //Проверяем есть ли такой Chat_ID в БД
            $chatCount = $db->countWhere('users','role', $chat_id);

            if ($chatCount != 0) {
                $chat_id = $myrow[0]['role'];
                $reply = "Вы успешно авторизованы: " . $name;
                $reply_markup = $telegram->replyKeyboardMarkup([ 'keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false ]);
                $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup ]);
               }

        }elseif ($text == "Баланс") {
            //Проверяем есть ли такой Chat_ID в БД
            $chatCount = $db->countWhere('users','role', $chat_id);

            if ($chatCount != 0) {
                $chat_id = $myrow[0]['role'];

                $id = $db->query("SELECT * FROM `qiwi`  ORDER BY id DESC"); // получаем список всех кошельков

                foreach ($id as $qiwi_id) {
                    $qid =  $qiwi_id['id'];
                    $phone =  $qiwi_id['phone'];
                    $res .= $phone .' - '. getBalance($db,$curl,$qid)."\n";
                }


                $reply = "<b>Баланс</b> \n". $res;
                $telegram->sendMessage([ 'chat_id' => $chat_id, 'parse_mode' => 'HTML', 'text' => $reply ]);
            }
        }elseif ($text == "Последние операции") {
            //Проверяем есть ли такой Chat_ID в БД
            $chatCount = $db->countWhere('users','role', $chat_id);

            if ($chatCount != 0) {
                $chat_id = $myrow[0]['role'];

                $id = $db->query("SELECT * FROM `qiwi`  ORDER BY id DESC"); // получаем список всех кошельков

                foreach ($id as $qiwi_id) {
                    $qid =  $qiwi_id['id'];
                    $res .= getLastOperation($db,$curl,$qid);
                }

                $reply = "<b>Последние операции</b> \n". $res;
                $telegram->sendMessage([ 'chat_id' => $chat_id, 'parse_mode' => 'HTML', 'disable_web_page_preview' => true, 'text' => $reply ]);
            }
        }elseif ($text == "Тотал сегодня") {
            //Проверяем есть ли такой Chat_ID в БД
            $chatCount = $db->countWhere('users','role', $chat_id);

            if ($chatCount != 0) {
                $chat_id = $myrow[0]['role'];

                $id = $db->query("SELECT * FROM `qiwi`  ORDER BY id DESC"); // получаем список всех кошельков

                foreach ($id as $qiwi_id) {
                    $qid =  $qiwi_id['id'];
                    $res .= getTotalCostToday($db,$curl,$qid);
                }

                $reply = "<b>Тотал сегодня</b> \n". $res;
                $telegram->sendMessage([ 'chat_id' => $chat_id, 'parse_mode' => 'HTML', 'text' => $reply ]);
            }
        }elseif ($text == "Тотал 7 дней") {
            //Проверяем есть ли такой Chat_ID в БД
            $chatCount = $db->countWhere('users','role', $chat_id);

            if ($chatCount != 0) {
                $chat_id = $myrow[0]['role'];

                $id = $db->query("SELECT * FROM `qiwi`  ORDER BY id DESC"); // получаем список всех кошельков

                foreach ($id as $qiwi_id) {
                    $qid =  $qiwi_id['id'];
                    $res .= getTotalCost7days($db,$curl,$qid);
                }

                $reply = "<b>Тотал 7 дней</b> \n". $res;


                $telegram->sendMessage([ 'chat_id' => $chat_id, 'parse_mode' => 'HTML', 'text' => $reply ]);
            }
        }else{
            $reply = "По запросу \"<b>".$text."</b>\" ничего не найдено.";
            $telegram->sendMessage([ 'chat_id' => $chat_id, 'parse_mode'=> 'HTML', 'text' => $reply ]);
        }
    }else{
        $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => "Отправьте текстовое сообщение." ]);
    }
?>