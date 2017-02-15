<?php
/**
 * Created by PhpStorm.
 * User: jscheq
 * Date: 11.01.17
 * Time: 23:17
 */
class Helpers
{
    public static function includeAllModels()
    {
        require 'models/Companies.php';
        require 'models/Company.php';
        require 'models/Users.php';
        require 'models/User.php';
        require 'models/Documents.php';
        require 'models/Document.php';
    }
}