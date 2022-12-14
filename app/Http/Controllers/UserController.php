<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Models\User;

class UserController extends Controller
{
    public function loginpage(){
        return view("class_rate_view.loginpage");
    }
    
    public function login(){
        $user_name = Request::get("user_name");
        $password = Request::get("password");
        DB::connection("mysql");
        $userData = DB::select("SELECT * FROM users WHERE name=?", [$user_name]);

        if(!isset($userData[0]->name)){
            return \Redirect::back()->with("message","使用者不存在");
        }elseif($userData[0]->privilege == -1){
            return \Redirect::back()->with("message","使用者已遭停權");
        }elseif(password_verify($password, $userData[0]->password)){
            session(["user_name" => $userData[0]->name]);
            session(["privilege" => $userData[0]->privilege]);
            return redirect("/homepage");
        }else{
            return \Redirect::back()->with("message","密碼錯誤");
        }
    }

    public function registerpage(){
        return view("class_rate_view.registerpage");
    }

    public function register(){
        $user_name = Request::get("user_name");
        $password = Request::get("password");
        DB::connection("mysql");
        $userData = DB::select("SELECT * FROM users WHERE name=?", [$user_name]);
        if(isset($userData[0]->name)){
            return \Redirect::back()->with("message","已存在使用者");
        }
        else{
            $hashed_password = Hash::make($password);
            $privilege = 3;
            User::create([
                "name" => $user_name,
                "password" => $hashed_password,
                "privilege" => $privilege,
            ]);
            return \Redirect::back()->with("message","註冊成功");
        }
    }

    public function logout(){
        session()->forget("user_name");
        session()->forget("privilege");
        return redirect("/");
    }

    public function show_users(){
        if(!session()->exists("user_name")){
            return redirect("/")->with("warning","請先登入");
        }
        if(session("privilege")!==1){//如果不是管理員
            return \Redirect::back()->with("alert","權限不足");
        }
        
        $users = User::orderby("id","DESC")->paginate(10);
        return view("class_rate_view.users")->with("users",$users);
    }

    public function change_privilege($id){
        if(!session()->exists("user_name")){
            return redirect("/")->with("warning","請先登入");
        }
        if(session("privilege")!==1){//如果不是管理員
            return \Redirect::back()->with("alert","權限不足");
        }
        $user = User::find($id);
        $new_p = Request::get("privilege");
        if($new_p==="0"){
            return \Redirect::back()->with("alert","請選擇一個選項");
        }
        $user->privilege = $new_p;
        $user->save();
        return \Redirect::back()->with("message","更改成功");
    }

    public function change_password_page(){
        if(!session()->exists("user_name")){
            return redirect("/")->with("warning","請先登入");
        }
        return view("class_rate_view.change_password");
    }

    public function change_password(){
        if(!session()->exists("user_name")){
            return redirect("/")->with("warning","請先登入");
        }

        $user = User::where("name",session("user_name"))->get();
        $new_password = Request::get("new_password");
        if(!password_verify(Request::get("old_password"),$user[0]->password)){
            return \Redirect::back()->with("alert","當前密碼錯誤");
        }
        elseif(password_verify($new_password,$user[0]->password)){
            return \Redirect::back()->with("alert","新密碼不能與當前密碼相同");
        }
        elseif($new_password !== Request::get("verify_new_password")){
            return \Redirect::back()->with("alert","新密碼驗證錯誤");
        }
        $user[0]->password = Hash::make($new_password);
        $user[0]->save();
        return \Redirect::back()->with("alert","更改成功");
    }
}
