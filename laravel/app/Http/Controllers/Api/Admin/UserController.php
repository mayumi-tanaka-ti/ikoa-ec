<?php

namespace App\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();//すべてのユーザを取得
        return view("admin.user.index", compact("users"));//ビューに渡す
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
        $user = User::with("orders")->findOrFail($id);//IDでユーザ取得,購入履歴も
        return view("admin.users.show", compact("user"));//ビューに渡す
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
        $orders = $user->orders; // 購入履歴取得
        return view('admin.users.history', compact('user', 'orders'));
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

