<?php

namespace Azzarip\Teavel\Models;

use Ramsey\Uuid\Uuid;
use Azzarip\Teavel\Models\Contact;
use Illuminate\Database\Eloquent\Model;

class AuthToken extends Model
{
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'uuid', 'contact_id', 'expires_at'
    ];

    protected function casts() 
    {
        return [
            'expires_at' => 'timestamp',
        ];
    }

    public static function generate(Contact $contact)
    {        
        return self::create([
            'uuid' => Uuid::uuid4()->toString(),
            'contact_id' => $contact->id,
            'expires_at' => now()->addMinute(),
        ]);
    }
    
    public static function redeem(string $token) 
    {
        $authToken = self::find($token);
        
        if(! $authToken) return;
        
        if ($authToken->is_expired) {
            $authToken->delete();
            return;
        }

        $contact = $authToken->contact;
        $authToken->delete();
        return $contact;
    }

    public function getIsExpiredAttribute(): bool 
    {
        return $this->expires_at < now();
    }

    public function getToken() 
    {
        return $this->uuid;
    }

    public function contact() {
        return $this->belongsTo(Contact::class);
    }
}
