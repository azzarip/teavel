<?php

namespace Azzarip\Teavel\Models;

use Azzarip\Teavel\Traits;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Support\Str;

class Contact extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable;
    use Authorizable;
    use HasFactory;
    use Traits\HasAddresses;
    use Traits\HasGoals;
    use Traits\HasTags;

    protected $guarded = [];

    protected function casts()
    {
        return [
            'privacy_at' => 'datetime',
            'marketing_at' => 'datetime',
        ];
    }

    public function getNameEmailAttribute(): string
    {
        return $this->FullName . ' (' . $this->email . ')';
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
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
        unset($data['privacy_policy']);
        $email = $data['email'];
        $contact = self::findEmail($email);

        if (! $contact) {
            $data['privacy_at'] = now();
            return self::create($data);
        }

        unset($data['email']);
        foreach ($data as $key => $value) {
            if (empty($contact->$key)) {
                $contact->$key = $value;
            }
        }
        $contact->save();

        return $contact;
    }

    public function allowMarketing(bool $allow = true): self
    {
        if (! $allow) {
            return $this;
        }

        if ($this->marketing_at) {
            return $this;
        }

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

    public function getIsRegisteredAttribute(): bool
    {
        return (bool) $this->password;
    }

    protected static function newFactory()
    {
        return new \Azzarip\Teavel\Database\Factories\ContactFactory;
    }
}
