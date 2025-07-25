<?php

use App\Models\User;
use Azzarip\Teavel\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Azzarip\Teavel\Http\Middleware\MultiForm;

beforeEach(function () {
    Route::middleware(['web', MultiForm::class])->get('/abc/def/ghj', fn() => 'Access Granted');
    Route::get('/abc/def', fn() => 'Redirected');
});

it('redirects back one segment if not authenticated and no session', function () {
    $response = $this->get('/abc/def/ghj');

    $response->assertRedirect('/abc/def');
});

it('allows if session contact is set', function () {
    $response = $this->withSession(['contact' => true])->get('/abc/def/ghj');
    $response->assertOk()->assertSee('Access Granted');
});

it('allows if authenticated', function () {
    $contact = Contact::factory()->create();

    $response = $this->actingAs($contact)->get('/abc/def/ghj');
    $response->assertOk()->assertSee('Access Granted');
});