<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index()
    {
        $logs = Log::select('text')->filter()->latest()->paginate(25);
        return view('logs.index', compact('logs'));
    }
}
