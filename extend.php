<?php
namespace Africoders\SSO;

use Flarum\Extend;

use Africoders\SSO\Listener\AddLogoutRedirect;
use Africoders\SSO\Listener\LoadSettingsFromDatabase;

use Africoders\SSO\Middleware\SessionMiddleware;

use Africoders\SSO\Controllers\DHTMLSSOController;

return [
    // Frontend extenders (JS)
    (new Extend\Frontend('forum'))
        ->js(__DIR__ . '/js/dist/forum.js')
        ->css(__DIR__ . '/less/forum.less'),

    // Locales
    new Extend\Locales(__DIR__ . '/locale'),

    (new Extend\Event())
        ->listen(LoggedOut::class, [AddLogoutRedirect::class, 'addLogoutRedirect'])
        ->subscribe(LoadSettingsFromDatabase::class),

    //add session middleware
    (new Extend\Middleware('forum'))
        ->add(SessionMiddleware::class),

    // Routes
    (new Extend\Routes('forum'))->get('/africoders-sso', 'africoders-laravel-sso.sso-auth', DHTMLSSOController::class),

];
