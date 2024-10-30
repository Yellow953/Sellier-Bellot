<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('index');
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
