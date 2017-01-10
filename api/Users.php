<?php
namespace Models;

/**
 * Created by PhpStorm.
 * User: jscheq
 * Date: 10.01.17
 * Time: 22:07
 */
class Users
{
    /*
     * Список пользователей
     */
    public $users = array();

    /**
     * Companies constructor.
     * @param array User $users
     */
    function __construct( $users )
    {
        $this->users = $users;
    }
}