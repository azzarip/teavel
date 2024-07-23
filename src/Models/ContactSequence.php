<?php

namespace Azzarip\Teavel\Models;

use Azzarip\Teavel\Exceptions;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ContactSequence extends Pivot
{    
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
    
    public function start()
    {
        $Name = ns_case($this->name);
        $className = 'App\\Teavel\\Sequences\\' . $Name;

        if (! class_exists($className)) {
            throw new MissingClassException("Sequence $Name class not found!");
        }

        try {
            (new $className($this, $contact))->start();
        } catch (\BadMethodCallException $e) {
            throw new BadMethodCallException("Sequence $Name does not have a start method!");
        }
    }

    public function reset()
    {
        $this->stopped_at = null;
        $this->execute_at = null;
        $this->step = null;
        $this->created_at = now();
        $this->save();
    }
    
}
