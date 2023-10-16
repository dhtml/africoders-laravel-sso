<?php
namespace Africoders\SSO\Middleware;

use Illuminate\Database\Eloquent\Model;

class SessionModel extends Model
{
    protected $table = ' laravel_sessions';
    protected $fillable = ['id'];
}