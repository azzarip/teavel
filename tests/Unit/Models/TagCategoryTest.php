<?php

use Azzarip\Teavel\Models\TagCategory;

it('returns category by name', function () {
    $ctag1 = TagCategory::create(['name' => 'test']);
    $ctag2 = TagCategory::name('test');

    expect($ctag1->id)->toBe($ctag2->id);
});

it('creates a new tag if does not exist', function () {
    TagCategory::name('test');

    expect(TagCategory::count())->toBe(1);
});
