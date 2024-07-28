<?php

namespace Azzarip\Teavel\Traits;

use Azzarip\Teavel\Models\Email;
use Azzarip\Teavel\Models\Sequence;
use Azzarip\Teavel\Models\ContactEmail;
use Azzarip\Teavel\Models\ContactSequence;

trait HasAutomations
{
    use HasGoals;

    public function sequences()
    {
        return $this->belongsToMany(Sequence::class)
            ->using(ContactSequence::class)
            ->withPivot(['created_at', 'stopped_at']);
    }

    public function emails()
    {
        return $this->belongsToMany(Email::class)
            ->using(ContactEmail::class)
            ->withPivot(['sent_at', 'clicked_at']);
    }

    public function sendEmail(string $email){
        $email = Email::name($email);

        $pivot = $this->findPivot($email);

        if (! $pivot) {
            $this->emails()->attach($email->id, ['sent_at' => now()]);
            return;
        }

        $pivot->reset();

        return $this;
    }

    protected function findPivot(Email $email): ?ContactEmail
    {
        $relationship = $this->emails()->where('email_id', $email->id)->first();

        if(!$relationship) return null;

        return $relationship->pivot;
    }
}
