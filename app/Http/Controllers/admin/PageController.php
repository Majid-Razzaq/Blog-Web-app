<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\page;
use App\Models\TempFile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

use function PHPUnit\Framework\returnSelf;

class PageController extends Controller
{

    public function index(Request $request)
    {
        $pages = page::orderBy('created_at','DESC');
        if(!empty($request->keyword))
        {
            $pages = $pages->where('name','like','%'.$request->keyword.'%');
        }

        $data['pages'] = $pages->paginate(5);

        return view('admin.pages.list',$data);
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    // This method will save a page in DB
    public function save(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
        ]);

        if($validator->passes())
        {
            $page = new Page;
            $page->name = $request->name;
            $page->content = $request->content;
            $page->status = $request->status;
            $page->save();

            if($request->image_id > 0)
            {
                $tempImage = TempFile::where('id',$request->image_id)->first();
                $tempFileName = $tempImage->name;
                $imageArray = explode('.',$tempImage->name);
                $ext = end($imageArray);

                $newFileName = 'page-'.$page->id.'.'.$ext;

                $sourcePath = './uploads/temp/'.$tempFileName;

                // Generate small Thumbnail
                // $dPath = './uploads/temp/pages/thumb/small/'.$newFileName;
                // $img = Image::make($sourcePath);
                // $img->fit(360,220);
                // $img->save($dPath);

                // Generate Large Thumbnail
                $dPath = './uploads/temp/pages/thumb/large/'.$newFileName;
                $img = Image::make($sourcePath);
                $img->resize(1150, null, function($constraint){
                    $constraint->aspectRatio();
                });
                $img->save($dPath);

                // This will update image in DB
                $page->image = $newFileName;
                $page->save();

                File::delete($sourcePath);
            }

            Session()->flash('success','Page Created Successfully');
            return response()->json([
                'status' => 200,
             ]);

        }
        else
        {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors(),
             ]);
        }
    }

    public function edit($id,Request $request)
    {
        $page = page::where('id',$id)->first();
        if(empty($page))
        {
            Session()->flash('error','Record not found in Database.');
            return redirect()->route('pageList');
        }
        $data['page'] = $page;
        return view('admin.pages.edit',$data);
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
        ]);

        if($validator->passes())
        {
            $page = Page::find($id);
            $page->name = $request->name;
            $page->content = $request->content;
            $page->status = $request->status;
            $page->save();

            $oldImageName = $page->name;

            if($request->image_id > 0)
            {
                $tempImage = TempFile::where('id',$request->image_id)->first();
                $tempFileName = $tempImage->name;
                $imageArray = explode('.',$tempImage->name);
                $ext = end($imageArray);

                $newFileName = 'page-'.$page->id.'.'.$ext;

                $sourcePath = './uploads/temp/'.$tempFileName;

                // Generate Large Thumbnail
                $dPath = './uploads/temp/pages/thumb/large/'.$newFileName;
                $img = Image::make($sourcePath);
                $img->resize(1150, null, function($constraint){
                    $constraint->aspectRatio();
                });
                $img->save($dPath);

                // This will update image in DB
                $page->image = $newFileName;
                $page->save();

                $dPath = './uploads/temp/pages/thumb/large/'.$newFileName;

                File::delete($sourcePath);
            }

            // Success Message

            Session()->flash('success','Page Update Successfully');
            return response()->json([
                'status' => 200,
             ]);

        }
        else
        {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors(),
             ]);
        }

    }

    public function delete($id)
    {

        $page = page::where('id',$id)->first();
        if(empty($page))
        {
            Session()->flash('error','Record not found!');
            return response([
                'status' => 0,
            ]);
        }

        $path = './uploads/temp/pages/thumb/large/'.$page->image;
        File::delete($path);

        Session()->flash('success','Page deleted Successfully');
        return response()->json([
            'status'=> 200,
        ]);

        }

        public function deleteImage(Request $request)
        {
            $page = page::find($request->id);
            $oldImage = $page->image;

            $page->Image = '';
            $page->save();

           File::delete('./uploads/temp/pages/thumb/large/'.$oldImage);

           return response()->json([
            'status'=> 200,
            ]);



        }
}
