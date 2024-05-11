<?php

namespace Azzarip\Teavel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function remove(): void
    {
        $oldId = $this->id;
        $this->delete();

        $contact = $this->contact;
        $addresses = $contact->addresses;

        if ($addresses->isEmpty()) {
            $contact->update([
                'shipping_id' => null,
                'billing_id' => null,
            ]);

            return;
        }

        $newId = $addresses->last()->id;
        if ($contact->billing_id == $oldId) {
            $contact->billing_id = $newId;
        }
        if ($contact->shipping_id == $oldId) {
            $contact->shipping_id = $newId;
        }
        $contact->save();
    }

    public function getOneLineAttribute(): string
    {
        return $this->address . ', ' . $this->plz . ' ' . $this->city;
    }

    public function getLabelAttribute(): string
    {
        return implode("\n", $this->toArray());
    }
    public function toArray(): array
    {
        return array_filter([
            $this->name,
            $this->address,
            $this->additional,
            $this->plz . ' ' . $this->city,
        ], fn ($value) => $value != null);
    }

    protected static function newFactory()
    {
        return new \Azzarip\Teavel\Database\Factories\AddressFactory;
    }
}
