<?php
namespace Africoders\SSO;

use Flarum\Extend;

use Africoders\SSO\Listener\ActivateUser;
use Africoders\SSO\Listener\AddLogoutRedirect;
use Africoders\SSO\Listener\LoadSettingsFromDatabase;
use Africoders\SSO\Listener\ProviderModeListener;
use Africoders\SSO\Listener\UserUpdated;
use Africoders\SSO\Middleware\SessionMiddleware;

use Africoders\SSO\Controllers\DHTMLSSOController;

return [
    // Frontend extenders (JS)
    (new Extend\Frontend('forum'))->js(__DIR__ . '/js/dist/forum.js'),

    // Locales
    new Extend\Locales(__DIR__ . '/locale'),


    //add session middleware
    (new Extend\Middleware('forum'))
        ->add(SessionMiddleware::class),

    // Routes
    (new Extend\Routes('forum'))->get('/africoders-sso', 'africoders-laravel-sso.sso-auth', DHTMLSSOController::class),

];
