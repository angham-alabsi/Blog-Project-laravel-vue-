<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Str;

class Blog extends Model
{
    protected $fillable=['id','title','post','post_excerpt','slug','user_id','featuredImage','metaDescription','views','jsonData'];

    public function setTitleAttribute($title){
        $this->attributes['title']=$title;
        $this->attributes['slug']=$this->uniqueSlug($title);
    }

    private function uniqueSlug($title){
        $slug=Str::slug($title,'-');
        $count=Blog::where('slug','like',$slug.'%')->count();
        $newcount=$count > 0 ? $count++ : "" ;
        return $newcount>0 ?  $slug.'-'.$newcount :  $slug ;
    }

    public function tag(){
        return $this->belongsToMany('App\Models\Tag','App\Models\Blogtag');
    }

    public function cate(){
        return $this->belongsToMany('App\Models\Category','App\Models\Blogcategory');
    }
}
