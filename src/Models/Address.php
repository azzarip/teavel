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

    public function getIsShippingAttribute() {
        return (bool) ($this->contact?->shipping_id === $this->id);
    }

    public function getIsBillingAttribute() {
        return (bool) ($this->contact?->billing_id === $this->id);
    }

    public function getOneLineAttribute(): string
    {
        return $this->name . ', ' .  $this->line1 . ', ' . $this->zip . ' ' . $this->city;
    }

    public function getTwoLinesAttribute(): string
    {
        $row1 = $this->name;
        if($this->co) {
            $row1 .= ', ' . $this->co;
        }
        $row2 =  $this->line1 . ', ' . $this->zip . ' ' . $this->city;
        return $row1 . "<br>". $row2;
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
