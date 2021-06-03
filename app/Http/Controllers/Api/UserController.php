<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\User;
use App\Combo;
use App\Customer;
use App\User_Role;
use App\Photographer;
use App\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class UserController extends Controller
{

    public function user_register(Request $request) {

        $user = new User;
    
        $user -> username = $request -> username;
        $user -> password = Hash::make($request -> password);
        $user -> email    = $request -> email;
        $user -> save();

        $id_customer = $user->id;
        $customer = new Customer;
        $customer -> id_customer = $id_customer;
        $customer -> billing = $request->input('billing');
        $customer ->save();

        $user_role = new User_Role;
        $user_role -> id_user = $id_customer;
        $user_role -> id_role = 2;
        $user_role -> save();


        return response()->json($user);
    }

    public function photographer_register(Request $request) {

        $user = new User;
        
        $user -> username = $request -> username;
        $user -> password = Hash::make($request -> password);
        $user -> email    = $request -> email;
        $user -> save();

        $id_photographer = $user->id;
        $photographer = new Photographer;
        $photographer -> id_photographer = $id_photographer;
        $photographer ->save();

        $user_role = new User_Role;
        $user_role -> id_user = $id_photographer;
        $user_role -> id_role = 3;
        $user_role -> save();

        
        return response()->json($user);
    }

    public function login(Request $request) {
        if(Auth::attempt([
            'username' => $request->username,
            'password' => $request->password
        ])){
            $user = User::where('username',$request->username)->first();
            $user->token = $user->createToken('App')->accessToken;

            return response()->json($user);
        }
        return response()->json(['email' => 'Sai ten truy cap hoac mat khau'], 401);
    }
    // login for admin


    public function userInfo(Request $request) {
        return response()->json($request->user('api'));
    }


    public function photographer_popular() {


        $photographer =DB::table('user_role')
            ->where('id_role',3)
            ->join('user','user_role.id_user','=','user.id')
            ->join('photographer','user_role.id_user','=','photographer.id_photographer')
            ->select('user.*','user_role.id_role','photographer.nickname','photographer.studio_address','photographer.limitation_time','photographer.descript')
            ->get();

        return response()->json($photographer);
    }

    public function photographer_recommendation() {

        $photographer =DB::table('user_role')
            ->where('id_role',3)
            ->join('user','user_role.id_user','=','user.id')
            ->join('photographer','user_role.id_user','=','photographer.id_photographer')
            ->select('user.*','user_role.id_role','photographer.nickname','photographer.studio_address','photographer.limitation_time','photographer.descript')
            ->get();

        return response()->json($photographer);
    }

    public function search_photographer (Request $request) {

        $search = $request->input('search');

        $photographer = Photographer::where('nickname','like',"%{$search}%")
            ->orWhere('studio_address','like',"%{$search}%")    
            ->get();

        return response()->json(['count'=> $photographer->count(),'data' => $photographer]);
    }



    public function show_photographer_type($id) {
  
        $combo_photographer = Combo::where('id_photographer',$id)->get();
        return $combo_photographer;
    }


    public function customer_total() {
        $customer = DB::table('user_role')
            ->where('id_role',2)
            ->join('user','user_role.id_user','user.id')
            ->join('customer','user_role.id','customer.id_customer')
            ->select('user.*','customer.billing')
            ->get();
        
            return response()->json($customer);

    }
    
    public function photographer_total() {

        $photographer =DB::table('user_role')
            ->where('id_role',3)
            ->join('user','user_role.id_user','=','user.id')
            ->join('photographer','user_role.id_user','=','photographer.id_photographer')
            ->select('user.*','user_role.id_role','photographer.nickname','photographer.studio_address','photographer.limitation_time','photographer.descript')
            ->get();

        return response()->json($photographer);
    }

    // dau tien la phai  loc cac booking da bi cancel //
    // xong r loc cac booking theo thang
    // xong r loc cac photographer

    public function ranking_photographer_perMonth($month) {
        $photographer = DB::table('booking')
            ->where('is_finish',1)
            ->whereMonth('start_time','=',$month)
            ->groupBy('user.username')
            ->join('user','booking.id_photographer','=','user.id')
            ->select('user.username', DB::raw('count(booking.id_photographer) as total'))
            ->orderByRaw('total DESC')
            ->get();
        
        return response()->json($photographer);
    }
}
