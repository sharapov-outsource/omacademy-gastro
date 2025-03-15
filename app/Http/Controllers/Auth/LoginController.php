<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Maximum number of allowed login attempts before blocking the user.
     *
     * @var int
     */
    protected $maxAttempts = 3;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function username()
    {
        return 'name';
    }

    /**
     * Attempt to log the user in. Prevent login if the user is blocked.
     */
    protected function attemptLogin(Request $request)
    {
        $user = $this->guard()->getLastAttempted();

        // Check if the user is blocked
        if ($user && $user->is_blocked) {
            return false; // Prevent login for blocked users
        }

        return $this->guard()->attempt(
            $this->credentials($request),
            $request->filled('remember')
        );
    }

    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }


    /**
     * Handle a failed login attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $user = $this->guard()->getLastAttempted();

        if ($user) {
            // Increment login attempts
            $user->incrementLoginAttempts();

            // Block user if login attempts exceed the limit
            if ($user->login_attempts >= $this->maxAttempts) {
                $user->block(); // Call the `block()` method from the model
                throw ValidationException::withMessages([
                    $this->username() => [__('Your account has been blocked due to too many failed login attempts.')],
                ]);
            }
        }

        // If no user or login still fails, send default failed login response
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * Handle successful authentication.
     *
     * Reset login attempts after successful login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
        // Reset login attempts
        $user->resetLoginAttempts();

        // Additional redirects for roles (if needed)
        if ($user->isAdmin()) {
            return redirect('/admin');
        }

        return redirect($this->redirectTo);
    }
}
