<?php

namespace App\Http\Controllers;

use App\Models\Progress;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $progressList = Progress::all();
        return view('welcome', compact('progressList'));
    }
}
