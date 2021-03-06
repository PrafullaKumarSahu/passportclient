<?php
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('redirect', function () {
    $query = http_build_query([
        'client_id' => 7,//'client-id',
        'redirect_uri' => 'http://localhost/passportclient/public/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('http://127.0.0.1:8000/oauth/authorize?'.$query);
})->name('get.token');


Route::get('callback', function (Request $request) {
    $http = new GuzzleHttp\Client;

    $response = $http->post('http://127.0.0.1:8000/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => 7,//'client-id',
            'client_secret' => '5RteXdegxm8Vz4vvWSew9JxoNf3p3Ve2OvumCOXG',//'client-secret',
            'redirect_uri' => 'http://localhost/passportclient/public/callback',
            'code' => $request->code,
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
})->name('accept-token');