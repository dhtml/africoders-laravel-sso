<?php 
namespace Africoders\SSO\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Flarum\Http\Middleware\MiddlewareInterface;
use Illuminate\Contracts\Session\Session;

class SessionMiddleware implements MiddlewareInterface
{
    protected $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function process(Request $request, Handler $handler)
    {
        // Your middleware logic here
        // This code will be executed every time a page loads

        return $handler->handle($request);
    }
}