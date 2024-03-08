<?php

use Auth0\Laravel\Facade\Auth0;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $user = auth()->user();
    $name = $user->nickname ?? '';

    $data = [
        'name' => $name,
    ];
    return view('welcome', $data);
});

Route::get('/private', function () {
    return response('Welcome! You are logged in.');
})->middleware('auth');

Route::get('/scope', function () {
    return response('You have `read:messages` permission, and can therefore access this resource.');
})->middleware('auth')->can('read:messages');

Route::get('/colors', function () {
    $endpoint = Auth0::management()->users();

    $colors = ['red', 'blue', 'green', 'black', 'white', 'yellow', 'purple', 'orange', 'pink', 'brown'];

    $endpoint->update(
        id: auth()->id(),
        body: [
            'user_metadata' => [
                'color' => $colors[random_int(0, count($colors) - 1)]
            ]
        ]
    );

    $metadata = $endpoint->get(auth()->id()); // Retrieve the user's metadata.
    $metadata = Auth0::json($metadata); // Convert the JSON to a PHP array.

    $color = $metadata['user_metadata']['color'] ?? 'unknown';
    $name = auth()->user()->name;

    return response("Hello {$name}! Your favorite color is {$color}.");
})->middleware('auth');
