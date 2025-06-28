<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Article;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Office;
use App\Models\Visit;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['login', 'authenticate']);
        $this->middleware('admin')->except(['login', 'authenticate']);
    }

    public function login()
    {
        return Inertia::render('Auth/Login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function dashboard()
    {
        $stats = [
            'users' => User::count(),
            'products' => Product::count(),
            'articles' => Article::count(),
            'invoices' => Invoice::count(),
            'orders' => Order::count(),
            'offices' => Office::count(),
            'visits' => Visit::count(),
            'revenue' => 100,
        ];

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/dashboard/login');
    }
}