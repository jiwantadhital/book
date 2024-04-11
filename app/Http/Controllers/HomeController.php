<?php

namespace App\Http\Controllers;

use App\Models\account;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['accountDelete', 'store']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('backend.adminHome');
    }
    public function accountDelete(){
        return view('account_delete');
    }
    public function store(Request $request)
    {

        $data['row']=account::create($request->all());
        if ($data['row']){
            request()->session()->flash('Created Successfully');
        }else{
            request()->session()->flash('Creation Failed');
        }
//        return redirect()->route('category.index',compact('data'));
        return view('account_delete');

    }
}
