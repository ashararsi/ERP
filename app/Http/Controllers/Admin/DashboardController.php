<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use gernalHelper;

class DashboardController extends Controller
{
    public function index(){



        return view('dashboard');

    }
}
