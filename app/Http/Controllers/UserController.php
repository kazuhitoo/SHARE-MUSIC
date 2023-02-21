<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserPostRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{

    //ログインページ
    public function login()
    {
        return view('page.login');
    }
    //ログイン処理
    public function logincomplete(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerateToken();
            return redirect()->route('top');
        } else {
            return back()->withErrors([
                'login_error' => 'ログインに失敗しました',
            ]);
        }
    }

    //パスワードリセットページ
    public function passwordreset()
    {
        return view('page.passwordreset');
    }
    //新規登録ページ
    public function signup()
    {
        return view('page.signup');
    }
    //新規登録完了ページ
    public function register(UserPostRequest $request)
    {
        $users = new User();
        $user_data = $request->all();
        $users->UserSave($user_data);

        $request->session()->regenerateToken();
        return view('page.register');
    }

    //ログアウト処理
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('top');
    }
}
