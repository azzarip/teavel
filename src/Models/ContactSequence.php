<?php

namespace Azzarip\Teavel\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Carbon;

class ContactSequence extends Pivot
{
    protected function cast()
    {
        return [
            'execute_at' => 'datetime',
            'stopped_at' => 'datetime',
        ];
    }

    public function reset()
    {
        $this->stopped_at = null;
        $this->execute_at = null;
        $this->step = null;
        $this->created_at = now();
        $this->save();

        return $this;
    }

    public function stop()
    {
        $this->stopped_at = now();
        $this->save();

        return $this;
    }


    public static function getReadySteps()
    {
        return self::ready()->get();
    }

    protected static function ready()
    {
        return self::whereNull('stopped_at')
            ->whereNotNull('execute_at')
            ->where('execute_at', '<=', Carbon::now());
    }

    public function getIsStoppedAttribute()
    {
        return (bool) $this->stopped_at;
    }

    public function getIsActiveAttribute()
    {
        return ! (bool) $this->stopped_at;
    }

    public function getIsStalledAttribute()
    {
        return $this->is_active
        && $this->step
        && empty($this->execute_at)
        && $this->updated_at->lt(Carbon::now()->subMinutes(5));
    }

    public function getIsWaitingAttribute()
    {
        return $this->is_active
        && $this->execute_at
        && $this->step;
    }

    public function getIsWorkingAttribute()
    {
        return $this->is_active
        && $this->step
        && empty($this->execute_at)
        && $this->updated_at->gt(Carbon::now()->subMinutes(5));
    }
}
