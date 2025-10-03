<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $mood = $request->input('mood');       
        $reasons = $request->input('reasons');

        return redirect('/')->with('success', 'Thanks for your feedback!');
    }
}
