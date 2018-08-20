<?php

namespace App\Http\Controllers\Auth;

use Hash;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\AccountService;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Notifications\AccountCreatedNotification;

class RegisterController extends Controller
{
    use RegistersUsers;

    // Status of account
    const INACTIVE = 'INACTIVE';

    private $accountService;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/settings';

    /**
     * Create a new controller instance.
     */
    public function __construct($accountService)
    {
        $this->middleware('guest');
        $this->accountService = $accountService;
    }

    /**
     * Get a validator for an incoming registration request.
     */
    protected function validator(array $data)
    {
        // Rules for validation
        $rules = [
            'login_register'         => 'required|string|alpha_num|min:3|max:19|unique:account.account,login',
            'email'                  => 'required|string|email|max:64|unique:account.account,email',
            'password_register'      => 'required|min:5|max:16',
            'socialid'               => 'required|numeric|digits_between:7,7',
            'terms'                  => 'required',
            'g-recaptcha-response'   => 'required|captcha',
        ];

        // Rules messages validation
        $rulesMessages = [
            'login_register.required'       => trans('pages/register.validation.login_register_required'),
            'login_register.string'         => trans('pages/register.validation.login_register_string'),
            'login_register.min'            => trans('pages/register.validation.login_register_min'),
            'login_register.max'            => trans('pages/register.validation.login_register_max'),
            'login_register.unique'         => trans('pages/register.validation.login_register_unique'),
            'login_register.alpha_num'      => trans('pages/register.validation.login_register_alpha_num'),

            'email.required'        => trans('pages/register.validation.email_required'),
            'email.string'          => trans('pages/register.validation.email_string'),
            'email.email'           => trans('pages/register.validation.email_email'),
            'email.max'             => trans('pages/register.validation.email_max'),
            'email.unique'          => trans('pages/register.validation.email_unique'),

            'password_register.required'     => trans('pages/register.validation.password_register_required'),
            'password_register.min'          => trans('pages/register.validation.password_register_min'),
            'password_register.max'          => trans('pages/register.validation.password_register_max'),

            'socialid.required'         => trans('pages/register.validation.socialid_required'),
            'socialid.numeric'          => trans('pages/register.validation.socialid_numeric'),
            'socialid.digits_between'   => trans('pages/register.validation.socialid_digits_between'),

            'terms.required'            => trans('pages/register.validation.terms'),
        ];

        return Validator::make($data, $rules, $rulesMessages);
    }

    /**
     * Create a new user instance after a valid registration.
     */
    protected function create(array $data)
    {
        $date = Carbon::now()->toDateTimeString();

        // Create user
        $user = User::create([
            'login'                  => $data['login_register'],
            'status'                 => self::INACTIVE,
            'email'                  => $data['email'],
            'password'               => Hash::make($data['password_register']),
            'pin'                    => $this->accountService->generatePinCode(),
            'social_id'              => $data['socialid'],
            'last_successful_login'  => $date,
            'verification_token'     => bin2hex(random_bytes(24))]);

        // Return user
        return $user;
    }

    /**
     * Overrirde register.
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        // Commented because we are using email verification.
        //$this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect(route('login'))->with('message', trans('auth.inactive'));
    }

    /**
     * Override registered.
     */
    protected function registered(Request $request, $user)
    {
        $user->notify(new AccountCreatedNotification($user));
    }
}
