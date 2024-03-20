<?php

namespace Azzarip\Teavel\Models;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Contact extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable;
    use Authorizable;

    protected $guarded = [];

    protected $casts = [
        'privacy_at' => 'datetime',
        'marketing_at' => 'datetime',
    ];

    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public static function findByEmail(string $email)
    {
        return self::where('email', $email)->first();
    }

    protected static function booted()
    {
        parent::booted();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

public static function fromData(array $data)
{
    $email = $data['email'];
    $contact = self::findByEmail($email);

    if(!$contact) {
        $data['privacy_at'] = now();
        if(!Arr::exists($data, 'not_marketing')) {
            $data['marketing_at'] = now();
        }
        Arr::forget($data, ['privacy', 'not_marketing']);
        return self::create($data);
    }

    if(empty($contact->last_name)){$contact->last_name = $data['last_name'];}
    if(empty($contact->phone))    {$contact->phone = $data['phone'];}
    if(empty($contact->marketing_at) && !Arr::exists($data, 'not_marketing')){$contact->marketing_at = now();}

    $contact->save();
    return $contact;
}



}
