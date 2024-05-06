<?php

namespace App\Http\Controllers;

use Illuminate\Http\Admin\Request;

class TestController extends Controller
{
    public function testController(){
        return response()->json([
            'name'=>'angham alabsi'
        ]);
    }

    public function test(){
        return response()->json([
            'msg'=>'some error'
        ],422);
    }
}
