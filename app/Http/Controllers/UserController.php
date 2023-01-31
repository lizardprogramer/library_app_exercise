<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Copy;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //Shows login page
    public function login(){
        return view('users.login');
    }

    //Shows register page
    public function register(){
        return view('users.register');
    }

    //Create new user
    public function store(Request $request){
        $roleiId=Role::where('name', '=', 'User')->first();
        $formFields=$request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6'
        ]);

        $formFields['password'] = Hash::make($formFields['password']);
        $formFields['role_id'] = $roleiId->id;

        User::create($formFields);
        return redirect('/')->with('message', 'User created successfuly!');
    }

    //Logout
    public function logout(Request $request){
        
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'User logged out successfuly!');
    }

    //Authenticate (login)
    public function authenticate(Request $request){

        $formFields=$request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        $user=User::where('email', '=', $formFields['email'])->first();

        if($user){
        if (Hash::check($formFields['password'], $user->password)){
                auth()->login($user);
                return redirect('/')->with('message', 'User logged in successfuly!');
            } 
        else{
                return back()->with('message', 'Wrong credentials!');
            }
        }
        else{
            return back()->with('message', 'Wrong credentials!');
        }
    }

    //Show single user page
    public function show(Request $request, $id){
        $user=auth()->user();
        $roleid=$user->role()->first()->admin_permission;
        $singleUser=User::find($id);
        $copies=Copy::with('book')->where('user_id', 'like', '%' . $id . '%')->get();
        if($roleid){
            return view('users.single',[
                'role_id'=>$roleid,
                'singleUser'=>$singleUser,
                'copies'=>$copies
            ]);
        }
        else{
            return redirect('/');
        }
    }

    //Show all users page
    public function index(Request $request){
        $user=auth()->user();
        $roleid=$user->role()->first()->admin_permission;
        $allUsers=User::with('copys')->with('role')->get()->sortBy(function($query){
            return $query->role->name;
         });
        if($roleid){
            return view('users.allusers',[
                'role_id'=>$roleid,
                'allUsers'=>$allUsers
            ]);
        }
        else{
            return redirect('/');
        }
    }
   
}
