<?php

namespace Azzarip\Teavel\Traits;

use Azzarip\Teavel\Models\Tag;

trait HasTags
{
    public function tags()
    {
        return $this->belongsToMany(Tag::class)
            ->withPivot('tagged_at');
    }

    public function tag(string $name)
    {
        $tag = Tag::name($name);
        $this->tags()->attach($tag->id);

        return $this;
    }

    public function detag(string $name)
    {
        $tag = Tag::name($name);
        $this->tags()->detach($tag->id);

        return $this;
    }
}
