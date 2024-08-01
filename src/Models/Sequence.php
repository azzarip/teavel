<?php

namespace Azzarip\Teavel\Models;

use Azzarip\Teavel\Models\Automatable;
use Azzarip\Teavel\Models\ContactSequence;
use Azzarip\Teavel\Automations\SequenceHandler;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sequence extends Automatable
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    protected string $automationPath = 'Sequences';

    public function contacts()
    {
        return $this->belongsToMany(Contact::class)
            ->using(ContactSequence::class)
            ->withPivot(['created_at', 'stopped_at']);
    }

    public static function name(string $name)
    {
        $form = self::where('name', $name)->first();

        if (! $form) {
            $form = self::create([
                'name' => $name,
                'description' => 'Automatic Generated Sequence',
            ]);
        }

        return $form;
    }

    public function start(Contact $contact)
    {
        $pivot = $this->findPivot($contact);

        if (! $pivot) {
            $this->contacts()->attach($contact);
            $pivot = $this->findPivot($contact);

            return SequenceHandler::start($pivot, $contact, $this->getAutomation());
        }

        if ($pivot->is_active) {
            return;
        }

        $pivot->reset();

        return SequenceHandler::start($pivot, $contact, $this->getAutomation());
    }

    public function stop(Contact $contact)
    {
        $pivot = $this->findPivot($contact);

        if($pivot->is_active) {
            $this->contacts()->updateExistingPivot($contact->id, ['stopped_at' => now()]);
        }
    }

    protected function findPivot(Contact $contact): ?ContactSequence
    {
        $relationship = $this->contacts()->where('contact_id', $contact->id)->first();

        if(!$relationship) return null;

        return $relationship->pivot;
    }
}
