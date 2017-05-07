<?php
/**
 * Created by PhpStorm.
 */
namespace pl\zupka\chinska\mvc\api\entity\vo;

/**
 * Class ClientVo represents the Value Object mapped from Data Source, in this case the Data Base Table.
 * VO has to be immutable and represents simple Entity.
 *
 * @package pl\zupka\chinska\mvc\dao
 */
class ClientVo
{
    private $name;
    private $surname;
    private $email;
    private $status;
    private $telephone;

    /**
     * ClientVo constructor - object instance can be created only once via constructor, it guaranties the VO immutability.
     *
     * @param $name
     * @param $surname
     * @param $email
     * @param $status
     * @param $telephone
     */
    public function __construct($name, $surname, $email, $status, $telephone)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->status = $status;
        $this->telephone = $telephone;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }
}