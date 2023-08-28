<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faq = Faq::orderBy('created_at','DESC')->where('status',1)->get();
        return view('faq',['faq' => $faq]);

    }
}
