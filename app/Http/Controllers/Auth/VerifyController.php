<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Queries\UserQueries;
use App\Services\AccountService;
use App\Http\Controllers\Controller;
use App\Jobs\Front\Account\ActivateAccount;

class VerifyController extends Controller
{
    private $accountService;
    
    public function __construct($accountService) 
    {
        $this->accountService = $accountService;
    }

    /**
     * Remind PIN code to email.
     */
    public function verify(string $login, string $token)
    {
        // Find user
        $user = UserQueries::findToVerifyByLogin($login);
        if ($user)
        {
            // Compare tokens
            $token = $this->accountService->isVerificationTokenCorrect($user, $token);
            
            // If token is correct, activate account and redirect user with message.
            if($token)
            {
                $this->dispatch(new ActivateAccount($user));
                return redirect()->route('login')->with('message', trans('auth.account_verified'));
            }
            else
            {
                return redirect()->route('login')->with('message', trans('auth.incorrect_verification_token'));
            }
        }

        // Flash error
        return redirect()->route('login')->with('message', trans('auth.account_already_verified'));
    }
}
