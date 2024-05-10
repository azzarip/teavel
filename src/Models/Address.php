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

    public function remove()
    {
        $oldId = $this->id;
        $this->delete();

        $contact = $this->contact;
        $addresses = $contact->addresses;

        if (empty($addresses)) {
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
}
