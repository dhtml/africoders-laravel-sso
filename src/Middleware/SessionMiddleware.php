<?php 
namespace Africoders\SSO\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SessionMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Logic to run before the request is processed and later middleware is called.
        $response = $handler->handle($request);
        // Logic to run after the request is processed.
        return $response;
    }
}