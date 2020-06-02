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


require 'includes/db.php';
require __DIR__ . '/vendor/autoload.php';

use \Curl\Curl;
$curl = new Curl();


/**
 * Получаем баланс кошелька
 * @param $db - соединение с базой данных
 * @param $curl - передаем класс СГКД
 * @param $id - id нужного нам кошелька
 * @return string
 */

function getBalance ($db, $curl, $id){
    $qiwi = $db->query("SELECT * FROM `qiwi` WHERE id = '".$id."'");
    $curl->setHeader('Content-Type', 'application/json');
    $curl->setOpt(CURLOPT_HTTPHEADER , array('Authorization: Bearer '.$qiwi[0]['token'].''));
    $curl->get('https://edge.qiwi.com/funding-sources/v2/persons/'.$qiwi[0]['phone'].'/accounts');


    if ($curl->error) {
        echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n";
    } else {
        echo '<pre>';
        //var_dump($curl->response);
        $response = json_decode(json_encode($curl->response),true); // преобразование строки в формате json в ассоциативный массив
        $balance = $response['accounts'][0]['balance']['amount']; // получаем баланс
        return $balance;
    }
}

/**
 * Получаем последние 15 операций
 * @param $db - соединение с базой данных
 * @param $curl - передаем класс СГКД
 * @param $id - id нужного нам кошелька
 * @return string
 */

function getLastOperation($db,$curl,$id,$count=10){

    $qiwi = $db->query("SELECT * FROM `qiwi` WHERE id = '".$id."'");
    $curl->setHeader('Content-Type', 'application/json');
    $curl->setOpt(CURLOPT_HTTPHEADER , array('Authorization: Bearer '.$qiwi[0]['token'].''));
    $curl->get('https://edge.qiwi.com/payment-history/v2/persons/'.$qiwi[0]['phone'].'/payments?rows='.$count.'&operation='.$qiwi[0]['trans_type'].'');


    if ($curl->error) {
        echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n";
    } else {
            //var_dump($curl->response);
            $response = json_decode(json_encode($curl->response),true); // преобразование строки в формате json в ассоциативный массив
    //        $balance = $response['accounts'][0]['balance']['amount']; // получаем историю операций
    //        return 'Последние 10 операций: '.$balance;

            foreach ($response['data'] as $value) {

                $date = $value['date'];
                $status = $value['status'];
                $sum = $value['sum']['amount'];
                $comment = $value['comment'];
                $who = $value['account'];

                $resul .= "<b>Дата:</b> ".$date." \n<b>Статус:</b> ".$status." \n<b>Сумма:</b> ".$sum." \n<b>Куда:</b> ".$who." \n<b>Комментарий:</b> ".$comment." \n\n";
//
            }
        return $resul;
        }

}

/**
 * Получаем ТОТАЛ расход за сегодня кошелька/карты по дате
 * @param $db - соединение с базой данных
 * @param $curl - передаем класс СГКД
 * @param $id - id нужного нам кошелька
 * @return string
 */

function getTotalCostToday ($db, $curl, $id){

    //Формируем дату
    $todayStart = urlencode((new \DateTime(date("Y-m-d 00:00:00")))->format('c'));
    $todayEnd = urlencode((new \DateTime(date("Y-m-d 23:59:59")))->format('c'));



    $qiwi = $db->query("SELECT * FROM `qiwi` WHERE id = '".$id."'");
    $curl->setHeader('Content-Type', 'application/json');
    $curl->setOpt(CURLOPT_HTTPHEADER , array('Authorization: Bearer '.$qiwi[0]['token'].''));
    $curl->get('https://edge.qiwi.com/payment-history/v2/persons/'.$qiwi[0]['phone'].'/payments/total?startDate='.$todayStart.'&endDate='.$todayEnd.'&operation='.$qiwi[0]['trans_type'].'');


    if ($curl->error) {
        echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n";
    } else {

        /**
         * Если расход по кошельку
         */
        //var_dump($curl->response);
        //$response = json_decode(json_encode($curl->response),true); // преобразование строки в формате json в ассоциативный массив
        //$totalcost = $response['outgoingTotal'][0]['amount']; // получаем расход ТОТАЛ
        //return 'Расход: ' . $totalcost;

        /**
         * Если расход по картам
         */

        $response = json_decode(json_encode($curl->response),true); // преобразование строки в формате json в ассоциативный массив
        $totalcost = $response['outgoingTotal'][0]['amount']; // получаем расход ТОТАЛ
        if($totalcost == NULL){
            return 'Сегодня не было транзакций.';
        }
        return 'Расход: ' . $totalcost;
    }
}

/**
 * Получаем ТОТАЛ расход кошелька/карты за последние 7 дней
 * @param $db - соединение с базой данных
 * @param $curl - передаем класс СГКД
 * @param $id - id нужного нам кошелька
 * @return string
 */

function getTotalCost7days ($db, $curl, $id){

    //Формируем дату
    $todayStart = urlencode((new \DateTime(date("Y-m-d H:i:s")))->format('c'));
    $dateEnd = urlencode((new \DateTime(date("Y-m-d H:i:s", mktime(0, 0, 0, date('m'), date('d') - 7, date('Y')))))->format('c'));




    $qiwi = $db->query("SELECT * FROM `qiwi` WHERE id = '".$id."'");
    $curl->setHeader('Content-Type', 'application/json');
    $curl->setOpt(CURLOPT_HTTPHEADER , array('Authorization: Bearer '.$qiwi[0]['token'].''));
    $curl->get('https://edge.qiwi.com/payment-history/v2/persons/'.$qiwi[0]['phone'].'/payments/total?startDate='.$dateEnd.'&endDate='.$todayStart.'&operation='.$qiwi[0]['trans_type'].'');


    if ($curl->error) {
        echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n";
    } else {


        //var_dump($curl->response);

        /**
         *  Расход
         */

        $response = json_decode(json_encode($curl->response),true); // преобразование строки в формате json в ассоциативный массив
        $totalcost = $response['outgoingTotal'][0]['amount']; // получаем расход ТОТАЛ
        if($totalcost == NULL){
            return 'За последние 7 дней не было транзакций.';
        }
        return 'Расход: ' . $totalcost;
    }
}

//echo getBalance($db,$curl,$id).'<br>';
//echo '<br>' . getLastOperation($db,$curl,$id);
//echo '<br>' . getTotalCostToday($db,$curl,$id);
//echo '<br>'. getTotalCost7days($db,$curl,$id);