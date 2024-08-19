<?php

namespace Azzarip\Teavel\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class AuthContact extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPassword
{
    use Authorizable;
    use Authenticatable;

    public function getEmailForPasswordReset() {
        return $this->email;
    }

    public function sendPasswordResetNotification($token) {
        return;
    }
}
