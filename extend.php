<?php
namespace Africoders\SSO;

use Flarum\Extend;
use Illuminate\Session\Store as Session;
use Illuminate\Contracts\Events\Dispatcher;

use Africoders\SSO\Middleware\SessionMiddleware;
use Africoders\SSO\Controllers\DHTMLSSOController;

return [
    // Frontend extenders (JS)
    (new Extend\Frontend('forum'))->js(__DIR__ . '/js/dist/forum.js'),

    // Locales
    new Extend\Locales(__DIR__ . '/locale'),

    (new Extend\Middleware('forum'))
        ->add(SessionMiddleware::class),

    // Routes
    (new Extend\Routes('forum'))->get('/africoders-sso', 'africoders-laravel-sso.sso-auth', DHTMLSSOController::class),

];
