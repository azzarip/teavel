<?php

namespace Azzarip\Teavel\Models;

use Azzarip\Teavel\Exceptions;
use Illuminate\Database\Eloquent\Model;
use Azzarip\Teavel\Models\ContactSequence;
use Azzarip\Teavel\Automations\SequenceHandler;
use Azzarip\Teavel\Exceptions\MissingClassException;
use Azzarip\Teavel\Exceptions\BadMethodCallException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\UniqueConstraintViolationException;

class Sequence extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

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

        if(!$pivot) {
            $this->contacts()->attach($contact);
            $pivot = $this->findPivot($contact);
            return SequenceHandler::start($pivot, $contact, $this);
        }

        if($pivot->is_active) return;

        $pivot->reset();
        return SequenceHandler::start($pivot, $contact, $this);
    }

    public function stop(Contact $contact)
    {
        $this->contacts()->updateExistingPivot($contact->id, ['stopped_at' => now()]);
    }

    protected function findPivot(Contact $contact)
    {
       return $this->contacts()->where('contact_id', $contact->id)->first()->pivot;
    }

}
