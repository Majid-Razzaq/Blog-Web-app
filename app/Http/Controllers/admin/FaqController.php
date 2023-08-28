<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $faq = Faq::orderBy('created_at','DESC');

        if(!empty($request->keyword))
        {
            $faq = $faq->where('question','like','%'.$request->keyword.'%');
        }

        $faq = $faq->paginate(20);
        $data['faq'] = $faq;

        return view('admin.faq.list',$data);

   }

   public function create(Request $request)
   {
    return view('admin.faq.create');
   }


   public function save(Request $request)
   {
        $validator = Validator::make($request->all(),[
            'question'=> 'required',
        ]);

        if($validator->passes())
        {
            $faq = Faq::insert([
                'question' => $request->question,
                'answer' => $request->answer,
                'status' => $request->status,
            ]);
            Session()->flash('success','FAQ created Successfully');
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

   public function edit($id, Request $request)
   {
        $faq = Faq::where('id',$id)->first();
        if($faq == null)
        {
            Session()->flash('error','Faq not found');
            return redirect()->route('faqList');
        }
        $data['faq'] = $faq;
        return view('admin.faq.edit',$data);
   }

   public function update($id, Request $request)
   {


    $validator = Validator::make($request->all(),[
        'question'=> 'required',
    ]);

    if($validator->passes())
    {
        $faq = Faq::where('id',$id)->update([
            'question' => $request->question,
            'answer' => $request->answer,
            'status' => $request->status,
        ]);
        Session()->flash('success','FAQ updated Successfully');
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


     // delete function
     public function delete($id,Request $request)
     {

         Faq::where('id',$id)->delete();
         Session()->flash('success','Faq deleted Successfully');
         return response([
             'status' => 200,
         ]);
     }

}
