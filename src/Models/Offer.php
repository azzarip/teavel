<?php

namespace Azzarip\Teavel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getPriceAttribute()
    {
        return (new $this->class)->getPrice();
    }

    public static function findSlug(string $slug)
    {
        return self::where('slug', $slug)->first();
    }

    public function getTitleAttribute(): string
    {
        return $this->class::TITLE;
    }

    public function getIsShippableAttribute(): bool
    {
        return $this->class::IS_SHIPPABLE;
    }

    public function getIsFreeAttribute(): bool
    {
        return is_null($this->price) || $this->price->int == 0;
    }

    public function getInterestedGoal()
    {
        return $this->class::INTERESTED_GOAL;
    }

    public function getCompletedGoal()
    {
        return $this->class::PURCHASED_GOAL;
    }

    public function getUrlAttribute()
    {
        return durl($this->slug, config('teavel.offer_domain_key'))->url();
    }
}
