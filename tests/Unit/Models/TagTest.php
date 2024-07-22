<?php

use Azzarip\Teavel\Models\Tag;

it('returns tag by name', function () {
    $tag1 = Tag::create(['name' => 'test']);
    $tag2 = Tag::name('test');

    expect($tag1->id)->toBe($tag2->id);
});

it('creates a new tag if does not exist', function () {
    Tag::name('test');

    expect(Tag::count())->toBe(1);
});

test('new tag has category Unassigned', function () {
    $tag = Tag::name('test');

    expect($tag->category->name)->toBe('unassigned');
});
