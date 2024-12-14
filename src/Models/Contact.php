<?php

namespace Azzarip\Teavel\Models;

use Azzarip\Teavel\Actions\Contact\MutateData;
use Azzarip\Teavel\Traits;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Azzarip\Teavel\Exceptions\RegistrationException;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends AuthContact
{
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


    public static function get(array $data)
    {
        $contact = self::retrieve($data);

        $data = MutateData::mutate($data);
        if (! $contact) {
            return self::create($data);
        }

        return $contact->fillMissing($data);
    }

    public static function register(array $data)
    {
        $contact = self::retrieve($data);

        $data = MutateData::mutate($data);
        if(! $contact) {
            return self::create($data);
        }

        if ($contact->isRegistered) {
            throw new RegistrationException('User already registered.');
        }

        return $contact->fillMissing($data);
    }

    public function getNameEmailAttribute(): string
    {
        return $this->FullName . ' (' . $this->email . ')';
    }

    public function getNamePhoneAttribute(): string
    {
        return $this->FullName . ' (' . $this->phone . ')';
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
        return self::get($data);
    }

    public function fillMissing(array $data)
    {
        foreach ($data as $key => $value) {
            if (empty($this->$key)) {
                $this->$key = $value;
            }
        }
        $this->save();
        return $this;
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

    public static function emailStatus(string $email) {
        $contact = self::findEmail($email);

        if(! $contact) return 'new';

        if($contact->isRegistered) return 'login';

        return 'password';
    }

    protected static function newFactory()
    {
        return new \Azzarip\Teavel\Database\Factories\ContactFactory;
    }
}
