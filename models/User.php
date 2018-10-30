<?php

namespace models;

use lib\Model;


/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.10.2018
 * Time: 11:22
 */

class User extends Model
{
    private $id;

    private $fio;

    private $avatar;

    private $role;

    private $email;

    private $mobile;

    private $office;

    private $pin;

    private $expiration;

    private $birthday;

    private $active;

    private $timer;

    private $disabled;

    /**
     * Private user constructor. Using only for returning in static methods
     *
     * @param $id
     * @param $fio
     * @param $avatar
     * @param $role
     * @param $email
     * @param $mobile
     * @param $office
     * @param $pin
     * @param $expiration
     * @param $birthday
     * @param $active
     * @param $timer
     * @param $disabled
     */
    private function __construct($id, $fio, $avatar, $role, $email, $mobile, $office, $pin, $expiration, $birthday,
                                 $active, $timer, $disabled)
    {
        $this->id = $id;
        $this->fio = $fio;
        $this->avatar = $avatar;
        $this->role = $role;
        $this->email = $email;
        $this->mobile = $mobile;
        $this->office = $office;
        $this->pin = $pin;
        $this->expiration = $expiration;
        $this->birthday = $birthday;
        $this->active = $active;
        $this->timer = $timer;
        $this->disabled = $disabled;
    }

    /**
     * Here set the table name from database (default is name of class - User)
     * Recommend to use always
     *
     * @return string
     */
    protected static function tableName()
    {
        return 'users';
    }

    /**
     * Returns object of found user or null
     *
     * @param $params
     * @return User|null
     */
    public static function findUser($params) {

        $arr = self::findOne($params);

        return ($arr) ? new User($arr['id'], $arr['fio'], $arr['avatar'], $arr['role'], $arr['email'], $arr['mobile'],
            $arr['office'], $arr['pin'], $arr['expiration'], $arr['birthday'], $arr['active'], $arr['timer'], $arr['disabled']) : null;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFio()
    {
        return $this->fio;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @return integer
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @return integer
     */
    public function getOffice()
    {
        return $this->office;
    }

    /**
     * @return integer
     */
    public function getPin()
    {
        return $this->pin;
    }

    /**
     * @return date
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * @return date
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @return date
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @return integer
     */
    public function getTimer()
    {
        return $this->timer;
    }

    /**
     * @return integer
     */
    public function getDisabled()
    {
        return $this->disabled;
    }
}