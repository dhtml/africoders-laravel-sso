<?php
namespace Africoders\Sso;

use Flarum\Extend;

return [
    // Frontend extenders (JS)
    (new Extend\Frontend('forum'))->js(__DIR__ . '/js/dist/forum.js'),

    // Locales
    new Extend\Locales(__DIR__ . '/locale'),

];
