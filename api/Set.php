<?php
namespace Core;

/**
 * Получает, преобразовывет данные и записывает в БД
 *
 * Class Set
 * @package Core
 */
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

        if( $id != null && $body != null )
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
                    "INN"                   => $company->INN,
                    "KPP"                   => $company->KPP,
                    "checkingAccount"       => $company->checkingAccount,
                    "correspodentAccount"   => $company->correspodentAccount,
                    "BIK"                   => $company->BIK,
                    "phoneFirst"            => $company->phoneFirst, //
                    "phoneSecond"           => $company->phoneSecond, //
                    "stastisticsCode"       => $company->stastisticsCode, //
                    "address"               => $company->address, //
                    'documents'             => $company->documents,
                    'bank'                  => $company->bank
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
        else if ( $body != null )
        {
            // INSERT company

            $company = self::getAllData( $body['company'] );

            $company->documents = self::getDenormalizeData( $company->documents );

            $selectStatement = self::getPDO()
                ->insert( array( 'shortName', 'fullName', 'director', 'accountant',  "INN",  "KPP", "checkingAccount", "correspodentAccount", "BIK", "phoneFirst", "phoneSecond", "stastisticsCode", "address", 'documents', 'bank' ) )
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
                    $company->documents,
                    $company->bank
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

        if( $id != null && $body != null )
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
        else if ( $body != null )
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

        if( $id != null && $body != null )
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

            // Добавим поле documents для company по $document->parentCompany
            self::updateCompanyDocuments( $id, $document->parentCompany );

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
        else if ( $body != null )
        {
            // INSERT document

            $document = self::getAllData( $body['document'] );

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

            // Добавим поле documents для company по $document->parentCompany
            self::updateCompanyDocuments( $id, $document->parentCompany );

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

        if( $id != null && $body != null )
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
        else if ( $body != null )
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

        if( $id != null && $body != null )
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
        else if ( $body != null )
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

        if( $id != null && $body != null )
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
        else if ( $body != null )
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