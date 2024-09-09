<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
//use Vonage\Message\Shortcode\Alert;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
class AdminController extends Controller
{
    public function AdminLoginForm()
    {
        return view('admin.auth.login');
    }
    public function AdminLogin(Request $request)
    {
        $credential = $request->only(['email', 'password']);
        if (Auth::guard('admin')->attempt($credential, $request->filled('remember'))) {
            return redirect()->route('admin.dashboard');
        } else {
            throw ValidationException::withMessages([
                'email' => 'invalid email or password'
            ]);
        }
    }
    public function AdminLogout()
    {
        Auth::guard('admin')->logout();
        return redirect(route('admin.login.form'));
    }

    public function Dashboard()
    {
        return view('admin.dashboard');
    }
}
