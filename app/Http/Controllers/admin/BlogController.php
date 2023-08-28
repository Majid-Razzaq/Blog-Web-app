<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\TempFile;
use Illuminate\Contracts\Session\Session;
use Intervention\Image\Facades\Image;


class BlogController extends Controller
{
    public function index(Request $request)
    {

        $blogs = Blog::orderBy('created_at','DESC');
        if(!empty($request->keyword))
        {
            $blogs = $blogs->where('name','like','%'.$request->keyword.'%');
        }

        $blogs = $blogs->paginate(5);
        $data['blogs'] = $blogs;

        return view('admin.blog.list',$data);
    }

        // This method will show create Blog Page
        public function create()
        {
            return view('admin.blog.create');
        }
        // This method will save a blog in DB
        public function save(Request $request)
        {
            $validator = Validator::make($request->all(),[
                'name' => 'required',
            ]);

            if($validator->passes())
            {
                // Form validated successfully
                $blog = new Blog;
                $blog->name = $request->name;
                $blog->short_desc = $request->short_description;
                $blog->description = $request->description;
                $blog->status = $request->status;
                $blog->save();

                if($request->image_id > 0)
                {
                    $tempImage = TempFile::where('id',$request->image_id)->first();
                    $tempFileName = $tempImage->name;
                    $imageArray = explode('.',$tempFileName);
                    $ext = end($imageArray);

                    $newFileName = 'blog-'.$blog->id.'.'.$ext;

                    $sourcePath = './uploads/temp/'.$tempFileName;

                    // Generate small Thumbnail
                    $dPath = './uploads/temp/blogs/thumb/small/'.$newFileName;
                    $img = Image::make($sourcePath);
                    $img->fit(360,220);
                    $img->save($dPath);

                    // Generate Large Thumbnail
                    $dPath = './uploads/temp/blogs/thumb/large/'.$newFileName;
                    $img = Image::make($sourcePath);
                    $img->resize(1150, null, function($constraint){
                        $constraint->aspectRatio();
                    });
                    $img->save($dPath);

                    $blog->image = $newFileName;
                    $blog->save();

                    File::delete($sourcePath);
                }

                Session()->flash('success', 'Blog Created Successfully');

                return response()->json([
                    'status' => '200',
                    'message' => 'Blog Created Successfully',
                ]);


            }
            else
            {
                // return errors
                return response()->json([
                    'status' => '0',
                    'errors' => $validator->errors(),
                ]);
            }

            return view();
        }


        // Edit function start
        public function edit($id, Request $request)
        {
            $blog = Blog::where('id',$id)->first();
            if(empty($blog))
            {
                Session()->flash('error', 'Record not found in Database');
                return redirect()->route('blogList');
            }
            $data['blog'] = $blog;
            return view('admin.blog.edit',$data);
        }

        // Update function start
    public function update($id,Request $request)
    {

        $validator = Validator::make($request->all(),[
            'name' => 'required',
        ]);
        if($validator->passes())
        {
            // Form validated successfully
            $blog = Blog::find($id);

            if(empty($blog))
            {
                Session()->flash('error', 'Record not found in Database');
                return response()->json([
                    'status' => '0',
                ]);

            }

            $oldImageName = $blog->image;

            $blog->name = $request->name;
            $blog->short_desc = $request->short_description;
            $blog->description = $request->description;
            $blog->status = $request->status;
            $blog->save();

            if($request->image_id > 0)
            {
                $tempImage = TempFile::where('id',$request->image_id)->first();
                $tempFileName = $tempImage->name;
                $imageArray = explode('.',$tempFileName);
                $ext = end($imageArray);

                $newFileName = 'blog-'.strtotime('now').'-'.$blog->id.'.'.$ext;

                $sourcePath = './uploads/temp/'.$tempFileName;

                // Generate small Thumbnail
                $dPath = './uploads/temp/blogs/thumb/small/'.$newFileName;
                $img = Image::make($sourcePath);
                $img->fit(360,220);
                $img->save($dPath);


                // Delete old small Thumbnail
                $sourcePathSmall = './uploads/temp/blogs/thumb/small/'.$oldImageName;
                File::delete($sourcePathSmall);

                // Generate Large Thumbnail
                $dPath = './uploads/temp/blogs/thumb/large/'.$newFileName;
                $img = Image::make($sourcePath);
                $img->resize(1150, null, function($constraint){
                    $constraint->aspectRatio();
                });
                $img->save($dPath);


                // Delete large small Thumbnail
                $sourcePathLarge = './uploads/temp/blogs/thumb/large/'.$oldImageName;
                File::delete($sourcePathLarge);


                $blog->image = $newFileName;
                $blog->save();

                File::delete($sourcePath);
            }

            Session()->flash('success', 'Blog Updated Successfully');
            return response()->json([
                'status' => '200',
                'message' => 'Blog Created Successfully',
            ]);

        }
        else
        {
            // return errors
            return response()->json([
                'status' => '0',
                'errors' => $validator->errors(),
            ]);
        }




    }


    // delete function
    public function delete($id,Request $request)
    {
        $blog = Blog::where('id',$id)->first();

        if(empty($blog))
        {
            Session()->flash('error','Record not found!');
            return response([
                'status' => 0,
            ]);
        }

        $path = './uploads/temp/blogs/thumb/small/'.$blog->image;
        File::delete($path);

        $path = './uploads/temp/blogs/thumb/large/'.$blog->image;
        File::delete($path);

        Blog::where('id',$id)->delete();
        Session()->flash('success','Blog deleted Successfully');
        return response([
            'status' => 1,
        ]);
    }



}
