<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

session_cache_limiter(false);
session_start();

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use XBase\Table;

require 'vendor/autoload.php';
require 'database/Database.php';
require 'api/core.php';
//require 'api/routeCallbacks/companies.php';

// Конфигурируем и инициализируем сервис
$configuration = array(
    'debug' => true,
    'displayErrorDetails' => true,
);

$app = new \Slim\App(["settings" => $configuration]);

/**
 * ========================================================================================================================
 * ================================================COMPANIES===============================================================
 * ========================================================================================================================
 */

/**
 * Получить список компаний в JSON
*/
$app->get(
    '/companies',
    function ( Request $request, Response $response )
    {
        $data = \Core\Get::companies();

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse
            ->getBody()
            ->write( json_encode( $data ) );

        return $newResponse;
    }
);

/**
 * Получить данные о компании по id
 */
$app->get(
    '/companies/{id}',
    function ( Request $request, Response $response, $args )
    {
        $data = \Core\Get::company( $args['id'] );

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse
            ->getBody()
            ->write( json_encode( $data ) );

        return $newResponse;
    }
);

/**
 * Удалить компанию по id
 */
$app->delete(
    '/companies/{id}',
    function ( Request $request, Response $response, $args )
    {
        $data = \Core\Delete::object( 'companies', $args['id'] );

        if ( $data == 0 )
        {
            // id не найден

            $newResponse = $response->withStatus(404);
            return $newResponse;
        }

        // Удаление прошло успешно
        $newResponse = $response->withStatus(204);

        return $newResponse;
    }
);

/**
 * Редактировать компанию по id
 */
$app->put(
    '/companies/{id}',
    function ( Request $request, Response $response, $args )
    {
        $body = $request->getParsedBody();

        $data = \Core\Set::company( $body, $args['id'] );

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse
            ->getBody()
            ->write( json_encode( $data ) );

        return $newResponse;
    }
);

/**
 * Добавление компании
 */
$app->post(
    '/companies',
    function ( Request $request, Response $response, $args )
    {
        $body = $request->getParsedBody();

        $data = \Core\Set::company( $body );

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse
            ->getBody()
            ->write( json_encode( $data ) );

        return $newResponse;
    }
);

/**
 * ========================================================================================================================
 * ===================================================USERS================================================================
 * ========================================================================================================================
 */

/**
 * Получить список пользователей в JSON
 */
$app->get(
    '/users',
    function ( Request $request, Response $response )
    {
        $data = \Core\Get::users();

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse
            ->getBody()
            ->write( json_encode( $data ) );

        return $newResponse;
    }
);

/**
 * Получить данные о пользователе по id
 */
$app->get(
    '/users/{id}',
    function ( Request $request, Response $response, $args )
    {
        $data = \Core\Get::user( $args['id'] );

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse
            ->getBody()
            ->write( json_encode( $data ) );

        return $newResponse;
    }
);

/**
 * Удалить пользователя по id
 */
$app->delete(
    '/users/{id}',
    function ( Request $request, Response $response, $args )
    {
        $data = \Core\Delete::object( 'users', $args['id'] );

        if ( $data == 0 )
        {
            // id не найден

            $newResponse = $response->withStatus(404);
            return $newResponse;
        }

        // Удаление прошло успешно
        $newResponse = $response->withStatus(204);

        return $newResponse;
    }
);

/**
 * Добавление пользователя
 */
$app->post(
    '/users',
    function ( Request $request, Response $response, $args )
    {
        $body = $request->getParsedBody();

        $data = \Core\Set::user( $body );

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse
            ->getBody()
            ->write( json_encode( $data ) );

        return $newResponse;
    }
);

/**
 * Редактировать пользователя по id
 */
$app->put(
    '/users/{id}',
    function ( Request $request, Response $response, $args )
    {
        $body = $request->getParsedBody();

        $data = \Core\Set::user( $body, $args['id'] );

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse
            ->getBody()
            ->write( json_encode( $data ) );

        return $newResponse;
    }
);

/**
 * ========================================================================================================================
 * ================================================DOCUMENTS===============================================================
 * ========================================================================================================================
 */

/**
 * Получить список документов в JSON
 */
$app->get(
    '/documents',
    function ( Request $request, Response $response )
    {
        $data = \Core\Get::documents();

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse
            ->getBody()
            ->write( json_encode( $data ) );

        return $newResponse;
    }
);


/**
 * Получить данные о документе по id
 */
$app->get(
    '/documents/{id}',
    function ( Request $request, Response $response, $args )
    {
        $data = \Core\Get::document( $args['id'] );

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse
            ->getBody()
            ->write( json_encode( $data ) );

        return $newResponse;
    }
);

/**
 * Добавление документа
 */
$app->post(
    '/documents',
    function ( Request $request, Response $response, $args )
    {
        $body = $request->getParsedBody();

        $data = \Core\Set::document( $body );

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse
            ->getBody()
            ->write( json_encode( $data ) );

        return $newResponse;
    }
);


/**
 * Редактировать пользователя по id
 */
$app->put(
    '/documents/{id}',
    function ( Request $request, Response $response, $args )
    {
        $body = $request->getParsedBody();

        $data = \Core\Set::document( $body, $args['id'] );

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse
            ->getBody()
            ->write( json_encode( $data ) );

        return $newResponse;
    }
);

/**
 *  Удалить документ по id
 */
$app->delete(
    '/documents/{id}',
    function ( Request $request, Response $response, $args )
    {
        $data = \Core\Delete::object( 'documents', $args['id'] );

        if ( $data == 0 )
        {
            // id не найден

            $newResponse = $response->withStatus(404);
            return $newResponse;
        }

        // Удаление прошло успешно
        $newResponse = $response->withStatus(204);

        return $newResponse;
    }
);

/**
 * ========================================================================================================================
 * ======================================================CLIENTS===========================================================
 * ========================================================================================================================
 */

/**
 * Получить список клиентов в JSON
 */
$app->get(
    '/clients',
    function ( Request $request, Response $response )
    {
        $data = \Core\Get::clients();

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse
            ->getBody()
            ->write( json_encode( $data ) );

        return $newResponse;
    }
);


/**
 * Получить данные о клиенте по id
 */
$app->get(
    '/clients/{id}',
    function ( Request $request, Response $response, $args )
    {
        $data = \Core\Get::client( $args['id'] );

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse
            ->getBody()
            ->write( json_encode( $data ) );

        return $newResponse;
    }
);

/**
 * Добавление клиента
 */
$app->post(
    '/clients',
    function ( Request $request, Response $response, $args )
    {
        $body = $request->getParsedBody();

        $data = \Core\Set::client( $body );

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse
            ->getBody()
            ->write( json_encode( $data ) );

        return $newResponse;
    }
);


/**
 * Редактировать клиента по id
 */
$app->put(
    '/clients/{id}',
    function ( Request $request, Response $response, $args )
    {
        $body = $request->getParsedBody();

        $data = \Core\Set::client( $body, $args['id'] );

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse
            ->getBody()
            ->write( json_encode( $data ) );

        return $newResponse;
    }
);

/**
 *  Удалить клиента по id
 */
$app->delete(
    '/clients/{id}',
    function ( Request $request, Response $response, $args )
    {
        $data = \Core\Delete::object( 'clients', $args['id'] );

        if ( $data == 0 )
        {
            // id не найден

            $newResponse = $response->withStatus(404);
            return $newResponse;
        }

        // Удаление прошло успешно
        $newResponse = $response->withStatus(204);

        return $newResponse;
    }
);

/**
 * ========================================================================================================================
 * ===================================================PRODUCTS=============================================================
 * ========================================================================================================================
 */


/**
 * Получить список клиентов в JSON
 */
$app->get(
    '/products',
    function ( Request $request, Response $response )
    {
        $data = \Core\Get::products();

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse
            ->getBody()
            ->write( json_encode( $data ) );

        return $newResponse;
    }
);


/**
 * Получить данные о клиенте по id
 */
$app->get(
    '/products/{id}',
    function ( Request $request, Response $response, $args )
    {
        $data = \Core\Get::product( $args['id'] );

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse
            ->getBody()
            ->write( json_encode( $data ) );

        return $newResponse;
    }
);

/**
 * Добавление клиента
 */
$app->post(
    '/products',
    function ( Request $request, Response $response, $args )
    {
        $body = $request->getParsedBody();

        $data = \Core\Set::product( $body );

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse
            ->getBody()
            ->write( json_encode( $data ) );

        return $newResponse;
    }
);


/**
 * Редактировать клиента по id
 */
$app->put(
    '/products/{id}',
    function ( Request $request, Response $response, $args )
    {
        $body = $request->getParsedBody();

        $data = \Core\Set::product( $body, $args['id'] );

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse
            ->getBody()
            ->write( json_encode( $data ) );

        return $newResponse;
    }
);

/**
 *  Удалить клиента по id
 */
$app->delete(
    '/products/{id}',
    function ( Request $request, Response $response, $args )
    {
        $data = \Core\Delete::object( 'products', $args['id'] );

        if ( $data == 0 )
        {
            // id не найден

            $newResponse = $response->withStatus(404);
            return $newResponse;
        }

        // Удаление прошло успешно
        $newResponse = $response->withStatus(204);

        return $newResponse;
    }
);

/**
 * ========================================================================================================================
 * ======================================================BIK===============================================================
 * ========================================================================================================================
 */

/**
 * Получить данные о БИК
 */
$app->get(
    '/biks',
    function ( Request $request, Response $response, $args )
    {
        $data = \Core\Get::BIKs();

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse
            ->getBody()
            ->write( json_encode( $data ) );

        return $newResponse;
    }
);

/**
 * Получить данные о БИК по id
 */
$app->get(
    '/biks/{id}',
    function ( Request $request, Response $response, $args )
    {
        $data = \Core\Get::BIK( $args['id'] );

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse
            ->getBody()
            ->write( json_encode( $data ) );

        return $newResponse;
    }
);

/**
 * Добавление БИКа
 */
$app->post(
    '/biks',
    function ( Request $request, Response $response, $args )
    {
        $body = $request->getParsedBody();

        $data = \Core\Set::BIK( $body );

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse
            ->getBody()
            ->write( json_encode( $data ) );

        return $newResponse;
    }
);

/**
 * Редактировать БИК по id
 */
$app->put(
    '/biks/{id}',
    function ( Request $request, Response $response, $args )
    {
        $body = $request->getParsedBody();

        $data = \Core\Set::BIK( $body, $args['id'] );

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse
            ->getBody()
            ->write( json_encode( $data ) );

        return $newResponse;
    }
);

/**
 * Обновить базу БИКов
 */
$app->get(
    '/biks-update',
    function ( Request $request, Response $response, $args )
    {
        $body = $request->getParsedBody();

        $data = \Core\Query::updateBIKDatabase();

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse
            ->getBody()
            ->write( json_encode( $data ) );

        return $newResponse;
    }
);

/**
 * ========================================================================================================================
 * ======================================================LOGIN=============================================================
 * ========================================================================================================================
 */

/**
 * Получить токен по логину и паролю на текущую сессию
 */
$app->post(
    '/login',
    function ( Request $request, Response $response, $args )
    {
        $body = $request->getParsedBody();

        $data = \Core\Get::token( $body );

//        if ( isset( $data->token ) ) $_SESSION['token'] = $data->token;

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse
            ->getBody()
            ->write( json_encode( $data ) );

        return $newResponse;
    }
);

/**
 * Рендер окна логина
 */
$app->get(
    '/login',
    function ( Request $request, Response $response, $args )
    {
        require "login.php";
    }
);

$app->run();


