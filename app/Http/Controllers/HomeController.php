<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\page;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::where('status',1)->orderBy('created_at','DESC')->paginate(6);
        $data['services'] = $services;
        return View('home',$data);
    }

    public function about()
    {
        $page = page::where('id',3)->first();
        return View('static-page', ['page' => $page]);
    }

    public function terms()
    {
        $page = page::where('id',4)->first();
        return View('static-page', ['page' => $page]);
    }

    public function privacy()
    {
        $page = page::where('id',5)->first();
        return view('static-page', ['page' => $page]);
    }

    public function contact(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=> 'required',
            'email'=> 'required',
            'message'=> 'required',
        ]);

        if($validator->passes())
        {
            $contact = Contact::insert([
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message,
            ]);
            Session()->flash('success','Your Message sent successfully');
            return response()->json([
                'status' => '200',
            ]);
        }
        else
        {
            return response()->json([
                'status' => '0',
                'errors' => $validator->errors(),
            ]);
        }
    }

}
