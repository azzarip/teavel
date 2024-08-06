<?php

namespace Azzarip\Teavel\Models;

use Azzarip\Teavel\Traits;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class Contact extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable;
    use Authorizable;
    use HasFactory;
    use Traits\HasAddresses;
    use Traits\HasAutomations;
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

    public static function findUuid(string $uuid)
    {
        return self::where('uuid', $uuid)->first();
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
        return self::add($data);
    }

    public static function add(array $data)
    {
        unset($data['privacy_policy']);
        $data['privacy_at'] = now();

        if (array_key_exists('marketing', $data)) {
            $data['marketing_at'] = now();
            unset($data['marketing']);
        }

        $contact = self::retrieve($data);

        if (! $contact) {
            return self::create($data);
        }

        return $contact->fillMissing($data);
    }


    protected function fillMissing(array $data)
    {
        foreach ($data as $key => $value) {
            if (empty($this->$key)) {
                $this->$key = $value;
            }
        }
        $this->save();
        return $this;
    }

    public static function register(array $data)
    {
        unset($data['privacy_policy']);
        $data['privacy_at'] = now();

        if (array_key_exists('marketing', $data)) {
            $data['marketing_at'] = now();
            unset($data['marketing']);
        }

        $clearPassword = $data['password'];
        $data['password'] = bcrypt($clearPassword);


        $contact = self::retrieve($data);

        if(! $contact) {
            return self::create($data);
        }

        if ($contact->isRegistered) {
            throw ValidationException::withMessages(['email' => 'User already registered.']);
        }

        return $contact->fillMissing($data);
        }

    public static function retrieve(array $data)
    {
        $contact = self::findEmail($data['email']);

        if($contact) return $contact;

        if(! config('teavel.check_phone')) return;

        return self::findPhone($data['phone']);
    }

    public function allowMarketing(bool $allow = true): self
    {
        if (! $allow) {
            return $this;
        }

        if ($this->can_market) {
            return $this;
        }

        $this->update(['marketing_at' => now()]);

        return $this;
    }

    public function disableMarketing()
    {
        if ($this->marketing_at) {
            $this->update(['marketing_at' => null]);

            return true;
        }

        return false;
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
