<?php

/**
 * Created by PhpStorm.
 * User: jscheq
 * Date: 10.01.17
 * Time: 20:30
 */

require "company.class.php";

class Companies
{
    /*
     * Список компаний
     */
    public $companies = array();

    /**
     * Companies constructor.
     * @param array Company $companies
     */
    function __construct( $companies )
    {
        $this->companies = $companies;
    }
}