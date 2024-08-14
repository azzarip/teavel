<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

afterEach(function () {
    File::deleteDirectory(app_path('Teavel'));
});
it('creates the Teavel/Sequences directory', function () {
    $this->artisan('make:teavel-sequence name');
    expect(File::isDirectory(app_path('Teavel/Sequences')))->toBeTrue();
});


it('creates the new class file', function () {
    $this->artisan('make:teavel-sequence NameToTest');
    expect(File::exists(app_path('Teavel/Sequences/NameToTest.php')))->toBeTrue();
});

it('creates the new file with folders', function () {
    $this->artisan("make:teavel-sequence Example\\\\Brucchi\\\\EmailName");
    expect(File::exists(app_path('Teavel\Sequences\Example\Brucchi\EmailName.php')))->toBeTrue();
});
