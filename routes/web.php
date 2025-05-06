<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Request;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/deploy-hook', function () {
    // Optional: Add a secret token check
    if (Request::get('token') !== env('DEPLOY_SECRET')) {
        abort(403, 'Unauthorized');
    }

    putenv('COMPOSER_HOME=' . base_path() . '/vendor/bin/composer');

    // Run composer install
    shell_exec('cd ' . base_path() . ' && composer install --no-interaction --prefer-dist');

    // Run Laravel migrations
    Artisan::call('migrate', ['--force' => true]);

    // Optional: Clear & cache config
    Artisan::call('config:cache');

    return response()->json(['status' => 'Deployed successfully']);
});



require __DIR__.'/auth.php';

Route::get('qr-code-g', function () {
    \QrCode::size(500)
        ->format('png')
        ->generate('https://demofan.clusterstacks.com/campaign/donate/8/MQ%3D%3D', public_path('images/qrcode.png'));
    return redirect('/images/qrcode.png');
});
Route::get('test', function () {
     return view('test');
});

require __DIR__ . '/admin.php';
require __DIR__ . '/hr.php';
