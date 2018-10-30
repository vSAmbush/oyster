<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.10.2018
 * Time: 16:41
 */

namespace models;


use lib\Model;

class Permission extends Model
{
    private $object;

    private $type;

    private $flag;

    /**
     * Permission constructor.
     * @param $object
     * @param $type
     * @param $flag
     */
    private function __construct($object, $type, $flag)
    {
        $this->object = $object;
        $this->type = $type;
        $this->flag = $flag;
    }

    public static function tableName()
    {
        return 'permissions';
    }

    /**
     * Get all permissions
     *
     * @param null $params
     * @return array|null|Permission[]
     */
    public static function getPermissions($params = null) {
        $arr = self::find($params);
        if($arr) {
            $result = [];

            for($i = 0; $i < count($arr); $i++) {
                $result[$i] = new Permission($arr[$i]['object'], $arr[$i]['type'], $arr[$i]['flag']);
            }
        }
        else
            $result = null;

        return $result;
    }

    /**
     * @return integer
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getFlag()
    {
        return $this->flag;
    }


}