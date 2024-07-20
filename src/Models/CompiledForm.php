<?php

namespace Azzarip\Teavel\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CompiledForm extends Pivot
{
    public $incrementing = true;

    public $timestamps = false;


    public function getUtmSourceAttribute()
    {
        $string = UTMString::find($this->utm_source_id);
        return $string ? $string->string : null;
    }

    public function getUtmMediumAttribute()
    {
        $string = UTMString::find($this->utm_medium_id);
        return $string ? $string->string : null;
    }

    public function getUtmCampaignAttribute()
    {
        $string = UTMString::find($this->utm_campaign_id);
        return $string ? $string->string : null;
    }

    public function getUtmTermAttribute()
    {
        $string = UTMString::find($this->utm_term_id);
        return $string ? $string->string : null;
    }

    public function getUtmContentAttribute()
    {
        $string = UTMString::find($this->utm_content_id);
        return $string ? $string->string : null;
    }
    public function hasTimestampAttributes($attributes = null)
    {
        return false;
    }


}
