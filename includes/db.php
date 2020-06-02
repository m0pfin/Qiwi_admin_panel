<?php
/**
 * Created by PhpStorm.
 * User: igrek
 * Date: 16.12.2018
 * Time: 5:15
 */

Class Database
{
    private $link;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        $this->connect();
    }

    /**
     * //Соединение с БД
     * @return $this
     */
    private function connect()
    {
        $config = require 'config.php';
        $dsn = 'mysql:host='.$config['host'].';dbname='.$config['db_name'].';charset='.$config['charset'];

        try {
            $this->link = new PDO($dsn, $config['user'], $config['password']);
            $this->link->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->link->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        }
        catch (\PDOException $e)
        {
            exit($e->getMessage());
        }

        return $this;
    }

    /**
     * Закрытие соединения с БД
     * @return mixed
     */
    public function closeConnection()
    {
        $this->link = NULL;
    }

    /**
     * Выполнение запросов INSERT/UPDATE/DELETE
     * @param $sql
     * @return mixed
     */
    public function execute($sql)
    {
        $sth = $this->link->prepare($sql);

        return $sth->execute();
    }

    /**
     * Для выполнения SELECT * FROM
     * @param $sql
     * @return array
     */
    public function query($sql)
    {
        $sth = $this->link->prepare($sql);

        $sth->execute();

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);


        if ($result === false){
            return [];
        }

        return $result;
    }

    /**
     * Для выполнения SELECT 1 строки
     * @param $sql
     * @return array
     */
    public function fetch($sql)
    {
        $sth = $this->link->prepare($sql);

        $sth->execute();

        $result = $sth->fetch(PDO::FETCH_ASSOC);

        if ($result === false){
            return [];
        }

        return $result;
    }

    /**
     * Для счета записей в БД определенного значения
     * @param $table
     * @param $where
     * @param $value
     * @return mixed
     */
    public function countWhere($table, $where, $value){

        $sql = "SELECT count(*) FROM $table WHERE $where='$value'";

        $sth = $this->link->prepare($sql);

        $sth->execute();

        $countRows = $sth->fetchColumn();

        return $countRows;
    }

    /**
     * Для счета всех записей в определенной БД
     * @param $table
     * @param $where
     * @return mixed
     */
    public function countAll($table, $where){

        $sql = "SELECT count(*) FROM $table WHERE $where";

        $sth = $this->link->prepare($sql);

        $sth->execute();

        $countRows = $sth->fetchColumn();

        return $countRows;
    }
}




$db = new Database();

// INSERT $db->execute("INSERT INTO `offers` SET  `name`='PDO-TEST', `cost`='1050', `status`='3', `pp_name`='Ad1', `date`=NOW()");
// UPDATE $db->execute("UPDATE `offers` SET `name`='PDO-UPDATE',`cost`='105050',`status`='2',`pp_name`='M1',`date`=NOW() WHERE id_offer='41'");

//$offers = $db->query("SELECT * FROM `offers`  ORDER BY id_offer DESC");

//foreach ($offers as $row) {
//    print $row['id_offer'] . "<br>";
//    print $row['name'] . "<br>";
//    print $row['cost'] . "<br>";
//    print $row['pp_name'] . "<br><br>";
//}


