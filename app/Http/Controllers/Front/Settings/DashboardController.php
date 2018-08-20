<?php

namespace App\Http\Controllers\Front\Settings;

use Auth;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Show the settings page.
     */
    public function index()
    {
        return view('front.pages.account.index', ['user' => Auth::user()]);
    }
}
