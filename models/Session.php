<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.10.2018
 * Time: 17:48
 */

namespace models;


use lib\Model;

class Session extends Model
{
    private $key;

    private $id_user;

    private $user;

    private $ip;

    private $expired;

    /**
     * Session constructor.
     * @param $key
     * @param $user
     * @param $ip
     * @param $expired
     */
    private function __construct($key, $user, $ip, $expired)
    {
        $this->key = $key;
        $this->id_user = $user;
        $this->user = User::findUser([
            'id' => $this->id_user,
        ]);
        $this->ip = $ip;
        $this->expired = $expired;
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'sessions';
    }

    public static function findSession($params = null) {

        $arr = self::findOne($params);

        return ($arr) ? new Session($arr['key'], $arr['user'], $arr['ip'], $arr['expired']) : null;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return integer
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @return date
     */
    public function getExpired()
    {
        return $this->expired;
    }
}