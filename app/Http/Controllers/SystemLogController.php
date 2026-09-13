<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SystemLogController extends Controller
{
    public function index()
    {
        $logs = \App\Models\SystemLog::with('user')->latest()->paginate(10);
        return view('admin.logs.index', compact('logs'));
    }
}
