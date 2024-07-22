<?php

namespace Azzarip\Teavel\Models;

use Azzarip\Teavel\SequenceManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

        try {
            $contact->sequences()->attach($this->id);
        } catch (UniqueConstraintViolationException $e) {
            $entry = $contact->sequences()->where('sequence_id', $this->id)->first();

            if (empty($entry->pivot->stopped_at)) {
                return;
            }

            $contact->sequences()->updateExistingPivot($this->id, ['stopped_at' => null]);
        }
        SequenceManager::start($this, $contact);
    }

    public function stop(Contact $contact)
    {
        $this->contacts()->updateExistingPivot($contact->id, ['stopped_at' => now()]);
    }
}
