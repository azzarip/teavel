<?php

namespace Azzarip\Teavel\Traits;

use Azzarip\Teavel\Mail\TeavelMail;
use Azzarip\Teavel\Models\ContactEmail;
use Azzarip\Teavel\Models\ContactSequence;
use Azzarip\Teavel\Models\Email;
use Azzarip\Teavel\Models\Sequence;
use Illuminate\Support\Facades\Mail;

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

    public function sendEmail(string $email, null | string | int $sequence = null)
    {
        if (! $this->can_market) {
            return;
        }

        $email = Email::name($email, $sequence);

        Mail::send(new TeavelMail($this, $email));

        $pivot = $this->findPivot($email);

        if (! $pivot) {
            $this->emails()->attach($email->id, ['sent_at' => now()]);
            $pivot = $this->findPivot($email);
        } else {
            $pivot->reset();
        }

        return $this;
    }

    protected function findPivot(Email $email): ?ContactEmail
    {
        $relationship = $this->emails()->where('email_id', $email->id)->first();

        if (! $relationship) {
            return null;
        }

        return $relationship->pivot;
    }
}
