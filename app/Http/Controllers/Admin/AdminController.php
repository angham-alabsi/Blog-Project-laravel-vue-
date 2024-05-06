<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\User;
//User::create([
    
//])
class AdminController extends Controller
{
    public function getUser(){
        //return User::with(['role'])->get();
        return Auth::user()->role_id;
    }
    public function index(REQUEST $request){
        //first check if you are log in
        if(!Auth::check() && $request->path() != 'login'){
            return redirect('/login');
        }
        if(!Auth::check() && $request->path() == 'login'){
            return view('welcome');

        }
        //if you are login but user type is "user"
        $user=Auth::user();
        if($user->role->roleName=="user"){
            return redirect('/login');
        }
        //if you are login but you tried go to /login that main login open only if you are not logged
        if($request->path()=="login"){
            return redirect('/');
        }
        //$user=User::get();
        //$user=Auth::user();
        //\Log::info($user->role->roleName);
        //return $request->path();
        return $this->checkPermission($user,$request);
        //return abort('404');
        //return view('welcome');
    }

    public function checkPermission($user,$request){
        //return view('welcome');
        $permission=JSON_decode($user->role->permission);
      // return $permission;
       $hasPermission=false;
       foreach($permission as $p){
           if($p->name == $request->path()){
               if($p->read==true){
                   $hasPermission=true;
               }
            }
       }
       if($hasPermission){
           return view('welcome');
       }else{
           return view('notFound');
           //return back();
       }
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }

    public function loginCheck(REQUEST $request){
        //return $request;
        $valid=Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'bail|required|min:6'
        ]);
        //return bcrypt($request->password);

        if(Auth::attempt(["email"=>$request->email,"password"=>$request->password])){
            $user=Auth::user();
            if($user->role->isAdmin == 0)
            {
                Auth::logout();
                return response()->json([
                    'msg'=>"You are not allow access"
                ],401);

            }
            //return view('welcome');
            return response()->json([
                'msg'=>"You are logged in",
                'user'=>$user
            ]);
        }else{
            return response()->json([
                'msg'=>"Incorrect login details"
            ],401);
        }
    }

    public function getUsers(){
        //return User::orderBy('id','desc')->where('role_id','!=', 4)->get();
        $user=User::with(['role'])->get();
        return response()->json($user);
    }

    public function addUser(UserRequest $request){
        //return $request->role_id;
        return User::create([
            'fullname'=>$request->fullname,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'role_id'=>$request->role_id

        ]);
    }

    public function editUser(UserRequest $request ){
        return User::where('id',$request->id)->update([
            'fullname'=>$request->fullname,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'role_id'=>$request->role_id
        ]);
    }

    /*public function addTag(REQUEST $request){
        //validation
        return Tag::create([
            'tagName'=>$request->tagName
        ]);

    }
    public function getTags(){
        return Tag::orderBy('id','desc')->get();
    }*/
}
