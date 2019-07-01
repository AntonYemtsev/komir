<?php

namespace App\Http\Controllers\Index;

use App\Models\Users;
use App\User;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use App\Helpers;
use Illuminate\Support\Facades\Redirect;
use DB;
use Mail;
use Auth;
use Hash;
use Mcamara\LaravelLocalization\Exceptions\SupportedLocalesNotDefined;
use Mcamara\LaravelLocalization\Exceptions\UnsupportedLocaleException;
use Illuminate\Session;
use Illuminate\Contracts\Pagination;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class IndexController extends Controller
{
    public function index(){
        return view('index.index');
    }
    public function lostPassword(){
        return view('index.lost-password');
    }

    public function login(Request $request){
        if(Auth::check()){
			return redirect('/admin/index');
        }
        if(isset($request->email) && strlen($request->email) > 0){
            $user_item = Users::where("email","=",$request->email)->first();
            if(@count($user_item) < 1){
                return view('index.login', [
                    'email' => $request->email,
                    'email_error' => 'Такого email в базе не найдено',
                    'auth_error' => ''
                ]);
            }

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                if(@count($user_item) > 0){
                    $offset= strtotime("+6 hours 0 minutes");
                    $user_item->date_last_login = date("Y-m-d H:i:s",$offset);
                    $user_item->save();
                }

				return redirect('/admin/index');
            }
            else{
                return view('index.login', [
                    'email' => $request->email,
                    'email_error' => '',
                    'auth_error' => 'Неправильный логин или пароль!'
                ]);
            }
        }
        else{
            return view('index.login', [
                'email' => '',
                'email_error' => '',
                'auth_error' => ''
            ]);
        }
    }

    public function resetPassword(Request $request){
        $user_row = Users::where("email","=",$request->email)->first();
        if(@count($user_row) < 1){
            return response()->json(['result'=>"email_not_found",'value'=>'Пользователь с таким Email не найден']);
        }

        $rand_str = "";
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        for ($i = 0; $i < 14; $i++) {
            $rand_str .= $characters[rand(0, strlen($characters) - 1)];
        }

        $email_to = $user_row->email;

        $message_str = 'Для сброся пароля пройдите по <a href="https://' . $_SERVER['SERVER_NAME'] . '/reset-pass/' . $rand_str . '">ссылке</a>';
        Mail::send(['html' => 'admin.email-template'], ['text' => $message_str], function($message) use ($email_to){
            $message->to($email_to)->subject("Сброс пароля на сайте");
        });

        if(@count(Mail::failures()) > 0){
            return response()->json(['result'=>false]);
        }
        else{
            $user_row->reset_token = $rand_str;
            $user_row->save();
            return response()->json(['result'=>true]);
        }
    }

    public function sendLostPasswordLink(Request $request){
        $user_row = Users::where("email","=",$request->email)->first();
        if(@count($user_row) < 1){
            return response()->json(['result'=>"email_not_found",'value'=>'Пользователь с таким Email не найден']);
        }

        $rand_str = "";
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        for ($i = 0; $i < 14; $i++) {
            $rand_str .= $characters[rand(0, strlen($characters) - 1)];
        }

        $email_to = $user_row->email;

        $message_str = 'Для сброся пароля пройдите по <a href="https://' . $_SERVER['SERVER_NAME'] . '/reset-pass/' . $rand_str . '">ссылке</a>';
        Mail::send(['html' => 'admin.email-template'], ['text' => $message_str], function($message) use ($email_to){
            $message->to($email_to)->subject("Сброс пароля на сайте");
        });

        if(@count(Mail::failures()) > 0){
            return response()->json(['result'=>false]);
        }
        else{
            $user_row->reset_token = $rand_str;
            $user_row->save();
            return response()->json(['result'=>true]);
        }
    }

    public function resetPass(Request $request){
        $user_row = Users::where("reset_token","=",$request->reset_token)->first();
        return view('index.reset-pass',['user_row' => $user_row]);
    }

    public function setNewPass(Request $request){
        $user_row = Users::where("reset_token","=",$request->reset_token)->first();
        if(@count($user_row) < 1){
            return response()->json(['result'=>"user_not_found",'value'=>'Пользователь не найден']);
        }

        if($request->password != $request->repeat_password){
            return response()->json(['result'=>"repeat_password_incorrect",'value'=>'Пароль и повтор пароля не совпадают']);
        }

        $user_row->password = Hash::make(trim($request->password));
        $user_row->reset_token = null;
        $user_row->save();
        if($user_row->save()){
            return response()->json(['result'=>true]);
        }
        else{
            return response()->json(['result'=>false]);
        }
    }
}