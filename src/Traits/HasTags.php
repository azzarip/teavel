<?php

namespace Azzarip\Teavel\Traits;

use Azzarip\Teavel\Models\Tag;
use Illuminate\Database\UniqueConstraintViolationException;

trait HasTags
{
    public function tags()
    {
        return $this->belongsToMany(Tag::class)
            ->withPivot('created_at');
    }

    public function tag(string $name)
    {
        $tag = Tag::name($name);

        try {
            $this->tags()->attach($tag->id);
        } catch (UniqueConstraintViolationException $e) {
            //
        } finally {
            return $this;
        }

    }

    public function detag(string $name)
    {
        $tag = Tag::name($name);
        $this->tags()->detach($tag->id);

        return $this;
    }

    public function hasTag(string $name): bool
    {
        return $this->tags()->where('name', $name)->exists();
    }
}
