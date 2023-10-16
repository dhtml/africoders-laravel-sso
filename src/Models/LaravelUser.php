<?php
namespace Africoders\SSO\Middleware;

use Illuminate\Database\Eloquent\Model;

class LaravelUserModel extends Model
{
    protected $table = 'laravel_users';
    protected $fillable = ['email'];
}