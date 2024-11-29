<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Cargar diferentes vistas según el rol
        if ($user->role === 'admin') {
            return view('admin.dashboard');
        } elseif ($user->role === 'superuser') {
            return view('superuser.dashboard');
        } else {
            return view('user.dashboard');
        }
    }
}
