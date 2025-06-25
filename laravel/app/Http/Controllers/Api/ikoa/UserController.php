<?php

namespace App\Http\Controllers\Api\ikoa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function mypage(){
        $user = Auth::user(); // ログインユーザー取得
        dd($user);
        return new UserResource($user);
    }

    public function update(Request $request){

    $user = Auth::user();

    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'birthday' => 'nullable|date',
        'phone_number' => 'required|string|max:20',
        'post_code' => 'nullable|string|max:10',
        'address' => 'nullable|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $user->update($validator->validated());

    return new UserResource($user);
    }
}
