<?php

namespace Azzarip\Teavel\Traits;

use Azzarip\Teavel\Models\Note;

trait HasNotes
{
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function createNote(string $text)
    {
        return Note::create( [
            'contact_id' => $this->id,
            'text' => $text,
        ]);
    }
}
