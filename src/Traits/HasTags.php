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

    public function hasNotTag(string $name): bool
    {
        return !$this->hasTag($name);
    }

    public function hasTags(array $tags): array
    {
        $tagIds = Tag::whereIn('name', $tags)->pluck('id', 'name');

        $existingTagIds = $this->tags()->whereIn('tags.id', $tagIds->values())->pluck('tags.id')->toArray();
    
        return collect($tags)->mapWithKeys(function ($tagName) use ($tagIds, $existingTagIds) {
            return [$tagName => in_array($tagIds[$tagName] ?? null, $existingTagIds)];
        })->toArray();
    }
}
