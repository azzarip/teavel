<?php

namespace Azzarip\Teavel\Models;

use Illuminate\Database\Eloquent\Model;

class EmailUnsubscribe extends Model
{
    public $timestamps = false;

    protected $fillable = ['contact_id', 'email_id', 'created_at'];

    protected function cast()
    {
        return [
            'created_at' => 'datetime',
        ];
    }
}
