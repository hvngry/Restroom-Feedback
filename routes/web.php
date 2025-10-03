<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome'); // smiley page
});

Route::get('/questions', function () {
    return view('questions'); // questions page
});

Route::get('/thanks', function () {
    return view('thanks'); // thanks page
});

Route::get('/initial', function () {
    return view('initial'); // set-up page
});

Route::post('/feedback-submit', [FeedbackController::class, 'store'])->name('feedback.submit');

