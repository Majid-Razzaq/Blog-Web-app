<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::where('status',1)->orderBy('created_at','DESC')->get();
        $data['blogs'] = $blogs;
        return view('blog',$data);
    }

    public function detail($id)
    {
        $blogs = Blog::where('id',$id)->first();
        if($blogs == null)
        {
            return redirect()->route('blog.front');
        }

        // fetcg comment data using this query
        $comments = Comment::where('status',1)
                        ->where('blog_id',$blogs->id)
                        ->orderBY('created_at','ASC')->get();

        $data['blogs'] = $blogs;
        $data['comments'] = $comments;

        return view('blog-details',$data);
    }

    public function saveComment(Request $request)
    {
        // $comment = Comment::where('status',1)->
        $Validator = Validator::make($request->all(),[
            'name' => 'required',
            'comment' => 'required',
        ]);

        if($Validator->passes())
        {

            $comment = new Comment;
            $comment->name = $request->name;
            $comment->comment = $request->comment;
            $comment->blog_id = $request->blog_id;
            $comment->status = 1;
            $comment->save();

            return response()->json([
                'status' => 1,
                'name' => $comment->name,
                'comment' => $comment->comment,
                'created_at' => date('d/m/Y h:i a',strtotime($comment->created_at)),
            ]);
        }
        else
        {
            return response()->json([
                'status' => 0,
                'errors' => $Validator->errors(),
            ]);
        }
    }
}
