<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Filament\Import\InventoryImportController;

Route::prefix('/inventory')->group(function () {
    Route::get('/export-excel-file', function () {

        $fileName = "inventory.xlsx";
        if (file_exists(public_path($fileName))) {
            return response()->download(public_path($fileName));
        }
        abort(404);

    });
    Route::get('/import-excel-file', [InventoryImportController::class, 'import'])->name('inventory.import');
});


Route::get('/login', function () {
    return redirect()->route('filament.superAdmin.auth.login');
})->name('login')->withoutMiddleware(['auth', 'auth:web','auth:super-admins']);

Route::get('/filament/exports/{id}/download', function ($id) {
    $export = Export::findOrFail($id);
    $format = request('format', 'csv');
    $filePath = Storage::disk($export->file_disk)->path($export->file_name);
    $extension = $format === 'xlsx' ? 'xlsx' : 'csv';
    return response()->download($filePath, "export-{$id}.{$extension}");
})->middleware('auth:super-admins')->name('filament.exports.download');
