<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginBasic extends Controller
{
  public function index()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-login-basic', ['pageConfigs' => $pageConfigs]);
  }

  public function loginSubmit(Request $request){
    $data= $request->all();
    if(Auth::attempt(['email' => $data['email-username'], 'password' => $data['password'] ,'status'=>'1'])){
        Session::put('user',$data['email-username']);
        request()->session()->flash('success','Đăng nhập thành công');
        return redirect()->route('dashboard-analytics');
    }
    else{
        request()->session()->flash('error','Sai tài khoản hoặc mật khẩu !');
        return redirect()->back();
    }
  }

  public function logout(){
    Session::forget('user');
    Auth::logout();
    request()->session()->flash('success','Đăng xuất thành công');
    return redirect()->route('user-login');
  }

}