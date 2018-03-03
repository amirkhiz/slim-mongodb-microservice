<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 1.03.2018
 * Time: 16:51
 */

namespace App\Middlewares;

use App\Core\StatusCodes;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ResponseHandler
{
    /**
     * Handle an incoming request.
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return mixed
     */
    function __invoke(Request $request, Response $response, callable $next)
    {
        /** @var \Slim\Http\Response $response */
        $response = $next($request, $response);

        if (StatusCodes::isError($response->getStatusCode()) && StatusCodes::canHaveBody($response->getStatusCode())) {
            return $response->withJson(
                [
                    'errors' => json_decode($response->getBody()),
                ]
            );
        } elseif (StatusCodes::isError($response->getStatusCode())) {
            return $response;
        }

        return $response->withJson(
            json_decode($response->getBody()),
            $response->getStatusCode()
        );
    }
}