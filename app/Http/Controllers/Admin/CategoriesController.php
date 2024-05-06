<?php

namespace App\Http\Controllers\Admin;

//use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\FileRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function getCategories(){
        return Category::orderBy('id','desc')->get();
    }


    public function upload(FileRequest $request){
        $picName=time().'.'.$request->file->extension();
        $request->file->move(public_path('uploads'),$picName);
        return $picName;
    }

    public function deleteImg(REQUEST $request){
        $fileName=$request->imageName;
        return $this->deleteFileFromServer($fileName);
        return $fileName;
    }

    public function deleteFileFromServer($fileName){//,$hasFullPath=false
        /*if(! $hasFullPath){
            $filePath=public_path().'/uploads/'.$fileName;
        }*/
        $filePath=public_path().''.$fileName;
        if(file_exists($filePath)){
            @unlink($filePath);
        }
        return $fileName;
    }

    public function addCategory(CategoryRequest $request){
        return Category::create([
            'categoryName'=>$request->categoryName,
            'iconImage'=>$request->iconImage
        ]);
    }

    public function editCategory(CategoryRequest $request){
        return Category::where('id',$request->id)->update([
            'categoryName'=>$request->categoryName,
            'iconImage'=>$request->iconImage
        ]);
    }

    public function deleteCategory(REQUEST $request){
        $request->request->add(['imageName'=>$request->iconImage]);
        $this->deleteImg($request);
        Category::where('id',$request->id)->delete();
        return $request;
    }
}
