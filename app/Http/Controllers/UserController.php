<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\User_tasks;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;

class UserController extends Controller
{
    public function register_view ()
    {
        return view('register');
    }

    public function register_store (Request $request)
    {

        $user=User::create([
            'f_name'=>$request->first_name,
            'l_name'=>$request->last_name,
            'email'=>$request->email,
            'password'=> Hash::make($request->password)
        ]);



        if(Auth::attempt($request->only('email','password')))
        {
            return redirect()->route('login_page');
        }
        return redirect('register_view')->withError('error');

    }

    public function profile (Request $request)
    {
        // $request->validate
        // ([

        //     'image'         =>  'required|mimes:jpeg,jpg,png,gif,|max:10000'
        // ]);

        // //upload image
        // $imageName  =   time().'.'.$request->image->extension();
        // $request->image->move(public_path('products'),$imageName);
        // //insert in database
        // $product                =   new product;
        // $product->image         =   $imageName;

        return view('profile_setting');
    }

    public function login_view()
    {
        return view('login');
    }

    public function user_login(Request $request)
    {
        if(Auth::attempt($request->only('email','password')))
        {
            $name   =   (Auth()->user()->f_name);
            return redirect()->route('todotable');

        }

        return redirect()->route('login_page');

    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('login_page');
    }

    public function todotable()
    {
        $fetchtaskdata  =   DB::table('user_tasks')->select('*')->where('task_userid', auth()->user()->id)->get();
        return view('todo_table', compact('fetchtaskdata'));

    }

    public function taskadd(Request $request)
    {
        $task = DB::table('user_tasks')->insert
        ([
            "task" =>  $request->taskadd,
            "date" =>  $request->datepick,

            'task_userid' => auth()->user()->id,
        ]);
        return back();

    }
}
