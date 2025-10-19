<?php

namespace App\Http\Controllers\AdminAuth;

use App\Providers\RouteServiceProvider;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminAuth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function create(): View
    {
        return view('admin.auth.login');
    }

    /**
     * Handle admin login.
     */
    public function store(LoginRequest $request): RedirectResponse

    
    {
        
        // Ensure admin guard is used in login
        $request->authenticate();

        $request->session()->regenerate();

        // ✅ Redirect to admin dashboard
         return redirect()->intended(RouteServiceProvider::ADMIN_DASHBOARD);
    }

    /**
     * Handle admin logout.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

 

}

