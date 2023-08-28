<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $settings = getSettings();
        return view('contact',['settings' => $settings ]);
    }
}
