<?php
namespace App\Http\Controllers\User;
use Illuminate\Http\Request;
//use Vonage\Message\Shortcode\Alert;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
class UserController extends Controller
{
    public function StaffLoginForm()
    {
        return view('user.auth.login');
    }
    public function StaffLogin(Request $request)
    {
        $credential = $request->only(['email', 'password']);
        if (Auth::guard('user')->attempt($credential, $request->filled('remember'))) {
            return redirect()->route('user.dashboard');
        } else {
            throw ValidationException::withMessages([
                'email' => 'invalid email or password'
            ]);
        }
    }
    public function StaffLogout()
    {
        Auth::guard('user')->logout();
        return redirect(route('user.login.form'));
    }

    public function Dashboard()
    {
        return view('user.dashboard');
    }
}
