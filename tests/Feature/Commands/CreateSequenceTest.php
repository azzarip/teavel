<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

afterEach(function () {
    File::deleteDirectory(app_path('Teavel'));
});
it('creates the teavel directory', function () {
    $this->artisan('make:teavel-sequence name');
    expect(File::isDirectory(app_path('Teavel')))->toBeTrue();
});

it('creates the teavel/sequences directory', function () {
    $this->artisan('make:teavel-sequence name');
    expect(File::isDirectory(app_path('Teavel/Sequences')))->toBeTrue();
});

it('creates the new file', function () {
    $this->artisan('make:teavel-sequence name-to_test');
    expect(File::exists(app_path('Teavel/Sequences/NameToTest.php')))->toBeTrue();
});

it('substitutes correctly the stub content', function () {
    $this->artisan('make:teavel-sequence name-to_test');
    $fileContent = File::get(app_path('Teavel/Sequences/NameToTest.php'));

    expect(Str::contains($fileContent, 'name-to_test'))->toBeTrue();
    expect(Str::contains($fileContent, 'NameToTest'))->toBeTrue();

});
