<?php

namespace App\Http\Controllers;

use App\Exceptions\Handler;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::all()->where('status', 'approved');
        return view('pages.home', compact('posts'));
    }

    public function getChangePasswordForm()
    {
        return view('users.change-password');
    }

    public function changePassword(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if (Hash::check(Input::get('passwordold'), $user['password']) && Input::get('password') == Input::get('password_confirmation')) {
            $user->password = bcrypt(Input::get('password'));
            $user->save();
            return redirect('/')->with('success', 'Mật khẩu của bạn đã được thay đổi thành công!');
        } else {
            return back()->with('error', 'Đã có lỗi xảy ra, xin hãy đảm bảo các trường nhập vào là chính xác');
        }
    }
}
