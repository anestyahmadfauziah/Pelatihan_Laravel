
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BranchMapController;

Route::get('/profil', function () {
    return 'Halo, saya mahasiswa.';
});

Route::get('/profil/{nesty}', function ($nesty) {
    return 'Hallooo, saya ' . $nesty;
});

Route::get('/peta', [BranchMapController::class, 'index']);
