<?php

namespace Azzarip\Teavel\Traits;

use Azzarip\Teavel\Models\ContactSequence;
use Azzarip\Teavel\Models\Sequence;

trait HasAutomations
{
    use HasGoals;

    public function sequences()
    {
        return $this->belongsToMany(Sequence::class)
            ->using(ContactSequence::class)
            ->withPivot(['created_at', 'stopped_at']);
    }
}
