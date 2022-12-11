<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    //M V C
    public function getUser(){
        //Lay toan user

        //Cach 1 : Query Builder
        // $users = DB::table('users')->get();

        //Cach 2 : Eloquent 
        $users = User::all();
    

        return view('admin.user.list')->with('datas', $users);
    }
}
