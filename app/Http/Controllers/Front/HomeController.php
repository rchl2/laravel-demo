<?php

namespace App\Http\Controllers\Front;

use App\Queries\NewsQueries;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function homePage()
    {
        return view('front.home', ['news' => NewsQueries::latestForHomepage()]);
    }
}
