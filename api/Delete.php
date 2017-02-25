<?php
namespace Core;

/**
 * Удаляет данные из БД
 *
 * Class Delete
 * @package Core
 */
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

        switch( $type )
        {
            case "companies":

                // 1. Получаю информацию о данной компании
                $selectStatement = self::getPDO()
                    ->select( array( 'documents' ) )
                    ->from('companies')
                    ->where('id', '=', $id);
                $stmt = $selectStatement->execute();
                $company = $stmt->fetch();
                $company['documents'] = self::setDenormalizeData( $company['documents'] );

                // 2. Прохожу по массиву связанных документов
                foreach( $company['documents'] as $docID )
                {
                    // 3. Получаю информацию о конкретном документе
                    $selectStatement = self::getPDO()
                        ->select( array( 'products' ) )
                        ->from( 'documents' )
                        ->where( 'id', '=', $docID );
                    $stmt = $selectStatement->execute();
                    $document = $stmt->fetch();
                    $document['products'] = self::setDenormalizeData( $document['products'] );

                    // 4. Удаляю товары вложенные в данный документ
                    foreach( $document['products'] as $prodID )
                    {
                        $deleteStatement = self::getPDO()
                            ->delete()
                            ->from( 'products' )
                            ->where( 'id', '=', $prodID );
                        $deleteStatement->execute();
                    }
                }

                // 5. Проходимся по id документов для их удаления
                foreach( $company['documents'] as $docID )
                {
                    $deleteStatement = self::getPDO()
                        ->delete()
                        ->from( 'documents' )
                        ->where( 'id', '=', $docID );
                    $deleteStatement->execute();
                }

                // 6. Удаляем саму компанию
                $deleteStatement = self::getPDO()
                    ->delete()
                    ->from( 'companies' )
                    ->where( 'id', '=', $id );

                return  $deleteStatement->execute();

                break;
            case "documents":

                // 1. Получаю информацию о конкретном документе
                $selectStatement = self::getPDO()
                    ->select( array( 'products' ) )
                    ->from( 'documents' )
                    ->where( 'id', '=', $id );
                $stmt = $selectStatement->execute();
                $document = $stmt->fetch();
                $document['products'] = self::setDenormalizeData( $document['products'] );

                // 2. Удаляю товары вложенные в данный документ
                foreach( $document['products'] as $prodID )
                {
                    $deleteStatement = self::getPDO()
                        ->delete()
                        ->from( 'products' )
                        ->where( 'id', '=', $prodID );
                    $deleteStatement->execute();
                }

                // 3. Удаляем сам документ
                $deleteStatement = self::getPDO()
                    ->delete()
                    ->from( 'documents' )
                    ->where( 'id', '=', $id );

                return  $deleteStatement->execute();

                break;
            default:

                // Удаление остальных сущностей кроме documents и companies
                $deleteStatement = self::getPDO()
                    ->delete()
                    ->from( $type )
                    ->where( 'id', '=', $id );

                return  $deleteStatement->execute();
        }
    }
}