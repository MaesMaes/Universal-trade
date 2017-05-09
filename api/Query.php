<?php
namespace Core;

use db\Database;

/**
 * Класс расширения, содержит вспомагательные методы для классов Get, Set и Delete
 *
 * Class Query
 * @package Core
 */
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

        if( empty( $data ) ) return $tpmData;

        foreach( $data as $item )
        {
            $tpmData .= $item . ',';
        }

        return $tpmData;
    }

    /**
     * UPDATE поля documents компании $companyID
     *
     * @param $documentID
     * @param $companyID
     */
    public static function updateCompanyDocuments( $documentID, $companyID  )
    {
        $selectStatement = self::getPDO()
            ->select()
            ->from('companies')
            ->where('id', '=', $companyID);

        $stmt = $selectStatement->execute();
        $company = $stmt->fetch();

        $documents = $company->documents;

        $documents = self::setDenormalizeData( $documents );

        // Если этот документ уже есть, выходим.
        if( in_array( $documentID, $documents ) ) return;

        // Добавляем новый документ
        $documents[] = $documentID;

        $documents = self::getDenormalizeData( $documents );

        $selectStatement = self::getPDO()
            ->update( array(
                'documents' => $documents,
            ) )
            ->table('companies')
            ->where('id', '=', $companyID );

        $stmt = $selectStatement->execute();
    }

    /**
     * Проверяет залогенин ли пользователь
     *
     * @return bool
     */
    public static function isLogin()
    {
        if ( !isset( $_SESSION['token'] ) ) return false;

        return true;
    }
}