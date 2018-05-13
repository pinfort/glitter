<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lib\Glitter\GitLab;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account = \App\LinkedSocialAccount::where('user_id', \Auth::user()->id)->where('provider_name', 'gitlab')->first();
        return view('home', ['account' => $account]);
    }

    public function deleteAccount()
    {
        $user = \Auth::user();
        // if (is_null($user)) {
        //     return redirect(route('login'));
        // }
        $id = $user->id;
        \Log::info($id);
        \App\LinkedSocialAccount::where('user_id', $id)->delete();
        $user->delete();
        \Auth::logout();
        return redirect()->to('/');
    }
}
