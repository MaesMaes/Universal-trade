<?php
/**
 * Created by PhpStorm.
 * User: jscheq
 * Date: 05.01.17
 * Time: 2:50
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
require 'api/core.php';

// Конфигурируем и инициализируем сервис
$configuration = array(
    'debug' => true,
    'displayErrorDetails' => true
);
$app = new \Slim\App(["settings" => $configuration]);

/**
 * Получить список компаний в JSON
 */
$app->get(
    '/companies',
    function ( Request $request, Response $response )
    {
        $companies = \Core\Get::companies();

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse->getBody()
                    ->write( json_encode( $companies ) );

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
        $company = \Core\Get::company( $args['id'] );

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse->getBody()
                    ->write( json_encode( $company ) );

        return $newResponse;
    }
);

/**
 * Получить список пользователей в JSON
 */
$app->get(
    '/users',
    function ( Request $request, Response $response )
    {
        $users = \Core\Get::users();

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse->getBody()
            ->write( json_encode( $users ) );

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
        $user = \Core\Get::user( $args['id'] );

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse->getBody()
            ->write( json_encode( $user ) );

        return $newResponse;
    }
);

$app->run();