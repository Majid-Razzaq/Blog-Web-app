<?php

use Illuminate\Support\Facades\Route;
use app\Http\Controllers\admin\adminLoginController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\admin\ServiceController;
use App\Http\Controllers\admin\TempImageController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[HomeController::class,'index']);
Route::get('/about-us',[HomeController::class,'about'])->name('about');;
Route::get('/terms',[HomeController::class,'terms'])->name('terms');
Route::get('/privacy',[HomeController::class,'privacy'])->name('privacy');;
Route::get('/services',[ServicesController::class,'index']);
Route::get('/services/detail/{id}',[ServicesController::class,'detail']);

Route::get('/faq',[FaqController::class,'index']);

Route::get('/blog',[BlogController::class,'index'])->name('blog.front');
Route::get('/contact',[ContactController::class,'index']);
Route::get('/blog/detail/{id}',[BlogController::class,'detail'])->name('blog-details');
Route::post('/save-comment',[BlogController::class,'saveComment'])->name('save.blog');
Route::post('/form/save',[HomeController::class,'contact'])->name('form.save');


Route::group(['prefix'=>'admin'],function(){

    // we call middleware here

    Route::group(['middleware'=> 'admin.guest'], function(){
//  here we will define guest route

        Route::get('/login',[App\Http\Controllers\admin\adminLoginController::class,'index'])->name('admin.login');
        Route::post('/login',[App\Http\Controllers\admin\adminLoginController::class,'authenticate'])->name('admin.auth');

    });

    Route::group(['middleware'=> 'admin.auth'], function(){
//  here we will define password protected route

        //Route::view('/dashboard','admin.dashboard')->name('admin.dashboard');
        Route::get('/dashboard',[DashboardController::class,'index'])->name('admin.dashboard');
        Route::get('/logout',[App\Http\Controllers\admin\adminLoginController::class,'logout'])->name('admin.logout');

        Route::get('/services/create',[App\Http\Controllers\admin\ServiceController::class,'create'])->name('service.create.form');

        Route::post('/services/create',[App\Http\Controllers\admin\ServiceController::class,'save'])->name('service.create');

        // Route::get('/services/create',[App\Http\Controllers\admin\ServiceController::class,'create']);
        Route::post('/temp/upload',[App\Http\Controllers\admin\TempImageController::class,'upload'])->name('tempUpload');
        Route::get('/services',[App\Http\Controllers\admin\ServiceController::class,'index'])->name('serviceList');
        Route::get('/services/edit/{id}',[App\Http\Controllers\admin\ServiceController::class,'edit'])->name('service.edit');

        Route::post('/services/edit/{id}',[App\Http\Controllers\admin\ServiceController::class,'update'])->name('service.edit.update');

        Route::post('/services/delete/{id}',[App\Http\Controllers\admin\ServiceController::class,'delete'])->name('service.delete');

        // Blog routing start
        Route::get('/blog/create',[App\Http\Controllers\admin\BlogController::class,'create'])->name('blog.create.form');
        Route::post('/blog/create',[App\Http\Controllers\admin\BlogController::class,'save'])->name('blog.save');
        Route::get('/blog',[App\Http\Controllers\admin\BlogController::class,'index'])->name('blogList');
        Route::get('/blog/edit/{id}',[App\Http\Controllers\admin\BlogController::class,'edit'])->name('blog.edit');
        Route::post('/blog/edit/{id}',[App\Http\Controllers\admin\BlogController::class,'update'])->name('blog.edit.update');
        Route::post('/blog/delete/{id}',[App\Http\Controllers\admin\BlogController::class,'delete'])->name('blog.delete');

        // FAQ Routes
        Route::get('/faq',[App\Http\Controllers\admin\FaqController::class,'index'])->name('faqList');
        Route::get('/faq/create',[App\Http\Controllers\admin\FaqController::class,'create'])->name('faq.create.form');
        Route::post('/faq/save',[App\Http\Controllers\admin\FaqController::class,'save'])->name('faq.save');
        Route::get('/faq/edit/{id}',[App\Http\Controllers\admin\FaqController::class,'edit'])->name('faq.edit');
        Route::post('/faq/edit/{id}',[App\Http\Controllers\admin\FaqController::class,'update'])->name('faq.update');
        Route::post('/faq/delete/{id}',[App\Http\Controllers\admin\FaqController::class,'delete'])->name('faq.delete');

        // Page Routes
        Route::get('/pages',[\App\Http\Controllers\admin\PageController::class,'index'])->name('pageList');
        Route::get('/page/create',[\App\Http\Controllers\admin\PageController::class,'create'])->name('page.create.form');
        Route::post('/page/create',[\App\Http\Controllers\admin\PageController::class,'save'])->name('page.save');
        Route::get('/page/edit/{id}',[App\Http\Controllers\admin\PageController::class,'edit'])->name('page.edit');
        Route::post('/page/edit/{id}',[App\Http\Controllers\admin\PageController::class,'update'])->name('page.update');
        Route::post('/page/delete/{id}',[App\Http\Controllers\admin\PageController::class,'delete'])->name('page.delete');

        Route::post('/page/deleteImage',[App\Http\Controllers\admin\PageController::class,'deleteImage'])->name('page.deleteImage');

        // Settings route
        Route::get('/settings',[App\Http\Controllers\admin\SettingsController::class,'index'])->name('settings.index');
        Route::post('/settings',[App\Http\Controllers\admin\SettingsController::class,'save'])->name('settings.save');

    });

});
