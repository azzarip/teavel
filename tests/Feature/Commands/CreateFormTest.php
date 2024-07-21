<?php

use Illuminate\Support\Facades\File;
afterEach(function() {
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
