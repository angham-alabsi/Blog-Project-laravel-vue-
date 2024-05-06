<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Http\Requests\TagRequest;

class TagController extends Controller
{
    public function addTag(TagRequest $request){
        //validation
        return Tag::create([
            'tagName'=>$request->tagName
        ]);

    }
    public function getTags(){
        return Tag::orderBy('id','desc')->get();
    }
    public function editTag(TagRequest $request){
        return Tag::where('id',$request->id)->update([
            'tagName'=>$request->tagName
        ]);
    }
    public function deleteTag(TagRequest $request){
        return Tag::where('id',$request->id)->delete();
    }
}
