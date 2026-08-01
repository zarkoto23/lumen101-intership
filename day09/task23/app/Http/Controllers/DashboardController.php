<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $enrollments = $user->enrollments()
            ->with('course')
            ->latest()
            ->get();


        return view('dashboard', compact('enrollments'));
    }
}