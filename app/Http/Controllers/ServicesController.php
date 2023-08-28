<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServicesController extends Controller
{
    public function index()
    {
        $services = Service::where('status',1)->orderBy('created_at','DESC')->get();
        $data['services'] = $services;
        return view('services',$data);
    }

    public function detail($id)
    {
        $service = Service::where('id',$id)->first();
        if(empty($service))
        {
            return redirect('/');
        }
        $data['service'] = $service;
        return view('service-detail',$data);
    }
}
