<?php
namespace Africoders\Sso;

use Flarum\Extend;
use Illuminate\Session\Store as Session;
use Illuminate\Contracts\Events\Dispatcher;

return [
    // Frontend extenders (JS)
    (new Extend\Frontend('forum'))->js(__DIR__ . '/js/dist/forum.js'),

    // Locales
    new Extend\Locales(__DIR__ . '/locale'),
    
    //dispatcher
    function (Dispatcher $events, Session $session) {
        // Your code here to access the session data
        var_dump("Dispatcher");
    },
];
