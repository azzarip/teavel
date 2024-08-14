<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

afterEach(function () {
    File::deleteDirectory(app_path('Teavel'));
    File::deleteDirectory(base_path('content'));
});

it('creates the Teavel\Emails directory', function () {
    $this->artisan('make:teavel-mail name');
    expect(File::isDirectory(app_path('Teavel\Emails')))->toBeTrue();
});

it('creates the content\emails directory', function () {
    $this->artisan('make:teavel-mail name');
    expect(File::isDirectory(base_path('content\emails')))->toBeTrue();
});

it('creates the new class file', function () {
    $this->artisan('make:teavel-mail EmailName');
    expect(File::exists(app_path('Teavel\Emails\EmailName.php')))->toBeTrue();
});

it('creates the new content file', function () {
    $this->artisan('make:teavel-mail EmailName');
    expect(File::exists(base_path('content\emails\EmailName.md')))->toBeTrue();
});

it('creates the new file with folders', function () {
    $this->artisan("make:teavel-mail Sequence\\\\Brucchi\\\\EmailName");
    expect(File::exists(app_path('Teavel\Emails\Sequence\Brucchi\EmailName.php')))->toBeTrue();
    expect(File::exists(base_path('content\emails\Sequence\Brucchi\EmailName.md')))->toBeTrue();
});
