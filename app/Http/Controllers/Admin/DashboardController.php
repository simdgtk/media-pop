<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // middleware handled at the route level in this app's setup

    public function index(Request $request)
    {
        return view('article-create');
    }
}
