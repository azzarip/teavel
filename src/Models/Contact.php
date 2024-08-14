<?php

namespace Azzarip\Teavel\Models;

use Azzarip\Teavel\Traits;
use Illuminate\Support\Str;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Contact extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable;
    use Authorizable;
    use HasFactory;
    use Traits\HasPrivacy;
    use Traits\HasAddresses;
    use Traits\HasAutomations;
    use Traits\HasTags;

    protected $guarded = [];

    protected $casts = [
        'privacy_at' => 'datetime',
        'marketing_at' => 'datetime',
        'opt_in' => 'boolean',
    ];


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
        return self::process($data);
    }

    public static function process(array $data)
    {
        unset($data['privacy_policy']);
        $data['privacy_at'] = now();
        $data['opt_in'] = true;

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
        $data['opt_in'] = true;

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

    public function getIsRegisteredAttribute(): bool
    {
        return (bool) $this->password;
    }

    protected static function newFactory()
    {
        return new \Azzarip\Teavel\Database\Factories\ContactFactory;
    }
}
