<?php 

it('sets cookie and redirects back for supported locale', function () {
    $response = $this->from('/previous-page')->get('/set-locale/it');

    $response->assertPlainCookie('lang', 'it');
    $response->assertRedirect('/previous-page');
});

it('returns 404 for invalid format (uppercase)', function () {
    $response = $this->get('/set-locale/EN');
    $response->assertNotFound();
});

it('returns 404 for invalid format (too long)', function () {
    $response = $this->get('/set-locale/english');
    $response->assertNotFound();
});

it('returns 400 for unsupported locale', function () {
    $this->withoutExceptionHandling();

    $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);
    $this->expectExceptionMessage("Unsupported locale: xx");

    $this->from('/back')->get('/set-locale/xx');
});

it('redirects to custom path and sets lang cookie', function () {
    $response = $this->get('/set-locale/it/some/path');

    $response->assertRedirect('/some/path');
    $response->assertPlainCookie('lang', 'it');
});