<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminCheck;

Route::group(['middleware'=>'adminCheck'],function(){

    Route::group(['prefix'=>'tag','namespace'=>'Admin'],function(){
        Route::post('create_tag','TagController@addTag');
        Route::post('edit_tag','TagController@editTag');
        Route::post('dalate_tag','TagController@deleteTag');
        Route::get('get_tags','TagController@getTags');

    });

    Route::group(['prefix'=>'category','namespace'=>'Admin'],function(){
        Route::get('get_categories','CategoriesController@getCategories');
        route::post('uploadImg','CategoriesController@upload');
        route::post('deleteImg','CategoriesController@deleteImg');
        Route::post('create_category','CategoriesController@addCategory');
        Route::post('edit_category','CategoriesController@editCategory');
        Route::post('delete_category','CategoriesController@deleteCategory');
    });

    Route::group(['prefix'=>'user','namespace'=>'Admin'],function (){
        route::get('get_users','AdminController@getUsers');
        route::post('create_user','AdminController@addUser');
        Route::post('edit_user','AdminController@editUser');
    });

    Route::group(['prefix'=>'role','namespace'=>'Admin'],function(){
        Route::post('create_role','RoleController@addRole');
        Route::post('edit_role','RoleController@editRole');
        Route::post('dalate_role','RoleController@deleteRole');
        Route::get('get_roles','RoleController@getRoles');
        Route::post('assign_role','RoleController@assignRole');
    });

    Route::group(['prefix'=>'blog','namespace'=>'Admin'],function(){
        Route::post('uploadEditorImage','BlogController@uploadEditorImage');
        Route::post('create-blog','BlogController@addBlog');
        Route::post('update-blog/{id}','BlogController@updateBlog');
        Route::get('slug','BlogController@slug');
        Route::get('get_blogs','BlogController@getBlogs');
        Route::get('get_single_blog/{id}','BlogController@getSingleBlogs');
        Route::post('delete_blog','BlogController@deleteBlog');
    });
});

Route::post('createBlog','Admin\BlogController@uploadEditorImage');


Route::get('/','Admin\AdminController@index');
Route::post('/login_check','Admin\AdminController@loginCheck');
Route::get('/logout','Admin\AdminController@logout');
Route::get('/user','Admin\AdminController@getUser');
Route::any('{slug}','Admin\AdminController@index');
//Route::get('/{any}', 'Admin\AdminController@index')->where('any', '^(?!api).*$');



/*Route::any('{slug}',function(){
    return view('welcome');
});*/

