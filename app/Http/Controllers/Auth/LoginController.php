<?php

namespace App\Http\Controllers\Auth;

use Session;
use App\Models\User;
use Illuminate\Http\Request;
use App\Queries\UserQueries;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Use column 'login' as username.
     */
    public function username()
    {
        return 'login';
    }

    /**
     * Handle a login request to the application.
     * Override for the inactive status of account.
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the user is inactive return sendInactiveAccountResponse.
        $user = UserQueries::findByLogin($request->login);
        if ($user && $user->isInactive()) {
            return $this->sendInactiveAccountResponse($request);
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Get the needed authorization credentials from the request.
     * Override for the "PIN".
     */
    protected function credentials(Request $request)
    {
        if (config('orbit.auth.with_pin')) {
            return $request->only($this->username(), 'password', 'pin');
        } else {
            return $request->only($this->username(), 'password');
        }
    }

    /**
     * Get inactive account response instance.
     */
    protected function sendInactiveAccountResponse(Request $request)
    {
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([
                $this->username() => trans('auth.inactive'),
            ]);
    }

    /**
     * Get the failed login response instance.
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->to('/login')
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([
                $this->username() => trans('auth.failed'),
            ]);
    }

    /**
     * The user has been authenticated.
     */
    protected function authenticated(Request $request, $user)
    {
        // Get user previous session.
        $previous_session = $user->session_id;

        // Destroy previous user session.
        if ($previous_session) {
            Session::getHandler()->destroy($previous_session);
        }

        // Push new session.
        Auth::user()->session_id = Session::getId();
        Auth::user()->save();
        
        // Return to desired loaction
        return redirect()->intended($this->redirectPath());
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();
        //$request->session()->invalidate();

        return redirect('/');
    }
}
