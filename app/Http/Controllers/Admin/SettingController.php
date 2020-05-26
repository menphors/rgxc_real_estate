<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use AppSetting;

class SettingController extends Controller
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(!\Auth::user()->isAdmin()) {
            return redirect('/');
        }
        return view('backend.setting.index');
    }

    public function getSetting()
    {
        if(!\Auth::user()->isAdmin()) {
            return redirect('/');
        }
        return view('backend.setting');
    }

    public function postSetting(Request $request)
    {
        if(!\Auth::user()->isAdmin()) {
            return redirect('/');
        }
        AppSetting::set('STORE_NAME', 'Store Name');
        AppSetting::set('STORE_ADDRESS', 'Store Address');

        return redirect(route('backend.setting'));
    }
}
