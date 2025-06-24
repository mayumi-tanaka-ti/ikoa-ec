<?php

namespace App\Http\Controllers\Api\ikoa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function mypage(Request $request){
        $user = Auth::user(); // ログインユーザー取得
        
        return new UserResource($user);
    }
}
