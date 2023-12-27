<?php

namespace Azzarip\Teavel\Tests\TestModels;

use Azzarip\Teavel\Traits\Contactable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable;
    use Authorizable;
    use Contactable;

    protected $fillable = [
        'name', 'surname',
        'email',
    ];

    public $timestamps = false;

    protected $table = 'users';
}
