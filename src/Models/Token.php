<?php

namespace Africoders\SSO\Models;

use Carbon\Carbon;
use Flarum\Database\AbstractModel;
use Illuminate\Support\Str;
use Flarum\Http\AccessToken;

/**
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property Carbon $created_at
 * @property Carbon $expires_at
 * @property bool $remember
 */
class Token extends AccessToken
{
    protected $table = 'access_tokens';

    protected $dates = [
        'created_at',
        'expires_at',
    ];


    public static function deleteOldTokens(int $lifetime = 5)
    {
        static::query()->where('expires_at', '<', Carbon::now()->subMinutes($lifetime)->subDay())->delete();
    }

    public function isExpired()
    {
        return $this->expires_at->lt(Carbon::now());
    }
}