<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use App\Http\Requests\FileRequest;
use App\Http\Requests\BlogRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\Blog;
use App\Models\Blogcategory;
use App\Models\Blogtag;
use Auth;
use DB;

class BlogController extends Controller
{
    public function uploadEditorImage(REQUEST $request){
        return $request;
        $valid=Validator::make($request->all(),[
            'image'=>'required|image|mimes:jpg,png,jpeg'
        ]);
        $picName=time().'.'.$request->image->extension();
        $request->image->move(public_path('uploads'),$picName);
        return $picName;
        return response()->json([
            "success" => 1,
            "image" =>[
                "url" => "http://127.0.0.1:8000/uploads/$picName",
                // ... and any additional fields you want to store, such as width, height, color, extension, etc
            ]
        ]);
       // return $picName;
    }

    public function addBlog(BlogRequest $request){
            try{
            $categories=$request->category_id;
            $tags=$request->tag_id;
            $blogCategories=[];
            $blogTags=[];
            DB::beginTransaction();
            $blog=Blog::create([
                'title'=>$request->title,
                'post'=>$request->post,
                'post_excerpt'=>$request->post_excerpt,
                'user_id'=>Auth::user()->id,
                'metaDescription'=>$request->metaDescription,
                'jsonData'=>$request->jsonData,
            ]);
            //return $blog;
            foreach($categories as $c){
                array_push($blogCategories,['category_id'=>$c , 'blog_id'=>$blog->id]);
            }
            Blogcategory::insert($blogCategories);
            foreach($tags as $t){
                array_push($blogTags,['tag_id'=>$t , 'blog_id'=>$blog->id]);
            }
            Blogtag::insert($blogTags);
            DB::commit();
        }catch(\Exception $ex){
            DB::rollback();
        }
    }

    public function updateBlog(BlogRequest $request , $id){
        try{
            //return $request;
            $categories=$request->category_id;
            $tags=$request->tag_id;
            $blogCategories=[];
            $blogTags=[];

            DB::beginTransaction();
            $blog=Blog::where('id',$id)->update([
                'title'=>$request->title,
                'post'=>$request->post,
                'post_excerpt'=>$request->post_excerpt,
                'user_id'=>Auth::user()->id,
                'metaDescription'=>$request->metaDescription,
                'jsonData'=>$request->jsonData,
            ]);
           // return $blog;

            foreach($categories as $c){
                array_push($blogCategories,['category_id'=>$c , 'blog_id'=>$id]);
            }
            Blogcategory::where('blog_id',$id)->delete();
            Blogcategory::insert($blogCategories);


            foreach($tags as $t){
                array_push($blogTags,['tag_id'=>$t , 'blog_id'=>$id]);
            }
            Blogtag::where('blog_id',$id)->delete();
            Blogtag::insert($blogTags);

            DB::commit();
        }catch(\Exception $ex){
            DB::rollback();
        }
    }

    public function slug(){
        $title='this is a nice title';
        return Blog::create([
            'title'=>$title,
            'post'=>'post',
            'post_excerpt'=>'post_excerpt',
            'user_id'=>1,
            'metaDescription'=>'metaDescription',
            'featuredImage'=>'featuredImage'
        ]);

    }

    public function getBlogs(){
        return Blog::with(['tag','cate'])->orderBy('id','desc')->get();
    }

    public function getSingleBlogs(REQUEST $request,$id){
       // return $id;
        return Blog::with(['tag','cate'])->where('id',$id)->first();
    }

    public function deleteBlog(REQUEST $request){
        return Blog::where('id',$request->id)->delete();
    }

}
