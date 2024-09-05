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
        return $this->name . ', ' .  $this->line1 . ', ' . $this->zip . ' ' . $this->city;
    }

    public function getTwoLinesAttribute(): string
    {
        $line1 = $this->name;
        if($this->co) {
            $line1 .= ', ' . $this->co;
        }
        $line2 =  $this->line1 . ', ' . $this->zip . ' ' . $this->city;
        return $line1 . "<br>". $line2;
    }

    public function getLabelAttribute(): string
    {
        return implode("\n", $this->toArray());
    }

    public function toArray(): array
    {
        return array_filter([
            $this->name,
            $this->co,
            $this->line1,
            $this->line2,
            $this->zip . ' ' . $this->city,
        ]);
    }

    protected static function newFactory()
    {
        return new \Azzarip\Teavel\Database\Factories\AddressFactory;
    }
}
