<?php

namespace Azzarip\Teavel\Tests\TestModels;

use Illuminate\Auth\Authenticatable;
use Azzarip\Teavel\Traits\Contactable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

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