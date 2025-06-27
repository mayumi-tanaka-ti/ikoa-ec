<?php

namespace App\Http\Controllers\Api\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;



class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();//すべてのユーザを取得
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    // IDでユーザを取得。見つからなければ404
    $user = User::findOrFail($id);
    
    // すべてのカラムをJSONで返す（Laravelはモデルのfillable属性に従う）
    return response()->json($user);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function history(string $id)
    {
        $user = User::findOrFail($id);

        // 注文とそれに紐づく商品を取得
        $orders = $user->orders()->with('products')->get();

        return response()->json([
            'user' => $user,
            'orders' => $orders
        ]);
    }


    public function showLoginForm()
    {
    return view('admin.users.login');
    }

public function login(Request $request)
    {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        return redirect()->intended('/admin/dashboard');
    }

    return back()->withErrors([
        'email' => 'ログイン情報が正しくありません。',
    ]);
    }



}