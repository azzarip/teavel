<?php

namespace Azzarip\Teavel\Models;

use Azzarip\Teavel\Traits;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Contact extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable;
    use Authorizable;
    use HasFactory;
    use Traits\HasAddresses;
    protected $guarded = [];
    protected $casts = [
        'privacy_at' => 'datetime',
        'marketing_at' => 'datetime',
    ];

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function getInfoAttribute(): string
    {
        return $this->FullName . ' (' . $this->email . ')';
    }

    public static function findEmail(string $email)
    {
        return self::where('email', $email)->first();
    }

    public static function findPhone(string $phone)
    {
        return self::where('phone', $phone)->first();
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
        $contact = self::findEmail($email);

        if (! $contact) {
            $data['privacy_at'] = now();
            unset($data['privacy']);
            return self::create($data);
        }

        if (empty($contact->last_name)) {
            $contact->last_name = $data['last_name'];
        }
        if (empty($contact->phone)) {
            $contact->phone = $data['phone'];
        }


        $contact->save();

        return $contact;
    }

    public function allowMarketing(bool $allow = true): self
    {
        if (!$allow) return $this;

        if($this->marketing_at) return $this;

        $this->update(['marketing_at' => now()]);

        return $this;
    }

    public function getMarketingAtAttribute($value)
    {
        return $value ? \Illuminate\Support\Carbon::parse($value) : null;
    }

    public function getCanMarketAttribute(): bool
    {
        return (bool) $this->marketing_at;
    }

    protected static function newFactory()
    {
        return new \Azzarip\Teavel\Database\Factories\ContactFactory;
    }

}
