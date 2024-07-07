<?php

use App\Models\Receipt;
use Automattic\WooCommerce\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('api')->post('/api/lead', [\App\Http\Controllers\LeadController::class, 'store']);
Route::get('/test', function (Request $request) {
    $fmt = numfmt_create('pt_BR', NumberFormatter::CURRENCY);
    return view('mail.payment', ['value' => numfmt_format_currency($fmt, 1000, 'BRL'), 'name' => 'Gustavo', 'link' => 'https://www.google.com']);
});
