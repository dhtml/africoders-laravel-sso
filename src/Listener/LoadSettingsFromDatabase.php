<?php

namespace Africoders\SSO\Listener;

use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Contracts\Events\Dispatcher;

class LoadSettingsFromDatabase
{
    /** @var SettingsRepositoryInterface */
    private $settings;

    public function __construct(SettingsRepositoryInterface $settings)
    {
        $this->settings = $settings;
    }

    final public function subscribe(Dispatcher $events): void
    {

    }
}
