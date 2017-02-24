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

        $deleteStatement = self::getPDO()
            ->delete()
            ->from( $type )
            ->where( 'id', '=', $id );

        return  $deleteStatement->execute();
    }
}