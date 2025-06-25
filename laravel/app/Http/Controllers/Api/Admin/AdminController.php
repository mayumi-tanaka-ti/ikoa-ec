<?php

namespace App\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();//すべてのユーザを取得
        return response()->json($users);
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
        $orders = $user->orders;
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