<?php

use App\Models\featuredService;
use App\Models\Setting;
use App\Models\Blog;

    function getSettings()
    {
        return Setting::first();
    }

//    this methid will returns featured Services

    function getServices()
    {
        $services = featuredService::leftJoin('services','services.id','featured_services.service_id')
        ->orderBy('sort_order','ASC')
        ->get();
        return $services;
    }

    function getLatestBlog()
    {
        $blogs = Blog::where('status',1)->orderBy('created_at','DESC')->take(6)->get();
        return $blogs;
    }

?>
