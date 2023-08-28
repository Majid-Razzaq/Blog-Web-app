<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TempFile;
use Illuminate\Http\Request;

class TempImageController extends Controller
{
    public function upload(Request $request)
    {
        $temp = new TempFile;
        $temp->name = 'TEMP VALUE';
        $temp->save(); //This will create a blank entry in DB

        $image = $request->file('file');
        $destinationPath = './uploads/temp/';
        $extension = $image->getClientOriginalExtension();
        $newFileName = $temp->id.'.'.$extension;
        $image->move($destinationPath,$newFileName);

        $temp->name = $newFileName;
        $temp->save();

        return response()->json([
            'status' => 200,
            'id'=> $temp->id,
            'name' => $newFileName,

        ]);

    }
}
