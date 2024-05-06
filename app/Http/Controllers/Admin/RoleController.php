<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use Validator;
use App\Models\Role;

class RoleController extends Controller
{
    public function getRoles(){
        return Role::orderBy('id','desc')->get();
    }

    public function addRole(RoleRequest $request){
        return Role::create([
            'roleName'=>$request->roleName
        ]);
    }

    public function editRole(RoleRequest $request){
        return Role::where('id',$request->id)->update([
            'roleName'=>$request->roleName
        ]);
    }

    public function deleteRole(RoleRequest $request){
        return Role::where('id',$request->id)->delete();
    }

    public function assignRole(REQUEST $request){
        $valid=Validator::make($request->all(),[
            'id'=>'required'
        ]);
        return Role::where('id',$request->id)->update([
            'permission'=>$request->permission,
        ]);

    }
}
