<?php
namespace Africoders\SSO\Models;

use Carbon\Carbon;
use Flarum\Database\AbstractModel;
use Flarum\Group\Group;
use Illuminate\Database\Eloquent\Relations;

class PivotUserModel extends AbstractModel
{
    protected $table = 'users_pivot';
}