<?php

namespace Azzarip\Teavel\Models;

use Azzarip\Teavel\Models\Offer;
use Azzarip\Utilities\CHF\CHFCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts()
    {
        return [
            'total' => CHFCast::class,
            'margin' => CHFCast::class,
            'ordered_on' => 'date',
        ];
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function confirmInvoice(int $id)
    {
        if ($this->invoice_id) {
            return null;
        }
        $this->update(['invoice_id' => $id]);
    }

    public function getIsConfirmedAttribute()
    {
        return (bool) $this->invoice_id;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_date)) {
                $order->order_date = now();
            }
        });
    }

    public function offers(): BelongsToMany
    {
        return $this->belongsToMany(Offer::class);
    }
}
