<?php
namespace Africoders\SSO\Middleware;

use Africoders\SSO\Services\ConfigService;
use Africoders\SSO\Services\SessionService;
use Flarum\User\UserRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\RedirectResponse;

class SessionMiddleware implements MiddlewareInterface
{

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Logic to run before the request is processed and later middleware is called.
        $response = $handler->handle($request);

        $logout_url = resolve('flarum.forum.routes')->getPath('logout');
        $path = $request->getUri()->getPath();

        if($path === $logout_url) {
            //logout url has been hit - session invalid at this point
            $logoutUrl = ConfigService::getLogoutUrl();
            header("Location: $logoutUrl");
            exit();
        }

        //synchronize user state
        $sessionService = new SessionService($this->users);
        $userState = $sessionService->getUserState($request);

        if($userState['action']==="login") {
            //forum login
            $result =  $sessionService->authenticateByEmail($userState['userEmail'], $request->getAttribute('session'));
            if($result) {
                return new RedirectResponse("/");
            }
        } else if($userState['action']==="logout") {
            //forum logout
            $sessionService->logoutUser($request->getAttribute('session'));
            return new RedirectResponse("/");
        }


        // Logic to run after the request is processed.
        return $response;
    }
}