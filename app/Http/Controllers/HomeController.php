<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function custom_logout()
    {
        Session::flush();
        Auth::logout();

        return redirect('login');
    }

    public function download($path)
    {
        $path = public_path($path);
        if (file_exists($path)) {
            return response()->download($path);
        } else {
            return response()->json(['error' => 'File not found.'], 404);
        }
    }
}
