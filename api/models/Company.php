<?php
namespace Models;

/**
 * Created by PhpStorm.
 * User: jscheq
 * Date: 09.01.17
 * Time: 8:35
 */
class Company
{
    public $id;
    public $shortName;
    public $fullName;
    public $inn;
    public $kpp;
    public $checkingAccount;
    public $correspodentAccount;
    public $bik;

    function __construct( $id, $shortName, $fullName, $inn, $kpp, $checkingAccount, $correspodentAccount, $bik ) {
        $this->id = $id;
        $this->shortName = $shortName;
        $this->fullName = $fullName;
        $this->inn = $inn;
        $this->kpp = $kpp;
        $this->checkingAccount = $checkingAccount;
        $this->correspodentAccount = $correspodentAccount;
        $this->bik = $bik;
    }
}