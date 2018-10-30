<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.10.2018
 * Time: 16:08
 */

namespace lib;


class Model
{
    /**
     * @return string
     */
    protected static function tableName() {
        $test = explode('\\', get_called_class());
        return strtolower(end($test));
    }

    /**
     * Find one record in db and return as a assoc array
     *
     * @param $params
     * @return mixed
     */
    public static function find($params = null) {

        if(!$params) {
            $sql = 'select * from '.static::tableName().';';
        }
        else {
            //use static because self - it is only THIS class (Model)
            $sql = 'select * from ' . static::tableName() . ' where ';
            $keys = array_keys($params);
            $n = count($params);

            for ($i = 0; $i < $n; $i++) {
                if ($i != $n - 1)
                    $sql .= '`'.$keys[$i].'` = ? and ';
                else
                    $sql .= '`'.$keys[$i].'` = ?;';
            }
        }
        $values = array_values($params);

        return App::$sql_handler->executeSelect($sql, $values);
    }

    /**
     * Find one record in db and return as a assoc array
     *
     * @param $params
     * @return mixed
     */
    public static function findOne($params = null) {

        if(!$params) {
            $sql = 'select * from '.static::tableName().';';
        }
        else {
            //use static because self - it is only THIS class (Model)
            $sql = 'select * from ' . static::tableName() . ' where ';
            $keys = array_keys($params);
            $n = count($params);

            for ($i = 0; $i < $n; $i++) {
                if ($i != $n - 1)
                    $sql .= '`'.$keys[$i].'` = ? and ';
                else
                    $sql .= '`'.$keys[$i].'` = ? ';
            }
            $sql .= 'limit 1;';
        }
        $values = array_values($params);

        return App::$sql_handler->executeSelect($sql, $values)[0];
    }

    /**
     * Updates records by parameters - set and where
     *
     * @param $set
     * @param $where
     * @return int - counts of edited records
     */
    public static function update($set, $where) {
        $sql = 'update '.static::tableName().' set ';
        $keys = array_keys($set);
        $n = count($set);

        for($i = 0; $i < $n; $i++) {
            if($i != $n - 1)
                $sql .= '`'.$keys[$i].'` = ?, ';
            else
                $sql .= '`'.$keys[$i].'` = ? ';
        }

        $values = array_values($set);
        $sql .= 'where ';
        $keys = array_keys($where);
        $n = count($where);

        for($i = 0; $i < $n; $i++) {
            if($i != $n - 1)
                $sql .= '`'.$keys[$i].'` = ? and ';
            else
                $sql .= '`'.$keys[$i].'` = ?;';
        }
        $values = array_merge($values, array_values($where));

        return App::$sql_handler->executeIDU($sql, $values);
    }

    /**
     * Inserting record in table
     *
     * @param $data
     * @return int - counts edited records
     */
    public static function insert($data) {
        $sql = 'insert into '.static::tableName().' (';
        $part = array_keys($data);
        $n = count($part);

        for($i = 0; $i < $n; $i++) {
            if($i != $n - 1)
                $sql .= '`'.$part[$i].'`, ';
            else
                $sql .= '`'.$part[$i].'`) ';
        }
        $sql .= 'value (';
        $part = array_values($data);

        for($i = 0; $i < $n; $i++) {
            if($i != $n - 1)
                $sql .= ' ?, ';
            else
                $sql .= '?);';
        }
        
        return App::$sql_handler->executeIDU($sql, $part);
    }
}