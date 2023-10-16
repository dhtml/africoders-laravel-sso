<?php
namespace Africoders\SSO;

use Flarum\Extend;
use Illuminate\Session\Store as Session;
use Illuminate\Contracts\Events\Dispatcher;

use Africoders\SSO\Middleware\SessionMiddleware;

return [
    // Frontend extenders (JS)
    (new Extend\Frontend('forum'))->js(__DIR__ . '/js/dist/forum.js'),

    // Locales
    new Extend\Locales(__DIR__ . '/locale'),
    
    (new Flarum\Extend\Middleware('forum'))
    ->add(SessionMiddleware::class),

];
