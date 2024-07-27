<?php

use Azzarip\Teavel\Models\Email;
use Azzarip\Teavel\Models\EmailFile;
use Illuminate\Support\Facades\File;
use Azzarip\Teavel\Exceptions\TeavelException;

it('throws exception if file is missing', function () {
    EmailFile::file('::test::');
})->throws(TeavelException::class);

it('retrieves email file', function () {
    $f = EmailFile::create(['file' => '::test::']);

    expect($f)->not->toBeNull();
});

it('creates a new one if file exists', function () {
    File::makeDirectory(base_path('content'), 0755, true, true);
    File::makeDirectory(base_path('content/emails'), 0755, true, true);


    file_put_contents(base_path('content/emails/test.md'), '::content::', 0755);

    $f = EmailFile::file('test');

    expect(EmailFile::count())->toBe(1);
    expect($f->file)->toBe('test');

    File::deleteDirectory(base_path('content'));
});

it('has emails', function () {
    $f = EmailFile::create(['file' => 'file']);
    $email = Email::create(['file_id' => $f->id]);

    $E = $f->emails()->first();
    expect($E)->not->toBeNull();
    expect($E->file_id)->toBe($email->id);
});
