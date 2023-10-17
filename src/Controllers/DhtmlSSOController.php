<?php

namespace Africoders\SSO\Controllers;

use Africoders\SSO\Services\SessionService;
use Africoders\SSO\Services\ConfigService;
use Flarum\User\UserRepository;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;

class DHTMLSSOController implements RequestHandlerInterface
{

    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    final public function handle(Request $request): ResponseInterface
    {
        $sessionService = new SessionService($this->users);

        $query = $request->getQueryParams();
        $action = $query['action'] ?? null;

        $userState = $sessionService->getUserState($request);

        if($userState['action']==="login") {
            //forum login
           //$result =  $sessionService->authenticateByEmail($userState['userEmail'], $request->getAttribute('session'));
        } else if($userState['action']==="logout") {
            //forum logout
            //$sessionService->logoutUser($request->getAttribute('session'));
        }

        return new JsonResponse($userState);
    }
}
