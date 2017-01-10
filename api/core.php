<?php
namespace Core;

require 'Companies.php';
require 'Company.php';
require 'Users.php';
require 'User.php';

use \Models\Companies as Companies;
use \Models\Company as Company;
use \Models\Users as Users;
use \Models\User as User;

/**
 * Created by PhpStorm.
 * User: jscheq
 * Date: 10.01.17
 * Time: 22:50
 */
class Get
{
    /**
     * Возвращает список компаний
     * @return \Models\Companies
     */
    public static function companies()
    {
        $companies = new Companies(
            array(
                new Company( 5, 'Рога и рога', 'ООО Рога и рога', '654612312', '766787692', '412313', '098123598', '0458748516' ),
                new Company( 5, 'Рога и рога', 'ООО Рога и рога', '654612312', '766787692', '412313', '098123598', '0458748516' ),
                new Company( 5, 'Рога и рога', 'ООО Рога и рога', '654612312', '766787692', '412313', '098123598', '0458748516' ),
                new Company( 5, 'Рога и рога', 'ООО Рога и рога', '654612312', '766787692', '412313', '098123598', '0458748516' ),
                new Company( 5, 'Рога и рога', 'ООО Рога и рога', '654612312', '766787692', '412313', '098123598', '0458748516' ),
            )
        );

        return $companies;
    }

    /**
     * Возвращает данные о компании по id
     * @param $id
     * @return \Models\Company
     */
    public static function company( $id )
    {
        $company = new Company( $id, 'Рога и рога', 'ООО Рога и рога', '654612312', '766787692', '412313', '098123598', '0458748516' );

        return $company;
    }

    /**
     * Возвращает список пользователей
     * @return Users
     */
    public static function users()
    {
        $users = new Users(
            array(
                new User( 1, 'Mauriti545us', 'Андрей Иванович', 'jodyterry@insource.com', '+7 (979) 510-2195', 'Amtap' ),
                new User( 2, 'Mauriti545us', 'Андрей Иванович', 'jodyterry@insource.com', '+7 (979) 510-2195', 'Amtap' ),
                new User( 3, 'Mauriti545us', 'Андрей Иванович', 'jodyterry@insource.com', '+7 (979) 510-2195', 'Amtap' ),
                new User( 4, 'Mauriti545us', 'Андрей Иванович', 'jodyterry@insource.com', '+7 (979) 510-2195', 'Amtap' ),
            )
        );

        return $users;
    }

    /**
     * Возвращает данные о пользователе по id
     * @param $id
     * @return User
     */
    public static function user( $id )
    {
        $user = new User( $id, 'Mauriti545us', 'Андрей Иванович', 'jodyterry@insource.com', '+7 (979) 510-2195', 'Amtap' );

        return $user;
    }
}