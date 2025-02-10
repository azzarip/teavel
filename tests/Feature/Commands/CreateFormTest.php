<?php

use Illuminate\Support\Facades\File;

afterEach(function () {
    File::deleteDirectory(app_path('Teavel'));
});

it('creates the Teavel/Goals/Forms directory', function () {
    $this->artisan('make:teavel-form name');
    expect(File::isDirectory(app_path('Teavel/Goals/Forms')))->toBeTrue();
});

it('creates the new file', function () {
    $this->artisan('make:teavel-form NameToTest');
    expect(File::exists(app_path('Teavel/Goals/Forms/NameToTest.php')))->toBeTrue();
});

it('creates the new file with folders', function () {
    $this->artisan('make:teavel-form Example\\\\Brucchi\\\\EmailName');
    expect(File::exists(app_path('Teavel\Goals\Forms\Example\Brucchi\EmailName.php')))->toBeTrue();
});
