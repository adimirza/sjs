<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;

class Api extends Controller
{
    public function user()
    {
        $result['status'] = false;
        $result['message'] = 'Fail';
        $result['data'] = '';
        $user = UserModel::all();
        if(!$user){
            return response()->json($result, 500);
        } 
        $result['status'] = true;
        $result['message'] = 'Success ';
        $result['data'] = $user;
        return response()->json($result, 200);
    }
}
