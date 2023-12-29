<?php

namespace Azzarip\Teavel\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Support\Str;

class Contact extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable;
    use Authorizable;

    protected $fillable = [
        'name', 'surname',
        'email', 'phone',
        'privacy_at', 'marketing_at',
    ];

    protected $casts = [
        'privacy_at' => 'datetime',
        'marketing_at' => 'datetime',
    ];
    
    public function getFullNameAttribute()
    {
        return trim($this->name . ' ' . $this->surname);
    }

    protected static function booted()
    {
        parent::booted();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }
}
