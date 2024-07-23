<?php

namespace Azzarip\Teavel\Models;

use Azzarip\Teavel\Exceptions;
use Azzarip\Teavel\SequenceRouter;
use Illuminate\Database\Eloquent\Model;
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
        if($this->saveEntry($contact)) {
            $this->startSequence($contact);
        }
    }

    public function stop(Contact $contact)
    {
        $this->contacts()->updateExistingPivot($contact->id, ['stopped_at' => now()]);
    }

    protected function saveEntry(Contact $contact)
    {
        try {
            $contact->sequences()->attach($this->id);
        } catch (UniqueConstraintViolationException $e) {
            $entry = $contact->sequences()->where('sequence_id', $this->id)->first();

            if (empty($entry->pivot->stopped_at)) {
                return false;
            }

            $contact->sequences()->updateExistingPivot($this->id, ['stopped_at' => null]);
        }

        return true;
    }

    protected function startSequence(Contact $contact)
    {
        $Name = ns_case($this->name);
        $className = 'App\\Teavel\\Sequences\\' . $Name;

        if (! class_exists($className)) {
            throw new MissingClassException("Sequence $Name class not found!");
        }

        try {
            $className::start($contact);
        } catch (\BadMethodCallException $e) {
            throw new BadMethodCallException("Sequence $Name does not have a start method!");
        }
    }
}
