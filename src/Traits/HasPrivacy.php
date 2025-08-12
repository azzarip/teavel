<?php

namespace Azzarip\Teavel\Traits;

use Illuminate\Support\Carbon;

trait HasPrivacy
{
    public function allowMarketing(bool $allow = true): self
    {
        if (! $allow) {
            return $this;
        }

        if ($this->can_market) {
            return $this;
        }

        $this->update(['marketing_at' => now()]);

        return $this;
    }

    public function disableMarketing()
    {
        if ($this->marketing_at) {
            $this->update(['marketing_at' => null]);

            return true;
        }

        return false;
    }

    public function getMarketingAtAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }

    public function getCanMarketAttribute(): bool
    {
        return (bool) $this->marketing_at;
    }

    public function canReceiveEmail(): bool
    {
        return $this->opt_in;
    }

    public function emailOptOut()
    {
        $this->update(['opt_in' => false]);

        return $this;
    }
}
