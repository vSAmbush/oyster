<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.10.2018
 * Time: 11:41
 */

namespace lib;

/**
 * Class SQLHandler is used for access to db
 * @package lib
 *
 * $pdo - object of class PDO, which executes queries
 * $stmt - object of class Statement, which contains the query results
 */
class SQLHandler
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var \PDOStatement
     */
    private $stmt;

    /**
     * SQLHandler constructor.
     */
    public function __construct()
    {
        try {
            $config = Config::get('db');
            $this->pdo = new \PDO($config['dsn'], $config['username'], $config['password'], $config['options']);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * Method that executes select queries
     *
     * @param $sql
     * @param array $params
     * @return array|null - assoc array results of the query
     */
    public function executeSelect($sql, $params = []) {

        try {
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute($params);

        } catch (\PDOException $e) {
            die($e->getMessage());
        }

        $result = null;
        if($this->stmt->rowCount()) {

            $result = [];
            for($i = 0; $i < $this->stmt->rowCount(); $i++) {
                $result[$i] = $this->stmt->fetch(\PDO::FETCH_ASSOC);
            }
        }

        return $result;
    }

    /**
     * Method that executes insert, delete and update queries
     *
     * @param $sql
     * @param $params
     * @return int - count of edited rows
     */
    public function executeIDU($sql, $params = []) {

        try {
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute($params);

        } catch(\PDOException $e) {
            die($e->getMessage());
        }

        return $this->stmt->rowCount();
    }
}