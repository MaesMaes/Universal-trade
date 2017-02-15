<?php
/**
 * Created by PhpStorm.
 * User: jscheq
 * Date: 29.01.17
 * Time: 18:33
 */
function getCompanies ( Request $request, Response $response )
{
    $data = \Core\Get::companies();

    $newResponse = $response->withAddedHeader( 'Content-type', 'application/json' );

    $newResponse
        ->getBody()
        ->write( json_encode( $data ) );

    return $newResponse;
}