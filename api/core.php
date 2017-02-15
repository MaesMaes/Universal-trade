<?php
namespace Core;
use db\Database;

class Query
{
    public static function getPDO()
    {
        return \db\Database::getInstance()->getPdo();
    }

    /**
     * Преобразовывает данные клиента в объект в независимости
     * от того пришла строка JSON или массив
     *
     * @param $data
     * @return mixed|object
     */
    public static function getAllData( $data )
    {
        if( gettype( $data ) == 'array' )
        {
            return (object)$data;
        }
        else
        {
            return json_decode( $data );
        }
    }
}

class Get extends Query
{
    /**
     * Возвращает список компаний
     * @return bool|object
     */
    public static function companies()
    {
        $selectStatement = self::getPDO()
            ->select()
            ->from('companies');

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        if( !$data ) return (object)array(
            'companies' => array()
        );

        $companies = (object)array(
            'companies' => $data
        );

        return $companies;
    }

    /**
     * Возвращает данные о компании по id
     * @param $id
     * @return bool|object
     */
    public static function company( $id )
    {
        $selectStatement = self::getPDO()
            ->select()
            ->from('companies')
            ->where('id', '=', $id);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetch();

        if( !$data ) return false;

        $company = (object)array(
            'company' => $data
        );

        return $company;
    }

    /**
     * Возвращает список пользователей
     * @return bool|object
     */
    public static function users()
    {
        $selectStatement = self::getPDO()
            ->select()
            ->from('users');

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        if( !$data ) return (object)array(
            'users' => array()
        );

        $users = (object)array(
            'users' => $data
        );

        return $users;
    }

    /**
     * Возвращает данные о пользователе по id
     * @param $id
     * @return bool|object
     */
    public static function user( $id )
    {
        $selectStatement = self::getPDO()
            ->select()
            ->from('users')
            ->where('id', '=', $id);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetch();

        if( !$data ) return (object)array(
            'user' => array()
        );

        $user = (object)array(
            'user' => $data
        );

        return $user;
    }

    /**
     * Возвращает список документов
     * @return bool|object
     */
    public static function documents()
    {
        $selectStatement = self::getPDO()
            ->select()
            ->from('documents');

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        if( !$data ) return (object)array(
            'documents' => array()
        );

        $documents = (object)array(
            'documents' => $data
        );

        return $documents;
    }

    /**
     * Возвращает данные о документе по id
     * @param $id
     * @return bool|object
     */
    public static function document( $id )
    {
        $selectStatement = self::getPDO()
            ->select()
            ->from('documents')
            ->where('id', '=', $id);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetch();

        if( !$data ) return (object)array(
            'document' => array()
        );

        $document = (object)array(
            'document' => $data
        );

        return $document;
    }

    /**
     * Возвращает список клинтов
     * @return bool|object
     */
    public static function clients()
    {
        $selectStatement = self::getPDO()
            ->select()
            ->from('clients');

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        if( !$data ) return (object)array(
            'clients' => array()
        );

        $clients = (object)array(
            'clients' => $data
        );

        return $clients;
    }

    /**
     * Возвращает данные о документе по id
     * @param $id
     * @return bool|object
     */
    public static function client( $id )
    {
        $selectStatement = self::getPDO()
            ->select()
            ->from('clients')
            ->where('id', '=', $id);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetch();

        if( !$data ) return (object)array(
            'client' => array()
        );

        $client = (object)array(
            'client' => $data
        );

        return $client;
    }
}

class Set extends Query
{
    /**
     * Делает UPDATE или INSERT компании
     *
     * @param null $body
     * @param null $id
     * @return mixed|object|string
     */
    public static function company( $body = null, $id = null )
    {
        $company = "";

        if( $id && $body )
        {
            // UPDATE company by $id

            $company = self::getAllData( $company );

            $selectStatement = self::getPDO()
                ->update( array(
                    'shortName'             => $company->shortName,
                    'fullName'              => $company->fullName,
                    'director'              => $company->director, //
                    'accountant'            => $company->accountant, //
                    "inn"                   => $company->INN,
                    "kpp"                   => $company->KPP,
                    "checkingAccount"       => $company->checkingAccount,
                    "correspodentAccount"   => $company->correspodentAccount,
                    "bank"                  => $company->bank,
                    "bik"                   => $company->BIK,
                    "phoneFirst"            => $company->phoneFirst, //
                    "phoneSecond"           => $company->phoneSecond, //
                    "stastisticsCode"       => $company->stastisticsCode, //
                    "address"               => $company->address, //
                ) )
                ->table('companies')
                ->where('id', '=', $id );

            $stmt = $selectStatement->execute();

            $selectStatement = self::getPDO()
                ->select()
                ->from('companies')
                ->where('id', '=', $id);

            $stmt = $selectStatement->execute();
            $data = $stmt->fetch();

            if( !$data ) return (object)array(
                'document' => array()
            );

            $company = (object)array(
                'company' => $data
            );
        }
        else if ( $body )
        {
            // INSERT company

            $company = self::getAllData( $company );

            $selectStatement = self::getPDO()
                ->insert( array( 'shortName', 'fullName', 'director', 'accountant',  "inn",  "kpp", "checkingAccount", "correspodentAccount", "bik", "phoneFirst", "phoneSecond", "stastisticsCode", "address" ) )
                ->into('companies')
                ->values( array( null, null, null, null, null, null, null, null, null, null, null, null, null ) );

            $stmt = $selectStatement->execute();

            $selectStatement = self::getPDO()
                ->select()
                ->from('companies')
                ->where('id', '=', $stmt);

            $stmt = $selectStatement->execute();
            $data = $stmt->fetch();

            $company = (object)array(
                'company' => $data
            );
        }

        return $company;
    }

    /**
     * Делает UPDATE или INSERT пользователя
     *
     * @param null $body
     * @param null $id
     * @return mixed|object|string
     */
    public static function user( $body = null, $id = null )
    {
        $user = "";

        if( $id && $body )
        {
            // UPDATE user by $id

            $user = self::getAllData( $body['user'] );

            $selectStatement = self::getPDO()
                ->update( array(
                    'pass'   => $user->pass,
                    'name'   => $user->name,
                    "email"  => $user->email,
                    "phone"  => $user->phone,
                    "status" => $user->status
                ) )
                ->table('users')
                ->where('id', '=', $id );

            $stmt = $selectStatement->execute();

            $selectStatement = self::getPDO()
                ->select()
                ->from('users')
                ->where('id', '=', $id);

            $stmt = $selectStatement->execute();
            $data = $stmt->fetch();

            $user = (object)array(
                'user' => $data
            );
        }
        else if ( $body )
        {
            // INSERT user

            $user = self::getAllData( $body['user'] );

            $selectStatement = self::getPDO()
                ->insert( array( 'pass', 'name', "email",  "phone", "status" ) )
                ->into('users')
                ->values( array( null, null, null, null, null ) );

            $stmt = $selectStatement->execute();

            $selectStatement = self::getPDO()
                ->select()
                ->from('users')
                ->where('id', '=', $stmt);

            $stmt = $selectStatement->execute();
            $data = $stmt->fetch();

            $user = (object)array(
                'user' => $data
            );
        }

        return $user;
    }

    /**
 * Делает UPDATE или INSERT документа
 *
 * @param null $body
 * @param null $id
 * @return mixed|object|string
 */
    public static function document( $body = null, $id = null )
    {
        $document = "";

        if( $id && $body )
        {
            // UPDATE document by $id

            $document = self::getAllData( $body['document'] );

            $selectStatement = self::getPDO()
                ->update( array(
                    'numberTemplate'    => $document->numberTemplate,
                    "createNumber"      => $document->createNumber,
                    "createDate"        => $document->createDate,
                    "editNumber"        => $document->editNumber,
                    "editDate"          => $document->editDate,
                    "editNumber"        => $document->editNumber,
                    "sellerAddress"     => $document->sellerAddress,
                    "sellerINN"         => $document->sellerINN,
                    "sellerKPP"         => $document->sellerKPP,
                    "buyerName"         => $document->buyerName,
                    "buyerAddress"      => $document->buyerAddress,
                    "buyerInn"          => $document->buyerInn,
                    "buyerKPP"          => $document->buyerKPP,
                    "receiptNumber"     => $document->receiptNumber,
                    "receiptDate"       => $document->receiptDate,
                    "clientID"          => $document->clientID,
                    "status"            => $document->status,
                ) )
                ->table('documents')
                ->where('id', '=', $id );

            $stmt = $selectStatement->execute();

            $selectStatement = self::getPDO()
                ->select()
                ->from('documents')
                ->where('id', '=', $id);

            $stmt = $selectStatement->execute();
            $data = $stmt->fetch();

            if( !$data ) return (object)array(
                'document' => array()
            );

            $document = (object)array(
                'document' => $data
            );
        }
        else if ( $body )
        {
            // INSERT document

            $document = self::getAllData( $body['user'] );

            $selectStatement = self::getPDO()
                ->insert( array( 'numberTemplate', 'createNumber', "createDate",  "editNumber", "editDate", 'sellerName', 'sellerAddress', 'sellerINN', 'sellerKPP', 'buyerName', 'buyerAddress', 'buyerInn', 'buyerKPP', 'receiptNumber', 'receiptDate', 'clientID', 'status' ) )
                ->into('documents')
                ->values( array( null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null ) );

            $stmt = $selectStatement->execute();

            $selectStatement = self::getPDO()
                ->select()
                ->from('documents')
                ->where('id', '=', $stmt);

            $stmt = $selectStatement->execute();
            $data = $stmt->fetch();

            $document = (object)array(
                'document' => $data
            );
        }

        return $document;
    }

    /**
     * Делает UPDATE или INSERT клиента
     *
     * @param null $body
     * @param null $id
     * @return mixed|object|string
     */
    public static function client( $body = null, $id = null )
    {
        $client = "";

        if( $id && $body )
        {
            // UPDATE document by $id

            $client = self::getAllData( $body['client'] );

            $selectStatement = self::getPDO()
                ->update( array(
                    'fullName' => $client->fullName,
                    "email"    => $client->email,
                    "phone"    => $client->phone,
                ) )
                ->table('clients')
                ->where('id', '=', $id );

            $stmt = $selectStatement->execute();

            $selectStatement = self::getPDO()
                ->select()
                ->from('clients')
                ->where('id', '=', $id);

            $stmt = $selectStatement->execute();
            $data = $stmt->fetch();

            if( !$data ) return (object)array(
                'client' => array()
            );

            $client = (object)array(
                'client' => $data
            );
        }
        else if ( $body )
        {
            // INSERT document

            $client = self::getAllData( $body['client'] );

            $selectStatement = self::getPDO()
                ->insert( array( 'fullName', 'email', "phone" ) )
                ->into('clients')
                ->values( array( null, null, null ) );

            $stmt = $selectStatement->execute();

            $selectStatement = self::getPDO()
                ->select()
                ->from('clients')
                ->where('id', '=', $stmt);

            $stmt = $selectStatement->execute();
            $data = $stmt->fetch();

            $client = (object)array(
                'client' => $data
            );
        }

        return $client;
    }
}

class Delete extends Query
{
    /**
     * Удаляет запись по id и type
     *
     * @param $type 'companies', 'users', 'documents'
     * @param $id
     * Возвращает false если не переданы параметры,
     * 1 если запись была удалена и 0 если id не существует.
     * @return bool|int
     */
    public static function object( $type, $id )
    {
        if( !$type || !$id ) return false;

        $deleteStatement = self::getPDO()
            ->delete()
            ->from( $type )
            ->where( 'id', '=', $id );

        return  $deleteStatement->execute();
    }
}
