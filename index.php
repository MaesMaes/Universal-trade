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
require 'classes/companies.class.php';

$config['debug'] = true;

$app = new \Slim\App(["settings" => $config]);
//$app->add(new \Slim\Csrf\Guard);

$app->get(
    '/companies',
    function ( Request $request, Response $response )  {
        $companies = new Companies(
            array(
                new Company( 5, 'Рога и рога', 'ООО Рога и рога', '654612312', '766787692', '412313', '098123598', '0458748516' ),
                new Company( 5, 'Рога и рога', 'ООО Рога и рога', '654612312', '766787692', '412313', '098123598', '0458748516' ),
                new Company( 5, 'Рога и рога', 'ООО Рога и рога', '654612312', '766787692', '412313', '098123598', '0458748516' ),
                new Company( 5, 'Рога и рога', 'ООО Рога и рога', '654612312', '766787692', '412313', '098123598', '0458748516' ),
                new Company( 5, 'Рога и рога', 'ООО Рога и рога', '654612312', '766787692', '412313', '098123598', '0458748516' ),
                new Company( 5, 'Рога и рога', 'ООО Рога и рога', '654612312', '766787692', '412313', '098123598', '0458748516' ),
            )
        );

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse->getBody()
                    ->write( json_encode( $companies ) );

        return $newResponse;
    }
);

$app->get(
    '/companies/{id}',
    function ( Request $request, Response $response, $args )  {
        $company = new Company( $args['id'], 'Рога и рога', 'ООО Рога и рога', '654612312', '766787692', '412313', '098123598', '0458748516' );

        $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

        $newResponse->getBody()
                    ->write( json_encode( $company ) );

        return $newResponse;
    }
);

$app->run();