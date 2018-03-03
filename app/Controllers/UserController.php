<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 1.03.2018
 * Time: 11:47
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Core\StatusCodes;
use App\Models\User;
use App\Transformers\UserTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Slim\Http\Request;
use Slim\Http\Response;

class UserController extends Controller
{
    /**
     * Get all resources
     *
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     *
     * @return \Slim\Http\Response
     */
    public function index(Request $request, Response $response)
    {
        $users = User::get();

        $fractal   = new Manager();
        $resources = new Collection($users, new UserTransformer());

        return $response->withJson($fractal->createData($resources)->toArray());
    }

    /**
     * Get a resource with id
     *
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     * @param                     $args
     *
     * @return \Slim\Http\Response
     */
    public function show(Request $request, Response $response, $args)
    {
        $user = User::find($args['id']);

        $fractal  = new Manager();
        $resource = new Item($user, new UserTransformer());

        return $response->withJson($fractal->createData($resource)->toArray());
    }

    /**
     * Store new resource
     *
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     *
     * @return \Slim\Http\Response
     */
    public function store(Request $request, Response $response)
    {
        $input = $request->getParams(
            [
                'first_name',
                'last_name',
                'email',
                'username',
            ]
        );

        if (!(($validator = User::validator())->validate($input))) {
            return $response->withStatus(
                StatusCodes::HTTP_BAD_REQUEST,
                StatusCodes::getMessageForCode(StatusCodes::HTTP_BAD_REQUEST)
            )->withJson($this->getValidationMessages($validator));
        }

        User::create(
            [
                'firstName' => $input['first_name'],
                'lastName'  => $input['last_name'],
                'email'     => $input['email'],
                'username'  => $input['username'],
            ]
        );

        return $response->withStatus(StatusCodes::HTTP_CREATED);
    }
}