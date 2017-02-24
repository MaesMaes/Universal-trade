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

    /**
     * Get data from tmp/bik.xml and insert in bik table.
     *
     * @return bool|object
     */
    public static function updateBIKDatabase()
    {
        $url = 'http://www.bik-info.ru/base/base.xml';
        $dir = '/tmp/';

        // Получаем актуальный XML
        //$newXML = file_get_contents( $url );
        //$newXMLData = simplexml_load_string( $newXML );

        // Получаем текущий XML
        $oldXML = file_get_contents( 'tmp/bik.xml' );
        $oldXMLData = simplexml_load_string( $oldXML );

        foreach( $oldXMLData->bik as $bik )
        {
            $selectStatement = self::getPDO()
                ->insert( array( 'bankBIK', 'correspondentAccount', "bankName", 'bankLocation' ) )
                ->into('bik')
                ->values( array(
                    (string)$bik->attributes()->bik,
                    (string)$bik->attributes()->ks,
                    (string)$bik->attributes()->name,
                    (string)$bik->attributes()->address
                ) );

            $stmt = $selectStatement->execute();
        }

        return \Core\Get::BIKs();
    }

    /**
     * Получает строку с данными в виде '1,2,3,4,' или null,
     * возвращеат массив по делиметру "," или пустой массив
     *
     * @param $data
     * @return array
     */
    public static function setDenormalizeData( $data )
    {
        if( $data != null || !$data)
        {
            $data = explode( ',',  $data );
            foreach( $data as &$item )
            {
                $item = (int)$item;
            }

            // Удаляем элемент пустышку
            array_splice( $data, -1 );
        }
        else
        {
            $data = array();
        }

        return $data;
    }

    /**
     * Получает массив и возваращщает строку вида '1,2,3,4,'
     *
     * @param $data
     * @return string
     */
    public static function getDenormalizeData( $data )
    {
        $tpmData = "";
        foreach( $data as $item )
        {
            $tpmData .= $item . ',';
        }

        return $tpmData;
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

        foreach( $data as &$company )
        {
            $company['documents'] = self::setDenormalizeData( $company['documents'] );
        }

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

        if( !$data ) return (object)array(
            'company' => array()
        );

        $data['documents'] = self::setDenormalizeData( $data['documents'] );

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

        foreach( $data as &$doc )
        {
            $doc['products'] = self::setDenormalizeData( $doc['products'] );
        }

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

        $data['products'] = self::setDenormalizeData( $data['products'] );

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

    /**
     * Возвращает список товаров
     * @return bool|object
     */
    public static function products()
    {
        $selectStatement = self::getPDO()
            ->select()
            ->from('products');

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        if( !$data ) return (object)array(
            'products' => array()
        );

        $products = (object)array(
            'products' => $data
        );

        return $products;
    }

    /**
     * Возвращает данные о товаре по id
     * @param $id
     * @return bool|object
     */
    public static function product( $id )
    {
        $selectStatement = self::getPDO()
            ->select()
            ->from('products')
            ->where('id', '=', $id);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetch();

        if( !$data ) return (object)array(
            'product' => array()
        );

        $product = (object)array(
            'product' => $data
        );

        return $product;
    }

    /**
     * Возвращает список БИКов
     * @return bool|object
     */
    public static function BIKs()
    {
        $selectStatement = self::getPDO()
            ->select()
            ->from('bik');

        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();

        if( !$data ) return (object)array(
            'biks' => array()
        );

        $biks = (object)array(
            'biks' => $data
        );

        return $biks;
    }

    /**
     * Возвращает данные о БИКе по id
     * @param $id
     * @return bool|object
     */
    public static function BIK( $id )
    {
        $selectStatement = self::getPDO()
            ->select()
            ->from('bik')
            ->where('id', '=', $id);

        $stmt = $selectStatement->execute();
        $data = $stmt->fetch();

        if( !$data ) return (object)array(
            'bik' => array()
        );

        $bik = (object)array(
            'bik' => $data
        );

        return $bik;
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

            $company = self::getAllData( $body['company'] );

            $company->documents = self::getDenormalizeData( $company->documents );

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
                    "bik"                   => $company->BIK,
                    "phoneFirst"            => $company->phoneFirst, //
                    "phoneSecond"           => $company->phoneSecond, //
                    "stastisticsCode"       => $company->stastisticsCode, //
                    "address"               => $company->address, //
                    'documents'             => $company->documents
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

            $data['documents'] = self::setDenormalizeData( $data['documents'] );

            $company = (object)array(
                'company' => $data
            );
        }
        else if ( $body )
        {
            // INSERT company

            $company = self::getAllData( $body['company'] );

            $company->documents = self::getDenormalizeData( $company->documents );

            $selectStatement = self::getPDO()
                ->insert( array( 'shortName', 'fullName', 'director', 'accountant',  "inn",  "kpp", "checkingAccount", "correspodentAccount", "bik", "phoneFirst", "phoneSecond", "stastisticsCode", "address", 'documents' ) )
                ->into('companies')
                ->values( array(
                    $company->shortName,
                    $company->fullName,
                    $company->director,
                    $company->accountant,
                    $company->INN,
                    $company->KPP,
                    $company->checkingAccount,
                    $company->correspodentAccount,
                    $company->BIK,
                    $company->phoneFirst,
                    $company->phoneSecond,
                    $company->stastisticsCode,
                    $company->address,
                    $company->documents
                ) );

            $stmt = $selectStatement->execute();

            $selectStatement = self::getPDO()
                ->select()
                ->from('companies')
                ->where('id', '=', $stmt);

            $stmt = $selectStatement->execute();
            $data = $stmt->fetch();

            if( !$data ) return (object)array(
                'document' => array()
            );

            $data['documents'] = self::setDenormalizeData( $data['documents'] );

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
                ->values( array(
                    $user->pass,
                    $user->name,
                    $user->email,
                    $user->phone,
                    $user->status
                ) );

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

            $document->products = self::getDenormalizeData( $document->products );

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
                    'parentCompany'     => $document->parentCompany,
                    'products'          => $document->products,
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

            $data['products'] = self::setDenormalizeData( $data['products'] );

            $document = (object)array(
                'document' => $data
            );
        }
        else if ( $body )
        {
            // INSERT document

            $document = self::getAllData( $body['user'] );

            $document->products = self::getDenormalizeData( $document->products );

            $selectStatement = self::getPDO()
                ->insert( array( 'numberTemplate', 'createNumber', "createDate",  "editNumber", "editDate", 'sellerName', 'sellerAddress', 'sellerINN', 'sellerKPP', 'buyerName', 'buyerAddress', 'buyerInn', 'buyerKPP', 'receiptNumber', 'receiptDate', 'clientID', 'status', 'parentCompany', 'products' ) )
                ->into('documents')
                ->values( array(
                    $document->numberTemplate,
                    $document->createNumber,
                    $document->createDate,
                    $document->editNumber,
                    $document->editDate,
                    $document->editNumber,
                    $document->sellerAddress,
                    $document->sellerINN,
                    $document->sellerKPP,
                    $document->buyerName,
                    $document->buyerAddress,
                    $document->buyerInn,
                    $document->buyerKPP,
                    $document->receiptNumber,
                    $document->receiptDate,
                    $document->clientID,
                    $document->status,
                    $document->parentCompany,
                    $document->products,
                ) );

            $stmt = $selectStatement->execute();

            $selectStatement = self::getPDO()
                ->select()
                ->from('documents')
                ->where('id', '=', $stmt);

            $stmt = $selectStatement->execute();
            $data = $stmt->fetch();

            if( !$data ) return (object)array(
                'document' => array()
            );

            $data['products'] = self::setDenormalizeData( $data['products'] );

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

            if( !$data ) return (object)array(
                'client' => array()
            );

            $client = (object)array(
                'client' => $data
            );
        }

        return $client;
    }

    /**
     * Делает UPDATE или INSERT товара
     *
     * @param null $body
     * @param null $id
     * @return mixed|object|string
     */
    public static function product( $body = null, $id = null )
    {
        $product = "";

        if( $id && $body )
        {
            // UPDATE document by $id

            $product = self::getAllData( $body['product'] );

            $selectStatement = self::getPDO()
                ->update( array(
                    'name'           => $product->name,
                    "amount"         => $product->amount,
                    "price"          => $product->price,
                    "tax"            => $product->tax,
                    'parentDocument' => $product->parentDocument
                ) )
                ->table('products')
                ->where('id', '=', $id );

            $stmt = $selectStatement->execute();

            $selectStatement = self::getPDO()
                ->select()
                ->from('products')
                ->where('id', '=', $id);

            $stmt = $selectStatement->execute();
            $data = $stmt->fetch();

            if( !$data ) return (object)array(
                'product' => array()
            );

            $product = (object)array(
                'product' => $data
            );
        }
        else if ( $body )
        {
            // INSERT document

            $product = self::getAllData( $body['product'] );

            $selectStatement = self::getPDO()
                ->insert( array( 'name', 'amount', "price", 'tax', 'parentDocument' ) )
                ->into('products')
                ->values( array( null, null, null, null, null ) );

            $stmt = $selectStatement->execute();

            $selectStatement = self::getPDO()
                ->select()
                ->from('products')
                ->where('id', '=', $stmt);

            $stmt = $selectStatement->execute();
            $data = $stmt->fetch();

            $product = (object)array(
                'product' => $data
            );
        }

        return $product;
    }

    /**
     * Делает UPDATE или INSERT БИКа
     *
     * @param null $body
     * @param null $id
     * @return mixed|object|string
     */
    public static function BIK( $body = null, $id = null )
    {
        $bik =  "";

        if( $id && $body )
        {
            // UPDATE document by $id

            $bik = self::getAllData( $body['bik'] );

            $selectStatement = self::getPDO()
                ->update( array(
                    'bankBIK'               => $bik->bankBIK,
                    "correspondentAccount"  => $bik->correspondentAccount,
                    "bankName"              => $bik->bankName,
                    "bankLocation"          => $bik->bankLocation,
                ) )
                ->table('bik')
                ->where('id', '=', $id );

            $stmt = $selectStatement->execute();

            $selectStatement = self::getPDO()
                ->select()
                ->from('bik')
                ->where('id', '=', $id);

            $stmt = $selectStatement->execute();
            $data = $stmt->fetch();

            if( !$data ) return (object)array(
                'bik' => array()
            );

            $bik = (object)array(
                'bik' => $data
            );
        }
        else if ( $body )
        {
            // INSERT document

            $bik = self::getAllData( $body['bik'] );

            $selectStatement = self::getPDO()
                ->insert( array( 'bankBIK', 'correspondentAccount', "bankName", 'bankLocation' ) )
                ->into('bik')
                ->values( array( null, null, null, null ) );

            $stmt = $selectStatement->execute();

            $selectStatement = self::getPDO()
                ->select()
                ->from('bik')
                ->where('id', '=', $stmt);

            $stmt = $selectStatement->execute();
            $data = $stmt->fetch();

            $bik = (object)array(
                'bik' => $data
            );
        }

        return $bik;
    }
}

class Delete extends Query
{
    /**
     * Удаляет запись по id и type
     *
     * @param $type 'companies', 'users', 'documents', 'clients', 'products'
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
