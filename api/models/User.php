<?php
namespace Models;

/**
 * Created by PhpStorm.
 * User: jscheq
 * Date: 10.01.17
 * Time: 22:10
 */
class User
{
    public $id;
    public $pass;
    public $name;
    public $email;
    public $phone;
    public $status;

    function __construct( $id, $pass, $name, $email, $phone, $status )
    {
        $this->id = $id;
        $this->pass = $pass;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->status = $status;
    }
}