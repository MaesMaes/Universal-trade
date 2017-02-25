<?php
namespace Core;

/**
 * Возвращает и преобразовывает данные из базы
 *
 * Class Get
 * @package Core
 */
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

            $documents = array();
            foreach( $company['documents'] as &$docID )
            {
                $selectStatement = self::getPDO()
                    ->select()
                    ->from( 'documents' )
                    ->where( 'id', '=', $docID );

                $stmt = $selectStatement->execute();
                $document = $stmt->fetch();

                $document['products'] = self::setDenormalizeData( $document['products'] );

                $products = array();
                foreach( $document['products'] as $prodID )
                {
                    $selectStatement = self::getPDO()
                        ->select()
                        ->from( 'products' )
                        ->where( 'id', '=', $prodID );

                    $stmt = $selectStatement->execute();
                    $product = $stmt->fetch();

                    $products[] = $product;
                }

                $document['products'] = $products;

                $documents[] = $document;
            }

            $company['documents'] = $documents;
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

        $documents = array();
        foreach( $data['documents'] as &$docID )
        {
            $selectStatement = self::getPDO()
                ->select()
                ->from( 'documents' )
                ->where( 'id', '=', $docID );

            $stmt = $selectStatement->execute();
            $document = $stmt->fetch();

            $document['products'] = self::setDenormalizeData( $document['products'] );

            $products = array();
            foreach( $document['products'] as $prodID )
            {
                $selectStatement = self::getPDO()
                    ->select()
                    ->from( 'products' )
                    ->where( 'id', '=', $prodID );

                $stmt = $selectStatement->execute();
                $product = $stmt->fetch();

                $products[] = $product;
            }

            $document['products'] = $products;

            $documents[] = $document;
        }

        $data['documents'] = $documents;

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

            $products = array();
            foreach( $doc['products'] as &$prodID )
            {
                $selectStatement = self::getPDO()
                    ->select()
                    ->from( 'products' )
                    ->where( 'id', '=', $prodID );

                $stmt = $selectStatement->execute();
                $product = $stmt->fetch();

                $products[] = $product;
            }

            $doc['products'] = $products;
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

        $products = array();
        foreach( $data['products'] as &$prodID )
        {
            $selectStatement = self::getPDO()
                ->select()
                ->from( 'products' )
                ->where( 'id', '=', $prodID );

            $stmt = $selectStatement->execute();
            $product = $stmt->fetch();

            $products[] = $product;
        }

        $data['products'] = $products;

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