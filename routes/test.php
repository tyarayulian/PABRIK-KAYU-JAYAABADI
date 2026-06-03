<?php

use Illuminate\Support\Facades\Route;

Route::get('/test-upload', function () {
    return view('test-upload');
})->name('test.upload');

Route::post('/test-upload', function () {
    if (request()->hasFile('test_file')) {
        $file = request()->file('test_file');
        $path = $file->storeAs('test', 'test_'.time().'.'.$file->extension(), 'public');

        return response()->json([
            'success' => true,
            'message' => 'File berhasil diupload',
            'path' => $path,
            'url' => asset('storage/'.$path),
        ]);
    }

    return response()->json(['success' => false, 'message' => 'File tidak ditemukan'], 400);
})->name('test.upload.post');
