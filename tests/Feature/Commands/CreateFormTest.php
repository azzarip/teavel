<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

afterEach(function () {
    File::deleteDirectory(app_path('Teavel'));
});
it('creates the teavel directory', function () {
    $this->artisan('make:teavel-form name');
    expect(File::isDirectory(app_path('Teavel')))->toBeTrue();
});

it('creates the teavel/goals directory', function () {
    $this->artisan('make:teavel-form name');
    expect(File::isDirectory(app_path('Teavel/Goals')))->toBeTrue();
});

it('creates the teavel/goals/forms directory', function () {
    $this->artisan('make:teavel-form name');
    expect(File::isDirectory(app_path('Teavel/Goals/Forms')))->toBeTrue();
});

it('creates the new file', function () {
    $this->artisan('make:teavel-form name-to_test');
    expect(File::exists(app_path('Teavel/Goals/Forms/NameToTest.php')))->toBeTrue();
});

it('substitutes correctly the stub content', function () {
    $this->artisan('make:teavel-form name-to_test');
    $fileContent = File::get(app_path('Teavel/Goals/Forms/NameToTest.php'));

    expect(Str::contains($fileContent, 'name-to_test'))->toBeTrue();
    expect(Str::contains($fileContent, 'NameToTest'))->toBeTrue();

});
